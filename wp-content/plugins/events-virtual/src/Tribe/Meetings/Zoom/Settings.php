<?php
/**
 * Manages the Zoom settings for the extension.
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */

namespace Tribe\Events\Virtual\Meetings\Zoom;

use Tribe\Events\Virtual\Encryption;
use Tribe\Events\Virtual\Meetings\Zoom\Template_Modifications;

/**
 * Class Settings
 *
 * @since   1.0.0
 *
 * @package Tribe\Events\Virtual\Meetings\Zoom
 */
class Settings {
	/**
	 * The prefix, in the context of tribe options, of each setting for this extension.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $option_prefix = 'tribe_zoom_';

	/**
	 * The URL handler instance.
	 *
	 * @since 1.0.0
	 *
	 * @var Url
	 */
	protected $url;

	/**
	 * An instance of the Zoom API handler.
	 *
	 * @since 1.0.0
	 *
	 * @var Api
	 */
	protected $api;

	/**
	 * Settings constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param Api $api An instance of the Zoom API handler.
	 * @param Url $url An instance of the URL handler.
	 */
	public function __construct( Api $api, Url $url ) {
		$this->url        = $url;
		$this->api        = $api;
	}

	/**
	 * Returns the URL of the Settings URL page.
	 *
	 * @since 1.0.0
	 *
	 * @return string The URL of the Zoom API integration settings page.
	 */
	public static function admin_url() {
		return admin_url( 'edit.php?post_type=tribe_events&page=tribe-common&tab=addons' );
	}

	/**
	 * Returns the current API refresh token.
	 *
	 * If not available, then a new token should be fetched by the API.
	 *
	 * @since 1.0.1
	 *
	 * @return string|boolean The API access token, or false if the token cannot be fetched (error).
	 */
	public static function get_refresh_token() {
		return tribe( Encryption::class )->decrypt( tribe_get_option( static::$option_prefix . 'refresh_token', false ) );
	}

	/**
	 * Adds the Zoom API fields to the ones in the Events > Settings > APIs tab.
	 *
	 * @since 1.0.0
	 *
	 * @param array<string,array> $fields The current fields.
	 *
	 * @return array<string,array> The fields, as updated by the settings.
	 */
	public function add_fields( array $fields = [] ) {
		$wrapper_classes = tribe_get_classes(
			[
				'tribe-settings-zoom-application' => true,
				'tribe-zoom-authorized'           => $this->api->is_authorized(),
			]
		);
		$client_id_attrs     = [ 'id' => 'zoom-application__client-id' ];
		$client_secret_attrs = [ 'id' => 'zoom-application__client-secret' ];

		if ( $this->get_refresh_token() && $this->api->client_id() && $this->api->client_secret() ) {
			$client_id_attrs['disabled']     = 'disabled';
			$client_secret_attrs['disabled'] = 'disabled';
		}

		$zoom_fields = [
			static::$option_prefix . 'wrapper_open'  => [
				'type' => 'html',
				'html' => '<div id="tribe-settings-zoom-application" data-nonce="' . wp_create_nonce( OAuth::$client_keys_autosave_nonce_action ) . '" class="' . implode( ' ', $wrapper_classes ) . '">',
			],
			static::$option_prefix . 'header'        => [
				'type' => 'html',
				'html' => $this->get_intro_text(),
			],
			static::$option_prefix . 'authorize'     => [
				'type' => 'html',
				'html' => $this->get_authorize_fields(),
			],
			static::$option_prefix . 'wrapper_close' => [
				'type' => 'html',
				'html' => '<div class="clear"></div></div>',
			],
		];

		/**
		 * Filters the Zoom API settings shown to the user in the Events > Settings > APIs screen.
		 *
		 * @since  1.0.0
		 *
		 * @param array<string,array> A map of the Zoom API fields that will be printed on the page.
		 * @param Settings $this This Settings instance.
		 */
		$zoom_fields = apply_filters( 'tribe_events_virtual_meetings_zoom_settings_fields', $zoom_fields, $this );

		// Insert the link after the other APIs and before the Google Maps API ones.
		$gmaps_fields = array_splice( $fields, array_search( 'gmaps-js-api-start', array_keys( $fields ) ) );

		$fields = array_merge( $fields, $zoom_fields, $gmaps_fields );

		return $fields;
	}

	/**
	 * Provides the introductory text to the set up and configuration of the Zoom API integration.
	 *
	 * @since 1.0.0
	 *
	 * @return string The introductory text to the the set up and configuration of the Zoom API integration.
	 */
	protected function get_intro_text() {
		return tribe( Template_Modifications::class )->get_intro_text();
	}

	/**
	 * Get the API authorization fields.
	 *
	 * @since 1.0.0
	 *
	 * @return string The HTML fields.
	 */
	protected function get_authorize_fields() {
		return tribe( Template_Modifications::class )->get_api_authorize_fields( $this->api, $this->url );
	}

	/**
	 * Gets the connect link for the ajax call.
	 *
	 * @since 1.0.1
	 *
	 * @return string HTML.
	 */
	public function get_connect_link() {
		return tribe( Template_Modifications::class )->get_connect_link( $this->api, $this->url );
	}

	/**
	 * Gets the disabled button for the ajax call.
	 *
	 * @since 1.0.1
	 *
	 * @return string HTML.
	 */
	public function get_disabled_button() {
		return tribe( Template_Modifications::class )->get_disabled_button();
	}

}
