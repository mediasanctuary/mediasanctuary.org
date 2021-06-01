<?php
/**
 * Handles the rendering of the Classic Editor controls.
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */

namespace Tribe\Events\Virtual\Meetings\Zoom;

use Tribe\Events\Virtual\Admin_Template;
use Tribe\Events\Virtual\Event_Meta as Virtual_Meta;
use Tribe\Events\Virtual\Meetings\Zoom\Event_Meta as Zoom_Meta;
use Tribe\Events\Virtual\Metabox;
use Tribe__Utils__Array as Arr;

/**
 * Class Classic_Editor
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */
class Classic_Editor {
	/**
	 * The URLs handler for the integration.
	 *
	 * @since 1.0.0
	 *
	 * @var Url
	 */
	protected $url;

	/**
	 * The template handler instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Admin_Template
	 */
	protected $template;

	/**
	 * An instance of the Zoom API handler.
	 *
	 * @since 1.0.0
	 *
	 * @var Api
	 */
	protected $api;

	/**
	 * Classic_Editor constructor.
	 *
	 * @param Url            $url      The URLs handler for the integration.
	 * @param Api            $api      An instance of the Zoom API handler.
	 * @param Admin_Template $template An instance of the Template class to handle the rendering of admin views.
	 */
	public function __construct( Url $url, Api $api, Admin_Template $template ) {
		$this->url = $url;
		$this->api = $api;
		$this->template = $template;
	}

	/**
	 * Renders, echoing to the page, the Zoom API meeting generator controls.
	 *
	 * @since 1.0.0
	 * @since 1.4.0 - Add ability to force the meeting and webinar generator.
	 *
	 * @param null|\WP_Post|int $post            The post object or ID of the event to generate the controls for, or `null` to use
	 *                                           the global post object.
	 * @param bool              $echo            Whether to echo the template contents to the page (default) or to return it.
	 * @param bool              $force_generator Whether to force to display the meeting and webinar generator.
	 *
	 * @return string The template contents, if not rendered to the page.
	 */
	public function render_meeting_link_generator( $post = null, $echo = true, $force_generator = false ) {
		$post = tribe_get_event( get_post( $post ) );

		if ( ! $post instanceof \WP_Post ) {
			return '';
		}

		// Make sure to apply the Zoom properties to the event.
		Zoom_Meta::add_event_properties( $post );

		$candidate_types = [
			// Always allow by default.
			'meeting' => true,
			// Allow the generation only if the account has the correct caps.
			'webinar' => $this->api->allow_webinars(),
		];
		$available_types = [];

		foreach ( $candidate_types as $type => $allow ) {
			/**
			 * Allow filtering whether to allow link generation and to show controls for a meeting type.
			 * This will continue to allow previously generated links to be seen and removed.
			 *
			 * @since 1.1.1
			 *
			 * @param boolean  $allow Whether to allow link generation.
			 * @param \WP_Post $post  The post object of the Event context of the link generation.
			 */
			$allow = apply_filters( "tribe_events_virtual_zoom_{$type}_link_allow_generation", $allow, $post );

			if ( tribe_is_truthy( $allow ) ) {
				$available_types[] = $type;
			}
		}

		$allow_link_gen = count( $available_types ) > 0;

		if ( $this->api->is_authorized() ) {
			$meeting_link = tribe( Password::class )->get_zoom_meeting_link( $post );

			if ( ! empty( $meeting_link ) && ! $force_generator ) {
				// Enqueue the accordion script required to show the UI correctly, we might need it if link is removed.
				tribe_asset_enqueue( 'tribe-events-views-v2-accordion' );

				return $this->render_meeting_details( $post, $echo );
			}

			// Do not show the link generation controls if not allowed for any type.
			if ( false === $allow_link_gen ) {
				return '';
			}

			// Enqueue the accordion script required to show the UI correctly.
			tribe_asset_enqueue( 'tribe-events-views-v2-accordion' );

			if ( count( $available_types ) > 0 ) {
				// Meetings and Webinars.
				return $this->render_multiple_links_generator( $post, $echo );
			}

			// Fallback to not rendering anything.
			return '';
		}

		// Do not show the API connection/authorization controls if it is not allowed.
		if ( false === $allow_link_gen ) {
			return '';
		}

		return $this->render_api_connection_link( $post, $echo );
	}

	/**
	 * Renders, echoing to the page, the Zoom API meeting display controls.
	 *
	 * @since 1.0.0
	 *
	 * @param null|\WP_Post|int $post The post object or ID of the event to generate the controls for, or `null` to use
	 *                                the global post object.
	 * @param bool              $echo Whether to echo the template contents to the page (default) or to return it.
	 *
	 * @return string The template contents, if not rendered to the page.
	 */
	public function render_classic_display_controls( $post = null, $echo = true ) {
		return $this->template->template(
			'virtual-metabox/zoom/display',
			[
				'event'      => $post,
				'metabox_id' => Metabox::$id,
			],
			$echo
		);
	}

	/**
	 * Renders the error details shown to the user when a Zoom Meeting link generation fails.
	 *
	 * @since 1.0.0
	 *
	 * @param int|\WP_Post $event      The event ID or object.
	 * @param string       $error_body The error details in human-readable form. This can contain HTML
	 *                                 tags (e.g. links).
	 * @param bool         $echo       Whether to echo the template to the page or not.
	 *
	 * @return string The rendered template contents.
	 */
	public function render_meeting_generation_error_details( $event = null, $error_body = null, $echo = true ) {
		$event = tribe_get_event( $event );

		if ( ! $event instanceof \WP_Post ) {
			return '';
		}

		$is_authorized = $this->api->is_authorized();

		$remove_link_url = empty( $event->zoom_meeting_type ) || Webinars::$meeting_type !== $event->zoom_meeting_type ?
			$this->url->to_remove_meeting_link( $event )
			: $this->url->to_remove_webinar_link( $event );

		$remove_link_label = _x(
			'Remove Zoom link',
			'The label for the admin UI control that allows removing the Zoom Meeting or Webinar link from the event.',
			'events-virtual'
		);

		$link_url   = $is_authorized
			? $this->url->to_generate_meeting_link( $event )
			: Settings::admin_url();
		$link_label = $is_authorized
			? _x(
				'Try again',
				'The label of the button to try and generate a Zoom Meeting or Webinar link again.',
				'events-virtual'
			)
			: $this->get_connect_to_zoom_label();

		if ( null === $error_body ) {
			$error_body = $this->get_unknown_error_message();
		}
		$error_body = wpautop( $error_body );

		return $this->template->template(
			'virtual-metabox/zoom/meeting-link-error-details',
			[
				'remove_link_url'   => $remove_link_url,
				'remove_link_label' => $remove_link_label,
				'is_authorized'     => $is_authorized,
				'error_body'        => $error_body,
				'link_url'          => $link_url,
				'link_label'        => $link_label,
			],
			$echo
		);
	}

	/**
	 * Returns the localized, but not HTML-escaped, message to set up the Zoom integration.
	 *
	 * @since 1.0.0
	 *
	 * @return string The localized, but not HTML-escaped, message to set up the Zoom integration.
	 */
	protected function get_connect_to_zoom_label() {
		return _x(
			'Set up Zoom integration',
			'Label for the link to set up the Zoom integration in the event classic editor UI.',
			'events-virtual'
		);
	}

	/**
	 * Returns the generic message to indicate an error to perform an action in the context of the Zoom API
	 * integration.
	 *
	 * @since 1.0.0
	 *
	 * @return string The error message, unescaped.
	 */
	protected function get_unknown_error_message() {
		return _x(
			'Unknown error',
			'A message to indicate an unknown error happened while interacting with the Zoom API integration.',
			'events-virtual'
		);
	}

	/**
	 * Renders the link generator HTML for 2+ Zoom Meeting types (e.g. Webinars and Meetings).
	 *
	 * Currently the available types are, at the most, 2: Meetings and Webinars. This method might need to be
	 * updated in the future if that assumption changes. If this method runs, then it means that we should render
	 * generation links for both type of meetings.
	 *
	 * @since 1.1.1
	 * @since 1.4.0 A support to choose a host before meeting or webinar creation.
	 *
	 * @param \WP_Post $post The post object of the Event context of the link generation.
	 * @param bool     $echo Whether to print the rendered HTML to the page or not.
	 *
	 * @return string|false Either the final content HTML or `false` if the template could be found.
	 */
	public function render_multiple_links_generator( \WP_Post $post, $echo = true ) {
		/**
		 * Filters the host list to use to assign to Zoom Meetings and Webinars.
		 *
		 * @since 1.4.0
		 *
		 * @param array<string,mixed>  An array of Zoom Users to use as the host.
		 */
		$hosts = apply_filters( 'tribe_events_virtual_meetings_zoom_hosts', [] );

		return $this->template->template(
			'virtual-metabox/zoom/setup',
			[
				'event'                   => $post,
				'offer_or_label'          => _x(
					'or',
					'The lowercase "or" label used to offer the creation of a Zoom Meetings or Webinars API link.',
					'events-virtual'
				),
				'generation_toogle_label' => _x(
					'Generate Zoom Link',
					'The label of the toggle to show the links to generate Zoom Meetings or Webinars.',
					'events-virtual'
				),
				'generation_urls'         => $this->get_link_generation_urls( $post, false ),
				'generate_label'        => _x(
					'Next ',
					'The label used to designate the next step in generation of a Zoom Meeting or Webinar.',
					'events-virtual'
				),
				'hosts' => [
					'label'       => _x(
						'Meeting Host',
						'The label of the meeting or webinar host.',
						'events-virtual'
					),
					'id'          => 'tribe-events-virtual-zoom-host',
					'class'       => 'tribe-events-virtual-meetings-zoom__host-dropdown',
					'name'        => 'tribe-events-virtual-zoom-host',
					'selected'    =>  $post->zoom_host_id,
					'attrs'       => [
						'placeholder' => _x(
						    'Select a Host',
						    'The placeholder for the dropdown to select a host.',
						    'events-virtual'
						),
						'data-selected' => $post->zoom_host_id,
						'data-prevent-clear' => true,
						'data-hide-search' => true,
						'data-options' => json_encode( $hosts ),
					],
				],
			],
			$echo
		);
	}

	/**
	 * Returns the link generation URLs and label for a post.
	 *
	 * @since 1.1.1
	 *
	 * @param \WP_Post $post                  The post object of the Event context of the link generation.
	 * @param bool     $include_generate_text Whether to include the "Generate" text in the labels or not.
	 *
	 * @return array<string,array<string>> A map (by meeting type) of unpackable arrays, each one containing the URL and
	 *                                     label for the generation link HTML code.
	 */
	protected function get_link_generation_urls( \WP_Post $post, $include_generate_text = false ) {
		// Do not make these dynamic or "smart" in any way: "Generate" might not be a prefix in some languages.
		$w_generate_meeting_label  = _x(
			'Generate Zoom Meeting',
			'Label for the control to generate a Zoom meeting link in the event classic editor UI.',
			'events-virtual'
		);
		$wo_generate_meeting_label = _x(
			'Meeting',
			'Label for the control to generate a Zoom meeting link in the event classic editor UI, w/o the "Generate" prefix.',
			'events-virtual'
		);
		$w_generate_webinar_label  = _x(
			'Generate Zoom Webinar',
			'Label for the control to generate a Zoom webinar link in the event classic editor UI.',
			'events-virtual'
		);
		$wo_generate_webinar_label = _x(
			'Webinar',
			'Label for the control to generate a Zoom webinar link in the event classic editor UI, w/o the "Generate" prefix.',
			'events-virtual'
		);

		$data = [
			Meetings::$meeting_type => [
				$this->url->to_generate_meeting_link( $post ),
				$include_generate_text ? $w_generate_meeting_label : $wo_generate_meeting_label,
			]
		];

		// Add webinar if supported.
		if ( $this->api->allow_webinars() ) {
			$data[ Webinars::$meeting_type ] = [
				$this->url->to_generate_webinar_link( $post ),
				$include_generate_text ? $w_generate_webinar_label : $wo_generate_webinar_label,
			];
		}

		/**
		 * Allows filtering the generation links URL and label before rendering them on the admin UI.
		 *
		 * @since 1.1.1
		 *
		 * @param array<string,array<string>> A map (by meeting type) of unpackable arrays, each one containing the URL and
		 *                                    label for the generation link HTML code.
		 * @param \WP_Post $post              The post object of the Event context of the link generation.
		 */
		$data = apply_filters( 'tribe_events_virtual_zoom_meeting_link_generation_urls', $data, $post );

		return $data;
	}

	/**
	 * Renders an existing Meeting details.
	 *
	 * @since 1.1.1
	 *
	 * @param \WP_Post $post         The post object of the Event context of the link generation.
	 * @param bool     $echo         Whether to print the rendered HTML to the page or not.
	 *
	 * @return string|false Either the final content HTML or `false` if the template could be found.
	 */
	protected function render_meeting_details( \WP_Post $post, $echo = true ) {
		$remove_link_url   = $this->url->to_remove_meeting_link( $post );
		$remove_link_label = _x(
			'Remove Zoom link',
			'The label for the admin UI control that allows removing the Zoom Meeting or Webinar link from the event.',
			'events-virtual'
		);

		// Display a different details title depending on the type of meeting.
		$meeting_type = empty( $post->zoom_meeting_type ) || Webinars::$meeting_type !== $post->zoom_meeting_type
			? Meetings::$meeting_type
			: Webinars::$meeting_type;

		// Set the url to update the meeting or webinar using AJAX.
		$update_link_url = Webinars::$meeting_type === $meeting_type
			?  $this->url->to_update_webinar_link( $post )
			:  $this->url->to_update_meeting_link( $post );

		$details_title = Webinars::$meeting_type === $meeting_type
			? _x(
				'Zoom Webinar',
				'Title of the details box shown for a generated Zoom Webinar link in the backend.',
				'events-virtual'
			)
			: _x(
				'Zoom Meeting',
				'Title of the details box shown for a generated Zoom Meeting link in the backend.',
				'events-virtual'
			);

		/**
		 * Filters the host list to use to assign to Zoom Meetings and Webinars.
		 *
		 * @since 1.4.0
		 *
		 * @param array<string,mixed>   An array of Zoom Users to use as the alternative hosts.
		 * @param string $selected_alt_hosts The list of alternative host emails.
		 * @param string $current_host       The email of the current host.
		 */
		$alt_hosts = apply_filters( 'tribe_events_virtual_meetings_zoom_alternative_hosts', [], $post->zoom_alternative_hosts, $post->zoom_host_email );

		return $this->template->template(
			'virtual-metabox/zoom/details',
			[
				'event'                 => $post,
				'details_title'         => $details_title,
				'update_link_url'       => $update_link_url,
				'remove_link_url'       => $remove_link_url,
				'remove_link_label'     => $remove_link_label,
				'host_label'            => _x(
					'Host: ',
					'The label used to designate the host of a Zoom Meeting or Webinar.',
					'events-virtual'
				),
				'attrs'       => [
					'data-update-url'         => $update_link_url,
					'data-zoom-id'            => $post->zoom_meeting_id,
					'data-selected-alt-hosts' => $post->zoom_alternative_hosts,
				],
				'zoom_id'               => $post->zoom_meeting_id,
				'id_label'              => _x(
					'ID: ',
					'The label used to prefix a Zoom Meeting or Webinar ID in the backend.',
					'events-virtual'
				),
				'phone_numbers'         => array_filter(
					(array) get_post_meta( $post->ID, Virtual_Meta::$prefix . 'zoom_global_dial_in_numbers', true )
				),
				'selected_alt_hosts'    => $post->zoom_alternative_hosts,
				'alt_hosts'             => [
					'label'       => _x(
						'Alternative Hosts',
						'The label of the alternative host multiselect',
						'events-virtual'
					),
					'id'          => 'tribe-events-virtual-zoom-alt-host',
					'name'        => 'tribe-events-virtual-zoom-alt-host[]',
					'class'       => 'tribe-events-virtual-meetings-zoom__alt-host-multiselect',
					'selected'    => $post->zoom_alternative_hosts,
					'attrs'       => [
						'data-placeholder' => _x(
							'Add Alternative hosts',
							'The placeholder for the multiselect to select alternative hosts.',
							'events-virtual'
						),
						'data-selected'    => $post->zoom_host_id,
						'data-options'     => json_encode( $alt_hosts ),
					],
				],
			],
			$echo
		);
	}

	/**
	 * Renders the link to offer the user the option to connect to the Zoom API.
	 *
	 * @since 1.1.1
	 *
	 * @param \WP_Post $post The post object of the Event context of the link generation.
	 * @param bool     $echo Whether to print the rendered HTML to the page or not.
	 *
	 * @return string|false Either the final content HTML or `false` if the template could be found.
	 */
	protected function render_api_connection_link( \WP_Post $post, $echo = true ) {
		return $this->template->template(
			'virtual-metabox/zoom/controls',
			[
				'event'               => $post,
				'is_authorized'       => false,
				'offer_or_label'      => _x(
					'or',
					'The lowercase "or" label used to offer the creation of a Zoom Meetings API link.',
					'events-virtual'
				),
				'generate_link_label' => $this->get_connect_to_zoom_label(),
				'generate_link_url'   => Settings::admin_url(),
			],
			$echo
		);
	}

	/**
	 * Renders the link generator HTML for one Zoom Meeting types (e.g. Webinars or Meetings).
	 *
	 * Currently the available types are, at the most, 2: Meetings and Webinars. This method might need to be
	 * updated in the future if that assumption changes. If this method runs, then it means that we should render
	 * generation links for both type of meetings.
	 *
	 * @since 1.1.1
	 * @deprecated 1.4.0 Use render_multiple_links_generator()
	 *
	 * @param string   $type The type of Zoom Meeting to render teh link generator HTML for.
	 * @param \WP_Post $post The post object of the Event context of the link generation.
	 * @param bool     $echo Whether to print the rendered HTML to the page or not.
	 *
	 * @return string|false Either the final content HTML or `false` if the template could be found.
	 */
	public function render_single_link_generator( $type, \WP_Post $post, $echo = true ) {
		_deprecated_function( __FUNCTION__, '1.4.0', get_class( $this ) . '::render_multiple_links_generator()' );

		$data = Arr::get( $this->get_link_generation_urls( $post, true ), $type, false );

		if ( false === $data ) {
			// This should not happen as the types are hard-coded, but better safe than sorry.
			return '';
		}

		list( $generate_link_url, $generate_link_label ) = $data;

		return $this->template->template(
			'virtual-metabox/zoom/controls',
			[
				'event'               => $post,
				'is_authorized'       => true,
				'offer_or_label'      => _x(
					'or',
					'The lowercase "or" label used to offer the creation of a Zoom Meetings or Webinars API link.',
					'events-virtual'
				),
				'generate_link_label' => $generate_link_label,
				'generate_link_url'   => $generate_link_url,
			],
			$echo
		);
	}
}
