<?php
/**
 * Manages the Webex Users
 *
 * @since 1.9.0
 *
 * @package Tribe\Events\Virtual\Meetings\Webex
 */

namespace Tribe\Events\Virtual\Meetings\Webex;

use Tribe\Events\Virtual\Admin_Template;
use Tribe\Events\Virtual\Traits\With_AJAX;
use Tribe__Utils__Array as Arr;

/**
 * Class Users
 *
 * @since 1.9.0
 *
 * @package Tribe\Events\Virtual\Meetings\Webex
 */
class Users {
	use With_AJAX;

	/**
	 * The template handler instance.
	 *
	 * @since 1.9.0
	 *
	 * @var Admin_Template
	 */
	public $admin_template;

	/**
	 * Users constructor.
	 *
	 * @since 1.9.0
	 *
	 * @param Api            $api        An instance of the Webex API handler.
	 * @param Admin_Template $template   An instance of the Template class to handle the rendering of admin views.
	 */
	public function __construct( Api $api, Admin_Template $admin_template ) {
		$this->api            = $api;
		$this->admin_template = $admin_template;
	}

	/**
	 * Get list of users from Webex.
	 *
	 * @since 1.9.0
	 *
	 * @param null|string $account_id The account id to use to get the users with.
	 *
	 * @return array<string,mixed> An array of users from Webex.
	 */
	public function get_users( $account_id = null ) {
		$api = $this->api;
		if ( $account_id ) {
			$api->load_account_by_id( $account_id );
		} else {
			$api->load_account();
		}

		if ( empty( $this->api->is_ready() ) ) {
			return [];
		}

		/** @var \Tribe__Cache $cache */
		$cache    = tribe( 'cache' );
		$cache_id = 'tec_events_virtual_meetings_webex_users' . md5( $this->api->id );

		/**
		 * Filters the time in seconds until the Webex user cache expires.
		 *
		 * @since 1.9.0
		 *
		 * @param int     The time in seconds until the user cache expires, default 1 hour.
		 */
		$expiration = apply_filters( 'tec_events_virtual_meetings_webex_user_cache', HOUR_IN_SECONDS );
		$users      = $cache->get_transient( $cache_id );

		if ( ! empty( $users ) ) {
			return  $users;
		}

		$available_hosts = $api->fetch_users();
		$cache->set_transient( $cache_id, $available_hosts, $expiration );

		return $available_hosts;
	}

	/**
	 * Get list of hosts formatted for options dropdown.
	 *
	 * @since 1.9.0
	 *
	 * @param null|string $account_id The account id to use to get the users with.
	 *
	 * @return array<string,mixed>  An array of Webex Users to use as the host
	 */
	public function get_formatted_hosts_list( $account_id = null ) {
		$available_hosts = $this->get_users( $account_id );
		if ( empty( $available_hosts['items'] ) ) {
			return [];
		}

		$active_users    = $available_hosts['items'];
		$hosts           = [];
		foreach ( $active_users as $user ) {
			$emails = Arr::get( $user, 'emails', '' );
			$email  = isset( $emails[0] ) ? $emails[0] : '';

			$name      = Arr::get( $user, 'firstName', '' ) . ' ' . Arr::get( $user, 'lastName', '' ) . ' - ' . $email;
			$last_name = Arr::get( $user, 'lastName', '' );
			$value     = Arr::get( $user, 'id', '' );

			if ( empty( $name ) || empty( $value ) || empty( $email ) ) {
				continue;
			}

			if ( empty( $last_name ) ) {
				$last_name = Arr::get( $user, 'firstName', '' );
			}

			$hosts[] = [
				'text'             => (string) trim( $name ),
				'sort'             => (string) trim( $last_name ),
				'id'               => (string) $email,
				'value'            => (string) $value,
				'selected'         => $account_id === $value ? true : false,
			];
		}

		// Sort the hosts array by text(email).
		$sort_arr = array_column( $hosts, 'sort' );
		array_multisort( $sort_arr, SORT_ASC, $hosts );

		return $hosts;
	}
}
