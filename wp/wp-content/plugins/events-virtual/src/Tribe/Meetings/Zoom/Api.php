<?php
/**
 * Handles the interaction w/ Zoom API.
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */

namespace Tribe\Events\Virtual\Meetings\Zoom;

use Tribe\Events\Virtual\Meetings\Api_Response;
use Tribe__Utils__Array as Arr;

/**
 * Class Api
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */
class Api {

	/**
	 * The base URL of the Zoom REST API, v2.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $api_base = 'https://api.zoom.us/v2/';

	/**
	 * The current Zoom API access token.
	 *
	 * @var string
	 */
	protected $token;

	/**
	 * The Client ID, as defined in Settings > APIs.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $client_id;

	/**
	 * The Client secret, as defined in Settings > APIs.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $client_secret;

	/**
	 * The current Zoom API refresh token.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $refresh_token;

	/**
	 * Expected response code for GET requests.
	 *
	 * @since 1.0.2
	 *
	 * @var integer
	 */
	const GET_RESPONSE_CODE = 200;

	/**
	 * Expected response code for POST requests.
	 *
	 * @since 1.0.2
	 *
	 * @var integer
	 */
	const POST_RESPONSE_CODE = 201;

	/**
	 * Expected response code for POST OAuth requests.
	 *
	 * @since 1.0.2
	 *
	 * @var integer
	 */
	const OAUTH_POST_RESPONSE_CODE = 200;

	/**
	 * Expected response code for PATCH requests.
	 *
	 * @since 1.0.2
	 *
	 * @var integer
	 */
	const PATCH_RESPONSE_CODE = 204;

	/**
	 * Api constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->refresh_token = Settings::get_refresh_token();
		$this->token         = (string) get_transient( Settings::$option_prefix . 'access_token' );

		// These parameters are deprecated since version 1.1.1: the OAuth flow is not managed by the plugin.
		$this->client_id     = tribe_get_option( Settings::$option_prefix . 'client_id' );
		$this->client_secret = tribe_get_option( Settings::$option_prefix . 'client_secret' );
	}

	/**
	 * Checks whether all fields required to interact with the Zoom API are correctly set or not.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether all fields required to interact with the Zoom API are correctly set or not.
	 */
	public function has_required_fields() {
		foreach ( $this->required_fields() as $required_field ) {
			if ( empty( tribe_get_option( Settings::$option_prefix . $required_field ) ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Returns a list of the fields required by the application to work.
	 *
	 * @since 1.0.0
	 *
	 * @return array<string> A list of the fields, tribe_option keys w/o the Zoom\Settings prefix, required by the
	 *                       integration to work.
	 */
	public function required_fields() {
		return [];
	}

	/**
	 * Checks whether the current Zoom API integration is authorized or not.
	 *
	 * The check is made on the existence of the refresh token, with it the token can be fetched on demand when
	 * required.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether the current Zoom API integration is authorized or not.
	 */
	public function is_authorized() {
		return ! empty( $this->refresh_token );
	}

	/**
	 * Returns the access token based authorization header to send requests to the Zoom API.
	 *
	 * @since 1.0.0
	 *
	 * @return string The authorization header, to be used in the `headers` section of a request to Zoom API.
	 */
	public function token_authorization_header() {
		return 'Bearer ' . $this->get_access_token();
	}

	/**
	 * Returns the current API access token.
	 *
	 * If not available, then a new token will be fetched.
	 *
	 * @since 1.0.0
	 * @since 1.1.1 Changed the method to use the new OAuth flow that is not handled by the plugin.
	 *
	 * @return string The API access token, or an empty string if the token cannot be fetched.
	 */
	protected function get_access_token() {
		$token = get_transient( Settings::$option_prefix . 'access_token' );

		if ( empty( $token ) ) {
			$url = OAuth::$token_request_url;

			// Check if this is a legacy authorization, if so, we need to refresh against Zoom directly.
			$legacy_auth_code = tribe_get_option( Settings::$option_prefix . 'auth_code' );
			if ( ! empty( $legacy_auth_code ) ) {
				$url = OAuth::$legacy_token_request_url;
			}

			$this->post(
				$url,
				[
					'headers' => [
						'Authorization' => $this->authorization_header(),
					],
					'body'    => [
						'grant_type'    => 'refresh_token',
						'refresh_token' => $this->refresh_token,
					],
				],
				200
			)->then( [ $this, 'save_access_token' ] );

			// Fetch it again, it should now be there.
			$token = get_transient( Settings::$option_prefix . 'access_token' );
		}

		return (string) $token;
	}

	/**
	 * Makes a request to the Zoom API.
	 *
	 * @since 1.0.2
	 *
	 * @param string $url         The URL to make the request to.
	 * @param array  $args        An array of arguments for the request. Should include 'method' (POST/GET/PATCH, etc).
	 * @param int    $expect_code The expected response code, if not met, then the request will be considered a failure.
	 *                            Set to `null` to avoid checking the status code.
	 *
	 * @return Api_Response An API response to act upon the response result.
	 */
	protected function request( $url, array $args, $expect_code = self::GET_RESPONSE_CODE ) {
		/**
		 * Filters the response for a Zoom API request to prevent the response from actually happening.
		 *
		 * @since 1.0.0
		 *
		 * @param null|Api_Response|\WP_Error|mixed $response    The response that will be returned. A non `null` value
		 *                                                       here will short-circuit the response.
		 * @param string                            $url         The full URL this request is being made to.
		 * @param array<string,mixed>               $args        The request arguments.
		 * @param int                               $expect_code The HTTP response code expected for this request.
		 */
		$response = apply_filters( 'tribe_events_virtual_meetings_zoom_api_post_response', null, $url, $args, $expect_code );

		if ( null !== $response ) {
			return Api_Response::ensure_response( $response );
		}

		$response = wp_remote_request( $url, $args );

		if ( $response instanceof \WP_Error ) {
			$error_message = $response->get_error_message();

			do_action(
				'tribe_log',
				'error',
				__CLASS__,
				[
					'action'  => __METHOD__,
					'code'    => $response->get_error_code(),
					'message' => $error_message,
					'method'  => $args['method'],
				]
			);

			$user_message = sprintf(
				// translators: the placeholder is for the error as returned from Zoom API.
				_x(
					'Error while trying to communicate with Zoom API: %s. Please try again in a minute.',
					'The prefix of a message reporting a Zoom API communication error, the placeholder is for the error.',
					'events-virtual'
				),
				$error_message
			);
			tribe_transient_notice(
				'events-virtual-zoom-request-error',
				'<p>' . esc_html( $user_message ) . '</p>',
				[ 'type' => 'error' ],
				60
			);

			return new Api_Response( $response );
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( null !== $expect_code && $expect_code !== $response_code ) {
			$data = [
				'action'        => __METHOD__,
				'message'       => 'Response code is not the expected one.',
				'expected_code' => $expect_code,
				'response_code' => $response_code,
				'api_method'    => $args['method'],
			];
			do_action( 'tribe_log', 'error', __CLASS__, $data );

			$user_message = sprintf(
				// translators: the placeholders are, respectively, for the expected and actual response codes.
				_x(
					'Zoom API response is not the expected one, expected %1$s, received %2$s. Please, try again in a minute.',
					'The message reporting a Zoom API unexpected response code, placeholders are the codes.',
					'events-virtual'
				),
				$expect_code,
				$response_code
			);
			tribe_transient_notice(
				'events-virtual-zoom-response-error',
				'<p>' . esc_html( $user_message ) . '</p>',
				[ 'type' => 'error' ],
				60
			);

			return new Api_Response( new \WP_Error( $response_code, 'Response code is not the expected one.', $data ) );
		}

		return new Api_Response( $response );
	}

	/**
	 * Makes a POST request to the Zoom API.
	 *
	 * @since 1.0.0
	 * @since 1.0.2 Change to a sugar function implementing $this->request().
	 *
	 * @param string $url         The URL to make the request to.
	 * @param array  $args        An array of arguments for the request.
	 * @param int    $expect_code The expected response code, if not met, then the request will be considered a failure.
	 *                            Set to `null` to avoid checking the status code.
	 *
	 * @return Api_Response An API response to act upon the response result.
	 */
	public function post( $url, array $args, $expect_code = self::POST_RESPONSE_CODE ) {
		$args['method'] = 'POST';

		return $this->request( $url, $args, $expect_code );
	}

	/**
	 * Makes a PATCH request to the Zoom API.
	 *
	 * @since 1.0.2
	 *
	 * @param string $url         The URL to make the request to.
	 * @param array  $args        An array of arguments for the request.
	 * @param int    $expect_code The expected response code, if not met, then the request will be considered a failure.
	 *                            Set to `null` to avoid checking the status code.
	 *
	 * @return Api_Response An API response to act upon the response result.
	 */
	public function patch( $url, array $args, $expect_code = self::PATCH_RESPONSE_CODE ) {
		$args['method'] = 'PATCH';

		return $this->request( $url, $args, $expect_code );
	}

	/**
	 * Makes a GET request to the Zoom API.
	 *
	 * @since 1.0.2
	 *
	 * @param string $url         The URL to make the request to.
	 * @param array  $args        An array of arguments for the request.
	 * @param int    $expect_code The expected response code, if not met, then the request will be considered a failure.
	 *                            Set to `null` to avoid checking the status code.
	 *
	 * @return Api_Response An API response to act upon the response result.
	 */
	public function get( $url, array $args, $expect_code = self::GET_RESPONSE_CODE ) {
		$args['method'] = 'GET';

		return $this->request( $url, $args, $expect_code );
	}

	/**
	 * Builds the request authorization header as required by the Zoom API.
	 *
	 * @since 1.0.0
	 * @deprecated The OAuth flow is not handled by the plugin anymore.
	 *
	 * @return string The authorization header, to be used in the `headers` section of a request to Zoom API.
	 */
	public function authorization_header() {
		return 'Basic ' . base64_encode( $this->client_id() . ':' . $this->client_secret() );
	}

	/**
	 * Returns the Zoom Application Client ID as provided by the user.
	 *
	 * @since 1.0.0
	 * @deprecated The OAuth flow is not handled by the plugin anymore.
	 *
	 * @return string The Zoom Application Client ID provided by the user.
	 */
	public function client_id() {
		return $this->client_id;
	}

	/**
	 * Returns the current Client Secret used to communicate with the Zoom API.
	 *
	 * @since 1.0.0
	 * @deprecated The OAuth flow is not handled by the plugin anymore.
	 *
	 * @return string The current Client Secret used to communicate with the Zoom API.
	 */
	public function client_secret() {
		return $this->client_secret;
	}

	/**
	 * Validates and saves the access token to the database if all the required data is provided.
	 *
	 * @since 1.0.0
	 *
	 * @param array<string,array> $response An array representing the access token request response, in the format
	 *                                      returned by WordPress `wp_remote_` functions.
	 *
	 * @return bool Whether the access token data was saved or not.
	 */
	public function save_access_token( array $response ) {
		if ( ! (
			isset( $response['body'] )
			&& ( false !== $d = json_decode( $response['body'], true ) )
			&& isset( $d['access_token'], $d['refresh_token'], $d['expires_in'] )
		)
		) {
			do_action(
				'tribe_log',
				'error',
				__CLASS__,
				[
					'action'  => __METHOD__,
					'code'    => wp_remote_retrieve_response_code( $response ),
					'message' => 'Response body missing or malformed',
				]
			);

			return false;
		}

		$access_token = $d['access_token'];
		$refresh_token = $d['refresh_token'];

		/**
		 * Take the expiration in seconds as provided by the server and remove a minute to pad for save delays.
		 */
		$expiration = ( (int) $d['expires_in'] ) - 60;

		// Since the access token is, by its own nature, transient, let's store it as that.
		set_transient( Settings::$option_prefix . 'access_token', $access_token, $expiration );
		// Save the refresh token.
		tribe_update_option( Settings::$option_prefix . 'refresh_token', $refresh_token );

		return $access_token;
	}

	/**
	 * Get the Meeting by ID from Zoom and Return the Data.
	 *
	 * @since 1.0.4
	 *
	 * @param int $zoom_meeting_id The Zoom meeting id.
	 * @param string $meeting_type The type of meeting (Meeting or Webinar) to fetch the information for.
	 *
	 * @return array An array of data from the Zoom API.
	 */
	public function fetch_meeting_data( $zoom_meeting_id, $meeting_type ) {

		$data = [];

		$api_endpoint = Meetings::$meeting_type === $meeting_type
			? Meetings::$api_endpoint
			: Webinars::$api_endpoint;

		$this->get(
			self::$api_base . "{$api_endpoint}/{$zoom_meeting_id}",
			[
				'headers' => [
					'Authorization' => $this->token_authorization_header(),
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'    => null,
			],
			200
		)->then(
			function ( array $response ) use ( &$data ) {

				if (
					! (
						isset( $response['body'] )
						&& false !== ( $body = json_decode( $response['body'], true ) )
						&& isset( $body['join_url'] )
					)
				) {
					do_action( 'tribe_log', 'error', __CLASS__, [
						'action'   => __METHOD__,
						'message'  => 'Zoom API meetings settings response is malformed.',
						'response' => $body,
					] );

					return [];
				}
				$data = $body;
			}
		)->or_catch(
			function ( \WP_Error $error ) {
				do_action( 'tribe_log', 'error', __CLASS__, [
					'action'  => __METHOD__,
					'code'    => $error->get_error_code(),
					'message' => $error->get_error_message(),
				] );
			}
		);

		return $data;
	}

	/**
	 * Returns whether the generation and management of Zoom Webinars is allowed at the API level or not.
	 *
	 * The option value is initially set by checking whether the current Zoom API connection allows for the generation
	 * of Webinars or not; the check is done at connection time.
	 *
	 * @since 1.1.1
	 *
	 * @return bool Whether the generation and management of the Zoom Webinars is allowed at the API level or not.
	 */
	public function allow_webinars() {
		$allowed = tribe_is_truthy( tribe_get_option( Settings::$option_prefix . 'allow_webinars' ) );

		/**
		 * Allows filtering whether the generation and management of Zoom Webinars is allowed at the API level or not.
		 *
		 * @since 1.1.1
		 *
		 * @param bool $allowed Whether the generation and handling of Zoom Webinars is allowed at the API level or not.
		 */
		return (bool) apply_filters( 'tribe_events_virtual_meetings_zoom_api_allow_webinars', $allowed );
	}

	/**
	 * Checks if the user is authorized to operate on Webinars.
	 *
	 * The check done in this method is based on the assumption that users will grant the `read` and `write` scopes to
	 * the connected application. In the method only the `read` one is checked so the check is not 100% accurate, but
	 * still a reasonable proxy for users that followed the set up guide. If the `write` scope is not granted, then
	 * the user will get a Zoom API error message while trying to create Webinars and the troubleshoot documentation
	 * will check the application scopes first.
	 * Making a more thorough check would involve asking the `user:read` or `admin:user:read` scopes and that, we want
	 * to avoid.
	 *
	 * @since 1.1.1
	 *
	 * @see Api::allow_webinars() to get the value set by this method.
	 */
	public function check_webinar_cap() {
		// Try to list the user webinars.
		$this->get(
			self::$api_base . 'users/me/webinars',
			[
				'headers' => [
					'authorization' => $this->token_authorization_header(),
					'content-type'  => 'application/json; charset=utf-8',
				],
				'body'    => [
					'page_size' => 1,
				],
			],
			// Do not expect any HTTP code in particular, just process what we get back and come to our conclusions.
			null
		)->then(
			static function ( $response ) use ( &$webinars_allowed ) {
				// 401 means "unauthorized": a safe default to avoid offering a Webinar option we cannot support.
				$response_code    = $response instanceof \WP_Error ?
					false
					: (int) Arr::get( $response, [ 'response', 'code' ], 401 );
				$webinars_allowed = 200 === $response_code;
				$option_value     = $webinars_allowed ? 'yes' : 'no';
				tribe_update_option( Settings::$option_prefix . 'allow_webinars', $option_value );
			}
		);
	}

	/**
	 * Resets the Webinar API capability by setting the related option to a null/empty value.
	 *
	 * @since 1.1.1
	 *
	 * @return bool Whether teh Webinar capability was correctly reset or not.
	 */
	public function reset_webinar_cap() {
		return tribe_update_option( Settings::$option_prefix . 'allow_webinars', '' );
	}
}
