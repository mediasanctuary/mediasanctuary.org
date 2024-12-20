<?php
/**
 * Handles the compatibility with the Online Event extension.
 *
 * @since 7.0.0 Migrated to Events Pro from Events Virtual.
 *
 * @package Tribe\Events\Virtual\Compatibility\Online_Event_Extension
 */

namespace Tribe\Events\Virtual\Compatibility\Online_Event_Extension;

use Tribe__Extension__Virtual__Event__Ticket as Extension;
use TEC\Common\Contracts\Service_Provider as Provider_Contract;

/**
 * Class Service_Provider
 *
 * @since 7.0.0 Migrated to Events Pro from Events Virtual.
 *
 * @package Tribe\Events\Virtual\Compatibility\Online_Event_Extension
 */
class Service_Provider extends Provider_Contract {

	/**
	 * Register the bindings and filters required to ensure compatibility w/ the extension.
	 *
	 * @since 7.0.0 Migrated to Events Pro from Events Virtual.
	 */
	public function register() {
		$this->container->singleton( self::class, $this );
		$this->container->singleton( 'events-virtual.compatibility.tribe-ext-online-event', $this );

		$instance = \Tribe__Extension::instance( 'Tribe__Extension__Virtual__Event__Ticket' );

		if ( ! $instance instanceof Extension ) {
			// For whatever reason the extension is not registered, bail.
			return;
		}

		// Bind the extension instance in the container to make sure injection will work.
		$this->container->bind( 'Tribe__Extension__Virtual__Event__Ticket', $instance );

		add_action( 'tribe_plugins_loaded', [ $this, 'handle_actions' ], 20 );
		add_filter( 'tribe_addons_tab', [ $this, 'inject_extension_settings' ], 100 );
	}

	/**
	 * Handles the actions hooked by the extension plugin.
	 *
	 * @since 7.0.0 Migrated to Events Pro from Events Virtual.
	 */
	public function handle_actions() {
		remove_action(
			'tribe_tickets_ticket_email_ticket_bottom',
			[ $this->container->make( Extension::class ), 'render_online_link_in_email' ]
		);
	}

	/**
	 * Injects some info into the extension settings to refer folks to the plugin.
	 *
	 * @since 7.0.0 Migrated to Events Pro from Events Virtual.
	 *
	 * @param array  $fields The fields within tribe settings page.
	 * @param string $tab    The settings tab key.
	 *
	 * @return array $fields The fields within tribe settings page
	 */
	public function inject_extension_settings( $fields ) {
		$settings = $this->container->make( Settings::class );

		return $settings->inject_extension_settings( $fields );
	}
}
