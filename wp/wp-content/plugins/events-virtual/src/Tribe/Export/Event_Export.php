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
 * @package Tribe\Events\Virtual\Export;
 */
class Event_Export {

	/**
	 * Modify the export parameters for a virtual event export.
	 *
	 * @since 1.0.4
	 *
	 * @param array  $fields   The various file format components for this specific event.
	 * @param int    $event_id The event id.
	 * @param string $key_name The name of the array key to modify.
	 *
	 * @return array The various file format components for this specific event.
	 */
	public function modify_export_output( $fields, $event_id, $key_name ) {

		$event = tribe_get_event( $event_id );

		if ( ! $event instanceof \WP_Post ) {
			return $fields;
		}

		if ( ! $event->virtual ) {
			return $fields;
		}

		if ( isset( $event->venues[0] ) ) {
			return $fields;
		}

		if (
			(
				! $event->virtual_embed_video &&
				! $event->virtual_linked_button
			) ||
			(
				! $event->virtual_url &&
				! $event->virtual_meeting_url
			) ||
			$event->virtual_embed_video
		) {

			$fields[ $key_name ] = get_the_permalink( $event->ID );

			return $fields;
		}

		if ( $event->virtual_linked_button ) {

			$url = $event->virtual_url;
			if ( ! empty( $event->virtual_meeting_url ) ) {
				$url = $event->virtual_meeting_url;
			}

			$fields[ $key_name ] = $url;

			return $fields;
		}

		return $fields;
	}
}
