/* eslint-disable no-var */
/**
 * Makes sure we have all the required levels on the Tribe Object
 *
 * @since 1.0.1
 *
 * @type {PlainObject}
 */
tribe.events = tribe.events || {};

/**
 * Configures Virtual Events Admin Object on the Global Tribe variable
 *
 * @since 1.0.1
 *
 * @type {PlainObject}
 */
tribe.events.zoomSettingsAdmin = tribe.events.zoomSettingsAdmin || {};

( function( $, obj ) {
	'use-strict';
	const $document = $( document );

	/**
	 * Selectors used for configuration and setup
	 *
	 * @since 1.0.1
	 *
	 * @type {PlainObject}
	 */
	obj.selectors = {
		authorizedClass: 'tribe-zoom-authorized',
		clientIdInput: '#zoom-application__client-id',
		clientSecretInput: '#zoom-application__client-secret',
		virtualContainer: '#tribe-settings-zoom-application',
		zoomToken: '#tribe-field-zoom_token',
	};

	obj.handleConnectButton = function() {
		const clientId = $( obj.selectors.clientIdInput ).val();
		const clientSecret = $( obj.selectors.clientSecretInput ).val();

		const nonce = $( obj.selectors.virtualContainer ).attr( 'data-nonce' );
		const data = {
			action: 'events_virtual_meetings_zoom_autosave_client_keys',
			clientId: clientId,
			clientSecret: clientSecret,
			security: nonce,
		};

		$.ajax( {
			type: 'post',
			url: ajaxurl,
			dataType: 'text/html',
			data: data,
		} )
			.always( obj.swapConnectButton );
	};

	obj.swapConnectButton = function( response ) {
		if ( 'undefined' === typeof response.responseText ) {
			return;
		}

		const html = response.responseText;
		$( obj.selectors.zoomToken ).find( '.tribe-field-wrap' ).html( html );
	};

	obj.bindEvents = function() {
		if ( $( obj.selectors.virtualContainer ).hasClass( obj.selectors.authorizedClass ) ) {
			return;
		}

		$( obj.selectors.virtualContainer )
			.on( 'blur', obj.selectors.clientIdInput, obj.handleConnectButton )
			.on( 'blur', obj.selectors.clientSecretInput, obj.handleConnectButton );
	};

	/**
	 * Handles the initialization of the admin when Document is ready
	 *
	 * @since 1.0.1
	 *
	 * @return {void}
	 */
	obj.ready = function() {
		obj.bindEvents();
	};

	// Configure on document ready
	$document.ready( obj.ready );
} )( jQuery, tribe.events.zoomSettingsAdmin );
