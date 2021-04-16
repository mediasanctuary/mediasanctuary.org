<?php
/**
 * Implements the methods shared by Meetings and Webinars.
 *
 * @since   1.1.1
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */

namespace Tribe\Events\Virtual\Meetings\Zoom;

use Tribe\Events\Virtual\Event_Meta as Virtual_Events_Meta;
use Tribe\Events\Virtual\Meetings\Zoom\Event_Meta as Zoom_Meta;
use Tribe__Date_Utils as Dates;
use Tribe__Timezones as Timezones;

/**
 * Class Abstract_Meetings
 *
 * @since   1.1.1
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */
class Abstract_Meetings {
	/**
	 * The  integer value associated to the Scheduled meeting type.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @link  https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingcreate
	 */
	const TYPE_MEETING_SCHEDULED = 2;

	/**
	 * The name of the action used to generate a meeting creation link.
	 * The property also provides a reasonable default for the abstract class.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @var string
	 */
	public static $create_action = 'events-virtual-meetings-zoom-meeting-create';

	/**
	 * The name of the action used to remove a meeting creation link.
	 * The property also provides a reasonable default for the abstract class.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @var string
	 */
	public static $remove_action = 'events-virtual-meetings-zoom-meeting-remove';

	/**
	 * The type of the meeting handled by the class instance.
	 * Defaults to the Meetings one.
	 *
	 * @since 1.1.1
	 *
	 * @var string
	 */
	public static $meeting_type = 'meeting';

	/**
	 * The Zoom API endpoint used to create and manage the meeting.
	 * Defaults to the one used for Meetings.
	 *
	 * @since 1.1.1
	 *
	 * @var string
	 */
	public static $api_endpoint = 'meetings';

	/**
	 * The URL that will contain the meeting join instructions.
	 * Defaults to the one used for Meetings.
	 *
	 * @since 1.1.1
	 *
	 * @var string
	 */
	protected static $join_instructions_url = 'https://support.zoom.us/hc/en-us/articles/201362193-Joining-a-Meeting';

	/**
	 * An instance of the Zoom API handler.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @var Api
	 */
	protected $api;

	/**
	 * The Classic Editor rendering handler.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @var Classic_Editor
	 */
	protected $classic_editor;

	/**
	 * Meetings constructor.
	 *
	 * @since 1.0.0
	 * @since 1.0.2 - Add the Password Class
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @param Api            $api            An instance of the Zoom API handler.
	 * @param Classic_Editor $classic_editor An instance of the Classic Editor rendering handler.
	 * @param Password       $password       An instance of the Password handler.
	 */
	public function __construct( Api $api, Classic_Editor $classic_editor, Password $password ) {
		$this->api            = $api;
		$this->classic_editor = $classic_editor;
		$this->password       = $password;
	}

	/**
	 * Handles the request to generate a Zoom meeting.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Moved to the Tribe\Events\Virtual\Meetings\Zoom\Abstract_Meetings class.
	 *
	 * @param string|null $nonce The nonce that should accompany the request.
	 *
	 * @return bool Whether the request was handled or not.
	 */
	public function ajax_create( $nonce = null ) {
		if ( ! $this->check_ajax_nonce( static::$create_action, $nonce ) ) {
			return false;
		}

		$event = $this->check_ajax_post();

		if ( ! $event ) {
			return false;
		}

		$post_id = $event->ID;
		$cached  = get_post_meta( $post_id, Virtual_Events_Meta::$prefix . 'zoom_meeting_data', true );

		/**
		 * Filters whether to force the recreation of the Zoom meetings link on each request or not.
		 *
		 * If the filters returns a truthy value, then each request, even for events that already had a Zoom meeting
		 * generated, will generate a new link, without re-using the previous one.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $force   Whether to force the regeneration of Zoom Meeting links or not.
		 * @param int  $post_id The post ID of the event the Meeting is being generated for.
		 */
		$force = apply_filters(
			"tribe_events_virtual_meetings_zoom_{$this::$meeting_type}_force_recreate",
			true,
			$post_id
		);

		if ( ! $force && ! empty( $cached ) ) {
			$this->classic_editor->render_meeting_link_generator( $event );

			wp_die();

			return true;
		}

		// Get the password requirements for Meetings.
		$password_requirements = $this->password->get_password_requirements();

		/**
		 * Filters the password for the Zoom Meeting.
		 *
		 * @since 1.0.2
		 *
		 * @param null|string|int   The password for the Zoom Meeting.
		 * @param array    $password_requirements An array of password requirements from Zoom.
		 * @param \WP_Post $event                 The event post object, as decorated by the `tribe_get_event` function.
		 */
		$password = apply_filters(
			"tribe_events_virtual_meetings_zoom_{$this::$meeting_type}_password",
			null,
			$password_requirements,
			$event
		);

		/**
		 * If this is a new post, then the duration will not be available.
		 * Since meetings that have a duration of 0 will not be editable after their creation,
		 * let's ensure a default 60 minutes duration to come back and edit the meeting later.
		 */
		$duration = (int) ceil( (int) $event->duration / 60 );
		$duration = $duration ? (int) $duration : 60;

		$body = [
			'topic'      => $event->post_title,
			'type'       => self::TYPE_MEETING_SCHEDULED,
			'start_time' => $event->dates->start->format( 'Y-m-d\TH:i:s' ),
			'timezone'   => $event->timezone,
			'duration'   => $duration,
			'password'   => $password,
		];

		/**
		 * Filters the contents of the request that will be made to the Zoom API to generate a meeting link.
		 *
		 * @since 1.0.0
		 *
		 * @param array<string,mixed> The current content of the request body.
		 * @param \WP_Post $event The event post object, as decorated by the `tribe_get_event` function.
		 * @param Meetings $this  The current API handler object instance.
		 */
		$body = apply_filters(
			"tribe_events_virtual_meetings_zoom_{$this::$meeting_type}_request_body",
			$body,
			$event,
			$this
		);

		$success = false;

		$this->api->post(
			Api::$api_base . "users/me/{$this::$api_endpoint}",
			[
				'headers' => [
					'authorization' => $this->api->token_authorization_header(),
					'content-type'  => 'application/json; charset=utf-8',
				],
				'body'    => wp_json_encode( $body ),
			],
			Api::POST_RESPONSE_CODE
		)->then(
			function ( array $response ) use ( $post_id, &$success ) {
				$this->process_meeting_creation_response( $response, $post_id );

				$event = tribe_get_event( $post_id );
				$this->classic_editor->render_meeting_link_generator( $event );

				$success = true;

				wp_die();
			}
		)->or_catch(
			function ( \WP_Error $error ) use ( $event ) {
				do_action(
					'tribe_log',
					'error',
					__CLASS__,
					[
						'action'  => __METHOD__,
						'code'    => $error->get_error_code(),
						'message' => $error->get_error_message(),
					]
				);

				$error_data    = wp_json_encode( $error->get_error_data() );
				$decoded       = json_decode( $error_data, true );
				$error_message = null;
				if ( false !== $decoded && is_array( $decoded ) && isset( $decoded['message'] ) ) {
					$error_message = $decoded['message'];
				}

				$this->classic_editor->render_meeting_generation_error_details( $event, $error_message, true );

				wp_die();
			}
		);

		return $success;
	}

	/**
	 * Checks if the current AJAX request is valid and authorized or not.
	 *
	 * In a normal flow, where the AJAX response is not intercepted by an handler, the method will echo an error data
	 * and `die`.
	 *
	 * @since 1.0.0
	 *
	 * @param string      $action The action to check the AJAX referer and the nonce against.
	 * @param string|null $nonce  The nonce to check, the `null` value is allowed and will always fail.
	 *
	 * @return bool Whether the AJAX referer and nonce are valid or not.
	 */
	protected function check_ajax_nonce( $action, $nonce = null ) {
		if (
			! check_ajax_referer( $action )
			|| ! wp_verify_nonce( $nonce, $action )
		) {
			wp_send_json_error(
				[
					'status'  => 'fail',
					'code'    => 'invalid-nonce',
					'message' => _x( 'The provided nonce is not valid.', 'Ajax error message.', 'events-virtual' ),
				],
				403
			);

			return false;
		}

		return true;
	}

	/**
	 * Checks the request post ID is set and corresponds to an event.
	 *
	 * While the method will return a boolean value, in the normal flow, where AJAX requests are not intercepted by
	 * handlers, the method will return the failure JSON response and `die`.
	 *
	 * @since 1.0.0
	 *
	 * @param int|null $post_id The post ID of the post to check or `null` to use the one from the request variable.
	 *
	 * @return \WP_Post|false Either the event post object, as decorated by the `tribe_get_event` function, or `false`
	 *                        if AJAX responses are handled and the post is not valid.
	 */
	protected function check_ajax_post( $post_id = null ) {
		$post_id = $post_id ? $post_id : tribe_get_request_var( 'post_id', false );

		if ( empty( $post_id ) ) {
			$error = _x(
				'The post ID is missing from the request.',
				'An error raised in the context of the Zoom API integration.',
				'events-virtual'
			);

			wp_send_json_error(
				[
					'status'  => 'fail',
					'code'    => 'missing-post-id',
					'message' => $error,
				],
				400
			);

			return false;
		}

		$event = tribe_get_event( $post_id );

		if ( ! $event instanceof \WP_Post ) {
			wp_send_json_error(
				[
					'status' => 'fail',
					'code'   => 'event-not-found',
				],
				404
			);

			return false;
		}

		return $event;
	}

	/**
	 * Processes the Zoom API Meeting creation response to massage, filter and save the data.
	 *
	 * @since 1.0.0
	 *
	 * @param array<string,mixed> $response The entire Zoom API response.
	 * @param int                 $post_id  The event post ID.
	 *
	 * @return array<string,mixed> The Zoom Meeting data.
	 */
	protected function process_meeting_creation_response( array $response, $post_id ) {
		if ( ! (
			isset( $response['body'] )
			// phpcs:ignore
			&& false !== ( $body = json_decode( $response['body'], true ) )
			&& isset( $body['join_url'], $body['id'] )
		) ) {
			do_action(
				'tribe_log',
				'error',
				__CLASS__,
				[
					'action'   => __METHOD__,
					'message'  => "Zoom API {$this::$meeting_type} creation response is malformed.",
					'response' => $response,
				]
			);

			return [];
		}

		$data = $this->prepare_meeting_data( $body );
		$this->update_post_meta( $post_id, $body, $data );

		return $data;
	}

	/**
	 * Filters and massages the meeting data to prepare it to be saved in the post meta.
	 *
	 * @since 1.0.0
	 * @since 1.0.2 - Added Password and Password Hash to $data.
	 *
	 * @param array<string,mixed> $body The response body, in raw format.
	 *
	 * @return array<string,mixed> The meeting data, massaged and filtered.
	 */
	protected function prepare_meeting_data( $body ) {

		$hash_pwd = tribe( Password::class )->get_hash_pwd_from_join_url( $body['join_url'] );

		$data = [
			'id'                => $body['id'],
			'join_url'          => $body['join_url'],
			'join_instructions' => static::$join_instructions_url,
			'password_hash'     => $hash_pwd,
			'password'          => $body['password'],
		];

		// Dial-in numbers are NOT a given and should not be assumed.
		if ( ! empty( $body['settings']['global_dial_in_numbers'] ) ) {
			// If there are dial-in numbers, there might be more than one.
			$dial_in_data                        = (array) $body['settings']['global_dial_in_numbers'];
			$data['global_dial_in_numbers_data'] = $dial_in_data;
			$data['global_dial_in_numbers']      = array_combine(
				array_column( $dial_in_data, 'number' ),
				array_column( $dial_in_data, 'country' )
			);
		}

		/**
		 * Filters the Zoom API meeting data after a successful meeting creation.
		 *
		 * @since 1.0.0
		 *
		 * @param array<string,mixed> $data The data that will be returned in the AJAX response.
		 * @param array<string,mixed> $body The raw data returned from the Zoom API for the request.
		 */
		$data = apply_filters( "tribe_events_virtual_meetings_zoom_{$this::$meeting_type}_data", $data, $body );

		return $data;
	}

	/**
	 * Updates the event post meta depending on the meeting data provided.
	 *
	 * @since 1.0.0
	 *
	 * @param int                 $post_id       The post ID of the event to update the Zoom Meeting related meta for.
	 * @param array<string,mixed> $response_body The Zoom API response body, as received from it.
	 * @param array<string,mixed> $meeting_data  The Zoom Meeting data, as returned from the Zoom API request.
	 */
	protected function update_post_meta( $post_id, array $response_body, array $meeting_data ) {
		$prefix = Virtual_Events_Meta::$prefix;

		// Cache the raw meeting data for future use.
		update_post_meta( $post_id, $prefix . 'zoom_meeting_data', $response_body );

		$map = [
			$prefix . 'zoom_meeting_id'             => 'id',
			$prefix . 'zoom_join_url'               => 'join_url',
			$prefix . 'zoom_join_instructions'      => 'join_instructions',
			$prefix . 'zoom_global_dial_in_numbers' => 'global_dial_in_numbers',
			$prefix . 'zoom_password_hash'          => 'password_hash',
			$prefix . 'zoom_password'               => 'password',
		];

		foreach ( $map as $meta_key => $data_key ) {
			if ( isset( $meeting_data[ $data_key ] ) ) {
				update_post_meta( $post_id, $meta_key, $meeting_data[ $data_key ] );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}

		// Add the meeting type, it's not part of the data coming from Zoom.
		update_post_meta( $post_id, $prefix . 'zoom_meeting_type', static::$meeting_type );
	}

	/**
	 * Handles the AJAX request to remove the Zoom Meeting information from an event.
	 *
	 * @since 1.0.0
	 *
	 * @param string|null $nonce The nonce that should accompany the request.
	 *
	 * @return bool Whether the request was handled or not.
	 */
	public function ajax_remove( $nonce = null ) {
		if ( ! $this->check_ajax_nonce( static::$remove_action, $nonce ) ) {
			return false;
		}

		// phpcs:ignore
		if ( ! $event = $this->check_ajax_post() ) {
			return false;
		}

		// Remove the meta, but not the data.
		Zoom_Meta::delete_meeting_meta( $event->ID );

		// Send the HTML for the meeting creation.
		$this->classic_editor->render_meeting_link_generator( $event );

		wp_die();

		return true;
	}

	/**
	 * Handles update of Zoom meeting when Event details change.
	 *
	 * @since 1.0.2
	 * @since 1.2.0 Utilize the datepicker format when parse the Event Date to prevent the wrong date in Zoom.
	 *
	 * @param \WP_Post|int $event The event (or event ID) we're updating the meeting for.
	 *
	 * @return void
	 */
	public function update( $event ) {
		$event = tribe_get_event( $event );

		// There is no meeting to update.
		if ( ! ( $event instanceof \WP_Post ) || empty( $event->zoom_meeting_id ) ) {
			return;
		}
		$start_date = tribe_get_request_var( 'EventStartDate' );
		if ( empty( $start_date ) ) {
			$start_date = $event->start_date;
		}

		$start_time = tribe_get_request_var( 'EventStartTime' );
		if ( empty( $start_time ) ) {
			$start_time = $event->start_time;
		}

		$time_zone = tribe_get_request_var( 'EventTimezone' );
		if ( empty( $time_zone ) ) {
			$time_zone = $event->timezone;
		}

		$zoom_date = $this->format_date_for_zoom( $start_date, $start_time, $time_zone );

		// Note the time format - because Zoom stores all dates as UTC with the trailing 'Z'.
		$event_body = [
			'topic'      => $event->post_title,
			'start_time' => $zoom_date,
			'timezone'   => $time_zone,
			'duration'   => (int) ceil( (int) $event->duration / 60 ),
		];

		$meeting_data = get_post_meta( $event->ID, Virtual_Events_Meta::$prefix . 'zoom_meeting_data', true );
		$meeting_body = [
			'topic'      => $meeting_data['topic'],
			'start_time' => $meeting_data['start_time'],
			'timezone'   => $meeting_data['timezone'],
			'duration'   => $meeting_data['duration'],
		];

		$diff = array_diff_assoc( $event_body, $meeting_body );

		// Nothing to update.
		if ( empty( $diff ) ) {
			return;
		}

		$post_id = $event->ID;

		/**
		 * Filters the contents of the request that will be made to the Zoom API to update a meeting link.
		 *
		 * @since 1.0.2
		 *
		 * @param array<string,mixed> The current content of the request body.
		 * @param \WP_Post $event The event post object, as decorated by the `tribe_get_event` function.
		 * @param Meetings $this  The current API handler object instance.
		 */
		$body = apply_filters(
			"tribe_events_virtual_meetings_zoom_{$this::$meeting_type}_update_request_body",
			$event_body,
			$event,
			$this
		);

		// Update.
		$this->api->patch(
			Api::$api_base . "{$this::$api_endpoint}/{$event->zoom_meeting_id}",
			[
				'headers' => [
					'Authorization' => $this->api->token_authorization_header(),
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'    => wp_json_encode( $body ),
			],
			Api::PATCH_RESPONSE_CODE
		)->then(
			function ( array $response ) use ( $post_id, $event ) {
				$this->process_meeting_update_response( $response, $event, $post_id );
			}
		)->or_catch(
			function ( \WP_Error $error ) use ( $event ) {
				do_action(
					'tribe_log',
					'error',
					__CLASS__,
					[
						'action'  => __METHOD__,
						'code'    => $error->get_error_code(),
						'message' => $error->get_error_message(),
					]
				);

				$error_data    = wp_json_encode( $error->get_error_data() );
				$decoded       = json_decode( $error_data, true );
				$error_message = null;
				if ( false !== $decoded && is_array( $decoded ) && isset( $decoded['message'] ) ) {
					$error_message = $decoded['message'];
				}

				// Do something to indicate failure with $error_message?
				$this->classic_editor->render_meeting_generation_error_details( $event, $error_message, true );
			}
		);
	}

	/**
	 * Processes the Zoom API Meeting update response to massage, filter and save the data.
	 *
	 * @since 1.0.2
	 *
	 * @param array<string,mixed> $response The entire Zoom API response.
	 * @param \WP_Post            $event    The event post object.
	 * @param int                 $post_id  The event post ID.
	 *
	 * @return array<string,mixed>|false The Zoom Meeting data or `false` on error.
	 */
	protected function process_meeting_update_response( $response, $event, $post_id ) {
		if ( empty( $response['response']['code'] ) || 204 !== $response['response']['code'] ) {
			return false;
		}

		$event = tribe_get_event( $event );
		if ( ! $event instanceof \WP_Post ) {
			return false;
		}

		$success = false;

		$this->api->get(
			Api::$api_base . "{$this::$api_endpoint}/{$event->zoom_meeting_id}",
			[
				'headers' => [
					'Authorization' => $this->api->token_authorization_header(),
					'Content-Type'  => 'application/json; charset=utf-8',
				],
			],
			Api::GET_RESPONSE_CODE
		)->then(
			function ( array $response ) use ( $post_id, &$success ) {
				$body = json_decode( $response['body'], true );

				// If the response is empty, then do not update the post.
				if ( ! empty( $body ) && is_array( $body ) ) {
					$data = $this->prepare_meeting_data( $body );
					$this->update_post_meta( $post_id, $body, $data );
				}

				$success = true;
			}
		)->or_catch(
			function ( \WP_Error $error ) use ( $event ) {
				do_action(
					'tribe_log',
					'error',
					__CLASS__,
					[
						'action'  => __METHOD__,
						'code'    => $error->get_error_code(),
						'message' => $error->get_error_message(),
					]
				);

				$error_data    = wp_json_encode( $error->get_error_data() );
				$decoded       = json_decode( $error_data, true );
				$error_message = null;
				if ( false !== $decoded && is_array( $decoded ) && isset( $decoded['message'] ) ) {
					$error_message = $decoded['message'];
				}

				$this->classic_editor->render_meeting_generation_error_details( $event, $error_message, true );
			}
		);

		return $success;
	}

	/**
	 * Format the event start date for zoom.
	 *
	 * @since 1.2.0
	 *
	 * @param string $start_date The start date of the event.
	 * @param string $start_time The start time of the event.
	 * @param string $time_zone  The timezone of the event.
	 *
	 * @return string The time formatted for Zoom using 'Y-m-d\TH:i:s\Z'.
	 */
	public function format_date_for_zoom( $start_date, $start_time, $time_zone ) {
		$timezone_object = Timezones::build_timezone_object( 'UTC' );
		// Utilize the datepicker format when parse the Event Date to prevent the wrong date in Zoom.
		$datepicker_format = Dates::datepicker_formats( tribe_get_option( 'datepickerFormat' ) );
		$start_date_time   = Dates::datetime_from_format( $datepicker_format, $start_date ) . ' ' . $start_time;

		return Dates::build_date_object( $start_date_time, $time_zone )->setTimezone( $timezone_object )->format( 'Y-m-d\TH:i:s\Z' );
	}
}
