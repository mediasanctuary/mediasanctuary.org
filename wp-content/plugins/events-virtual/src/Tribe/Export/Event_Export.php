<?php
/**
 * Export functions for the plugin.
 *
 * @since   1.0.4
 * @package Tribe\Events\Virtual\Service_Providers;
 */

namespace Tribe\Events\Virtual\Export;

/**
 * Class Event_Export
 *
 * @since 1.0.4
 * @since 1.7.3 - Change to extend abstract class.
 *
 * @package Tribe\Events\Virtual\Export;
 */
class Event_Export extends Abstract_Export {

	/**
	 * Modify the export parameters for a virtual event export.
	 *
	 * @since 1.0.4
	 * @since 1.7.3 - Add a filter to allow the active video source to modify the export fields.
	 *
	 * @param array  $fields   The various file format components for this specific event.
	 * @param int    $event_id The event id.
	 * @param string $key_name The name of the array key to modify.
	 *
	 * @return array The various file format components for this specific event.
	 */
	public function modify_export_output( $fields, $event_id, $key_name, $type = null ) {
		$event = tribe_get_event( $event_id );

		if ( ! $event instanceof \WP_Post ) {
			return $fields;
		}

		// If it is not a virtual event, return fields.
		if ( ! $event->virtual ) {
			return $fields;
		}

		// If there is a venue, return fields as is.
		if ( isset( $event->venues[0] ) ) {
			return $fields;
		}

		/**
		 * Allow filtering of the export fields by the active video source.
		 *
		 * @since 1.7.3
		 *
		 * @param array    $fields   The various file format components for this specific event.
		 * @param \WP_Post $event    The WP_Post of this event.
		 * @param string   $key_name The name of the array key to modify.
		 * @param string   $type     The name of the export type.
		 */
		$fields = apply_filters( 'tec_events_virtual_export_fields', $fields, $event, $key_name, $type );

		return $fields;
	}

	/**
	 * Modify the export parameters for the video source.
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
		if ( 'video' !== $event->virtual_video_source ) {
			return $fields;
		}

		// If an embed video or no linked button, set the permalink and return.
		if (
			(
				$event->virtual_embed_video &&
				! $event->virtual_linked_button
			)||
			(
				! $event->virtual_embed_video &&
				! $event->virtual_linked_button
			)
		 ) {
			$fields[ $key_name ] = $this->format_value( get_the_permalink( $event->ID ), $key_name, $type );

			return $fields;
		}

		$url = $event->virtual_url;


		$fields[ $key_name ] = $this->format_value( $url, $key_name, $type );

		return $fields;
	}
}
