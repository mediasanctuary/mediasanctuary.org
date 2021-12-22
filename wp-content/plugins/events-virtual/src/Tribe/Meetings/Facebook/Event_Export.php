<?php
/**
 * Export functions for Facebook.
 *
 * @since   1.7.3
 * @package Tribe\Events\Virtual\Service_Providers;
 */

namespace Tribe\Events\Virtual\Meetings\Facebook;

use Tribe\Events\Virtual\Export\Abstract_Export;
/**
 * Class Event_Export
 *
 * @since 1.7.3
 *
 * @package Tribe\Events\Virtual\Export;
 */
class Event_Export extends Abstract_Export {

	/**
	 * An instance of the Facebook Page API handler.
	 *
	 * @since 1.7.3
	 *
	 * @var Page_API
	 */
	public $page_api;

	/**
	 * Event_Export constructor.
	 *
	 * @since 1.7.3
	 *
	 * @param Page_API $api An instance of the Page_API handler.
	 */
	public function __construct( Page_API $api ) {
		$this->api = $api;
	}

	/**
	 * Modify the export parameters for the zoom source.
	 *
	 * @since 1.7.3
	 *
	 * @param array    $fields   The various file format components for this specific event.
	 * @param \WP_Post $event    The WP_Post of this event.
	 * @param string   $key_name The name of the array key to modify.
	 * @param string   $type     The name of the export type.
	 *
	 * @return array The various file format components for this specific event.
	 */
	public function modify_video_source_export_output( $fields, $event, $key_name, $type ) {
		if ( 'facebook' !== $event->virtual_video_source ) {
			return $fields;
		}

		// If no linked button or details, set the permalink and return.
		if (
			$event->virtual_embed_video &&
			! $event->virtual_linked_button
		 ) {
			$fields[ $key_name ] = $this->format_value( get_the_permalink( $event->ID ), $key_name, $type );

			return $fields;
		}

		$url = $this->api::get_facebook_page_url_with_page_id( $event->facebook_local_id );

		$fields[ $key_name ] = $this->format_value( $url, $key_name, $type );

		return $fields;
	}
}
