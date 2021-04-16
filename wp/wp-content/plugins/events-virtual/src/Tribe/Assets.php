<?php
/**
 * Handles registering all Assets for the Events Virtual Plugin.
 *
 * To remove a Asset you can use the global assets handler:
 *
 * ```php
 *  tribe( 'assets' )->remove( 'asset-name' );
 * ```
 *
 * @since 1.0.0
 *
 * @package Tribe\Events\Virtual
 */

namespace Tribe\Events\Virtual;

use Tribe\Events\Views\V2\Assets as Event_Assets;
use Tribe\Events\Views\V2\Template_Bootstrap;
use Tribe__Events__Templates;

use Tribe\Events\Views\V2\Widgets\Widget_List;

/**
 * Register Assets.
 *
 * @since 1.0.0
 *
 * @package Tribe\Events\Virtual
 */
class Assets extends \tad_DI52_ServiceProvider {
	/**
	 * Key for this group of assets.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public static $group_key = 'events-virtual';

	/**
	 * Caches the result of the `should_enqueue_frontend` check.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	protected $should_enqueue_frontend;

	/**
	 * Caches the result of the `should_enqueue_single_event` check.
	 *
	 * @since 1.0.1
	 *
	 * @var bool
	 */
	protected $should_enqueue_single_event;

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->container->singleton( static::class, $this );
		$this->container->singleton( 'events-virtual.assets', $this );

		$plugin = tribe( Plugin::class );

		tribe_asset(
			$plugin,
			'tribe-events-virtual-admin-css',
			'events-virtual-admin.css',
			[],
			'admin_enqueue_scripts'
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-admin-js',
			'events-virtual-admin.js',
			[ 'jquery', 'tribe-tooltip-js' ],
			'admin_enqueue_scripts'
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-skeleton',
			'events-virtual-skeleton.css',
			[ 'tribe-events-views-v2-skeleton' ],
			'wp_enqueue_scripts',
			[
				'priority'     => 10,
				'conditionals' => [ $this, 'should_enqueue_frontend' ],
				'groups'       => [ static::$group_key ],
			]
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-full',
			'events-virtual-full.css',
			[ 'tribe-events-views-v2-full' ],
			'wp_enqueue_scripts',
			[
				'priority'     => 10,
				'conditionals' => [
					'operator' => 'AND',
					[ $this, 'should_enqueue_frontend' ],
					[ tribe( Event_Assets::class ), 'should_enqueue_full_styles' ],
				],
				'groups'       => [ static::$group_key ],
			]
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-widgets-v2-common-skeleton',
			'widgets-events-common-skeleton.css',
			[],
			'wp_print_footer_scripts',
			[
				'print'        => true,
				'priority'     => 5,
				'conditionals' => [
					[ Widget_List::class, 'is_widget_in_use' ],
				],
				'groups' => [
					Widget_List::get_css_group(),
				],
			]
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-widgets-v2-common-full',
			'widgets-events-common-full.css',
			[
				'tribe-events-virtual-widgets-v2-common-skeleton',
			],
			'wp_print_footer_scripts',
			[
				'print'        => true,
				'priority'     => 5,
				'conditionals' => [
					'operator' => 'AND',
					[ Widget_List::class, 'is_widget_in_use' ],
					[ tribe( Event_Assets::class ), 'should_enqueue_full_styles' ],
				],
				'groups' => [
					Widget_List::get_css_group(),
				],
			]
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-single-skeleton',
			'events-virtual-single-skeleton.css',
			[],
			'wp_enqueue_scripts',
			[
				'priority'     => 10,
				'conditionals' => [ $this, 'should_enqueue_single_event' ],
				'groups'       => [ static::$group_key ],
			]
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-single-full',
			'events-virtual-single-full.css',
			[ 'tribe-events-virtual-single-skeleton' ],
			'wp_enqueue_scripts',
			[
				'priority'     => 10,
				'conditionals' => [
					'operator' => 'AND',
					[ $this, 'should_enqueue_single_event' ],
					[ tribe( Event_Assets::class ), 'should_enqueue_full_styles' ],
				],
				'groups'       => [ static::$group_key ],
			]
		);

		$overrides_stylesheet = Tribe__Events__Templates::locate_stylesheet( 'tribe-events/tribe-events-virtual-override.css' );

		if ( ! empty( $overrides_stylesheet ) ) {
			tribe_asset(
				$plugin,
				'tribe-events-virtual-override',
				$overrides_stylesheet,
				[
					'tribe-common-full-style',
					'tribe-events-views-v2-skeleton',
				],
				'wp_enqueue_scripts',
				[
					'groups' => [ static::$group_key, Event_Assets::$group_key ],
				]
			);
		}

		tribe_asset(
			$plugin,
			'tribe-events-virtual-single-v2-skeleton',
			'events-virtual-single-v2-skeleton.css',
			[],
			'wp_enqueue_scripts',
			[
				'priority' => 15,
				'conditionals' => [
					[ $this, 'should_enqueue_single_event_styles' ],
				],
			]
		);

		tribe_asset(
			$plugin,
			'tribe-events-virtual-single-v2-full',
			'events-virtual-single-v2-full.css',
			[
				'tribe-events-virtual-single-v2-skeleton',
			],
			'wp_enqueue_scripts',
			[
				'priority' => 15,
				'conditionals' => [
					'operator' => 'AND',
					[ $this, 'should_enqueue_single_event_styles' ],
					[ tribe( Event_Assets::class ), 'should_enqueue_full_styles' ],
				],
			]
		);
	}

	/**
	 * Checks if we should enqueue frontend assets for the V2 views.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether the frontend assets should be enqueued or not.
	 */
	public function should_enqueue_frontend() {
		if ( null !== $this->should_enqueue_frontend ) {
			return $this->should_enqueue_frontend;
		}

		$should_enqueue = tribe_events_views_v2_is_enabled() && tribe( Template_Bootstrap::class )->should_load();

		/**
		 * Allow filtering of where the base Frontend Assets will be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $should_enqueue Whether the frontend assets should be enqueued or not.
		 */
		$should_enqueue = apply_filters( 'tribe_events_virtual_assets_should_enqueue_frontend', $should_enqueue );

		$this->should_enqueue_frontend = $should_enqueue;

		return $should_enqueue;
	}

	/**
	 * Checks if we should enqueue event single assets.
	 *
	 * @since 1.0.1
	 *
	 * @return bool Whether the event single assets should be enqueued or not.
	 */
	public function should_enqueue_single_event() {
		if ( null !== $this->should_enqueue_single_event ) {
			return $this->should_enqueue_single_event;
		}

		$should_enqueue = tribe( Template_Bootstrap::class )->is_single_event();

		/**
		 * Allow filtering of where the event single assets will be loaded.
		 *
		 * @since 1.0.1
		 *
		 * @param bool $should_enqueue Whether the event single assets should be enqueued or not.
		 */
		$should_enqueue = apply_filters( 'tribe_events_virtual_assets_should_enqueue_single_event', $should_enqueue );

		$this->should_enqueue_single_event = $should_enqueue;

		return $should_enqueue;
	}

	/**
	 * Fires to include the virtual event assets on shortcodes.
	 *
	 * @since 1.0.0
	 *
	 * @return void Action hook with no return.
	 */
	public function load_on_shortcode() {
		tribe_asset_enqueue_group( static::$group_key );
	}

	/**
	 * Verifies if we are on V2 and on Event Single in order to enqueue the override styles for Single Event
	 *
	 * @since 1.2.0
	 *
	 * @return boolean
	 */
	public function should_enqueue_single_event_styles() {
		// Bail if not V2.
		if ( ! tribe_events_single_view_v2_is_enabled() ) {
			return false;
		}

		// Bail if not Single Event.
		if ( ! tribe( Template_Bootstrap::class )->is_single_event() ) {
			return false;
		}

		// Bail if Block Editor.
		if ( has_blocks( get_queried_object_id() ) ) {
			return false;
		}

		return true;
	}

}
