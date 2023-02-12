<?php
/**
 * Handles the registration of all the hooks required for the Series to correctly integrate
 * with this and other plugins.
 *
 * @since   6.0.0
 *
 * @package TEC\Events_Pro\Custom_Tables\V1\Series
 */

namespace TEC\Events_Pro\Custom_Tables\V1\Series;

use tad_DI52_ServiceProvider as Service_Provider;
use TEC\Events_Pro\Custom_Tables\V1\Series\Post_Type as Series;
use TEC\Events_Pro\Custom_Tables\V1\Series\Providers\Base;
use TEC\Events_Pro\Custom_Tables\V1\Series\Providers\Modifications;
use TEC\Events_Pro\Custom_Tables\V1\Series\Providers\Theme_Compatibility;
use TEC\Events_Pro\Custom_Tables\V1\Updates\Relationships;
use WP_Post;
use TEC\Events\Custom_Tables\V1\Updates\Requests;

/**
 * Class Provider
 *
 * @since   6.0.0
 *
 * @package TEC\Events_Pro\Custom_Tables\V1\Series
 */
class Provider extends Service_Provider {

	/**
	 * Registers the implementations and hooks to the filters and actions
	 * required for the Series to work correctly.
	 *
	 * @since 6.0.0
	 *
	 */
	public function register() {
		$series_post_type_name = Series::POSTTYPE;

		if ( ! has_action( 'delete_post', [ $this, 'remove_series_relationships' ] ) ) {
			add_action( 'delete_post', [ $this, 'remove_series_relationships' ], 10 );
		}

		if ( ! has_action( 'wp_trash_post', [ $this, 'trash_autogenerated_series' ] ) ) {
			add_action( 'wp_trash_post', [ $this, 'trash_autogenerated_series' ] );
		}

		if ( ! has_action( 'delete_post', [ $this, 'delete_autogenerated_series' ], 5, 2 ) ) {
			add_action( 'delete_post', [ $this, 'delete_autogenerated_series' ], 5, 2 );
		}

		if ( ! has_action( "save_post_{$series_post_type_name}", [ $this, 'remove_series_autogenerated_flag' ] ) ) {
			add_action( "save_post_{$series_post_type_name}", [ $this, 'remove_series_autogenerated_flag' ], 10, 2 );
		}

		if ( ! has_action( "save_post_{$series_post_type_name}", [ $this, 'snapshot_new_series_state' ] ) ) {
			add_action( "save_post_{$series_post_type_name}", [ $this, 'snapshot_new_series_state' ], 20, 3 );
		}

		if ( ! has_action( "save_post_{$series_post_type_name}", [ $this, 'save_series_relationship' ] ) ) {
			add_action( "save_post_{$series_post_type_name}", [ $this, 'save_series_relationship' ], 10, 2 );
		}

		if ( ! has_action( 'untrashed_post', [ $this, 'untrash_series_following_event' ] ) ) {
			add_action( 'untrashed_post', [ $this, 'untrash_series_following_event' ] );
		}

		if ( ! has_action( "save_post_{$series_post_type_name}", [ $this, 'save_show_series_title' ] ) ) {
			add_action( "save_post_{$series_post_type_name}", [ $this, 'save_show_series_title' ] );
		}

		if ( ! has_filter( 'tribe_events_register_default_linked_post_types', [
			$this,
			'register_series_linked_post_type'
		] ) ) {
			add_filter( 'tribe_events_register_default_linked_post_types', [
				$this,
				'register_series_linked_post_type'
			] );
		}

		add_filter( 'tribe_events_community_allowed_event_fields', [ $this, 'register_events_to_series_request_key' ] );

		$this->container->register( Base::class );
		$this->container->register( Modifications::class );
		$this->container->register( Theme_Compatibility::class );
	}

	/**
	 * Saves the relationship between Events and Series when built from the Series side.
	 *
	 * @since 6.0.0
	 *
	 * @param int     $post_id The post ID of the Series currently being saved.
	 * @param WP_Post $post    A reference to the Series Post object.
	 */
	public function save_series_relationship( $post_id, $post ) {
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		if ( ! $this->container->make( Series::class )->is_same_type( $post ) ) {
			return;
		}

		/** @var Relationships $relationship_handler */
		$relationship_handler = $this->container->make( Relationships::class );
		$relationship_handler->save_relationships_from_series( tribe( Requests::class )->from_http_request() );
	}

	/**
	 * Handles the ancillary operations that should be performed when a relevant post series
	 * is trashed or deleted.
	 *
	 * Currently, the method will severe a Series relationships when the Series is trashed or deleted.
	 *
	 * @since 6.0.0
	 *
	 * @param int $post_id The trashed post ID.
	 */
	public function remove_series_relationships( $post_id ) {
		$series = tribe( Series::class );

		if ( ! $series->is_same_type( get_post( $post_id ) ) ) {
			return;
		}

		( new Relationship() )->delete( $post_id );
	}

	/**
	 * Handles the trashing of the auto-generated Series following the last related
	 * Event trashing.
	 *
	 * @since 6.0.0
	 *
	 * @param int $post_id The trashed post ID.
	 */
	public function trash_autogenerated_series( $post_id ) {
		tribe( Autogenerated_Series::class )->trash_following( $post_id );
	}

	/**
	 * Handles the deletion of the auto-generated Series following the last related
	 * Event deletion.
	 *
	 * @since 6.0.0
	 *
	 * @param int     $post_id The deleted post ID.
	 * @param WP_Post $post    A reference to the current object model.
	 */
	public function delete_autogenerated_series( $post_id, $post ) {
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		tribe( Autogenerated_Series::class )->delete_following( $post );
	}

	/**
	 * Removes a Series auto-generated flag when the user manually updates the series.
	 *
	 * @since 6.0.0
	 *
	 * @param int     $post_id The Series post ID.
	 * @param WP_Post $post    A reference to the Series post object.
	 */
	public function remove_series_autogenerated_flag( $post_id, $post ) {
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		tribe( Autogenerated_Series::class )->remove_autogenerated_flag( $post );
	}

	/**
	 * Snapshots the Series post state on creation.
	 *
	 * @since 6.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @param bool    $update  Whether this is an existing post being updated.
	 */
	public function snapshot_new_series_state( $post_id, $post, $update ) {
		if ( $update ) {
			return;
		}

		if ( ! $post instanceof WP_Post ) {
			return;
		}

		tribe( Autogenerated_Series::class )->checksum_matches( $post );
	}

	/**
	 * Untrashes a Series post following the untrash of an Event post.
	 *
	 * @since 6.0.0
	 *
	 * @param int $post_id The untrashed post ID.
	 */
	public function untrash_series_following_event( $post_id ) {
		tribe( Autogenerated_Series::class )->untrash_following( $post_id );
	}

	/**
	 * Saves the value for the checkbox to hide/show the title on views.
	 *
	 * @since 6.0.0
	 *
	 * @param int $post_id The post ID of the Event currently being saved.
	 *
	 * @return void
	 */
	public function save_show_series_title( $post_id ) {
		update_post_meta(
			$post_id,
			'_tec-series-show-title',
			tribe_get_request_var( '_tec-series-show-title', false )
		);
	}

	/**
	 * Adds the Series post type to the list of linked post types for Events.
	 *
	 * @since 6.0.0
	 *
	 * @param array<string> $linked_post_types A list of post types that should be considered
	 *                                         linked to the Event post type.
	 *
	 * @return array<string> The filtered list of linked post types.
	 */
	public function register_series_linked_post_type( array $linked_post_types = [] ) {
		$linked_post_types[] = Series::POSTTYPE;

		return $linked_post_types;
	}

	/**
	 * Adds the Event to Series key to the list of allowed keys for Community Events.
	 *
	 * @since 6.0.0
	 *
	 * @param array<string> $allowed_keys A list of post types that should be considered
	 *                                    linked to the Event post type.
	 *
	 * @return array<string> The filtered list of linked post types.
	 */
	public function register_events_to_series_request_key( array $allowed_keys = [] ) {

		if ( ! apply_filters( 'tec_community_events_use_series', false ) ) {
			return $allowed_keys;
		}

		$allowed_keys[] = Relationship::EVENTS_TO_SERIES_REQUEST_KEY;
		return $allowed_keys;
	}
}