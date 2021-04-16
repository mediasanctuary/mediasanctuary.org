/* eslint-disable no-var */
/**
 * Makes sure we have all the required levels on the Tribe Object
 *
 * @since 1.0.0
 *
 * @type {PlainObject}
 */
tribe.events = tribe.events || {};

/**
 * Configures Virtual Events Admin Object on the Global Tribe variable
 *
 * @since 1.0.0
 *
 * @type {PlainObject}
 */
tribe.events.virtualAdmin = tribe.events.virtualAdmin || {};

/**
 * Initializes in a Strict env the code that manages the Event Views
 *
 * @since 1.0.0
 *
 * @param  {PlainObject} $   jQuery
 * @param  {PlainObject} obj tribe.events.virtualAdmin
 *
 * @return {void}
 */
( function( $, obj ) {
	'use-strict';
	var $document = $( document ); // eslint-disable-line no-var

	/**
	 * Selectors used for configuration and setup
	 *
	 * @since 1.0.0
	 *
	 * @type {PlainObject}
	 */
	obj.selectors = {
		configure: '.tribe-configure-virtual-button',
		displayOption: '.tribe-events-virtual-display',
		displayOptionCheckbox: '.tribe-events-virtual-display input[type="checkbox"]',
		embedCheckbox: '#tribe-events-virtual-embed-video',
		embedNotice: '.tribe-events-virtual-video-source__not-embeddable-notice',
		embedNoticeShow: '.tribe-events-virtual-video-source__not-embeddable-notice--show',
		embedNoticeText: '.tribe-events-virtual-video-source__not-embeddable-text',
		remove: '.tribe-remove-virtual-event',
		setupCheckbox: '#tribe-events-virtual-setup',
		showOptions: '.tribe-events-virtual-show input',
		showAll: '#tribe-events-virtual-show-to-all',
		virtualContainer: '#tribe-virtual-events',
		virtualUrl: '.tribe-events-virtual-video-source__virtual-url-input',
	};

	/**
	 * Sets checkbox checked attribute
	 *
	 * @since 1.0.0
	 *
	 * @param {boolean} checked whether the checkbox is checked or not
	 *
	 * @return {function} Handler to check the checkbox or not
	 */
	obj.setCheckboxCheckedAttr = function( checked ) {
		return function() {
			$( obj.selectors.setupCheckbox ).prop( 'checked', checked ).trigger( 'verify.dependency' );
		};
	};

	/**
	 * Checks the virtual URL for embeddability.
	 *
	 * @since 1.0.0
	 */
	obj.testEmbed = function() {
		const $input = $( obj.selectors.virtualUrl );
		const url = $input.val();
		const nonce = $input.attr( 'data-nonce' );
		const flag = $input.attr( 'data-oembed-test' );

		// Don't test null data. Or items we don't want tested.
		if ( ! flag || ! url || ! nonce ) {
			// But we'll make sure we hide the notice and enable the checkbox.
			obj.hideOembedNotice();
			return;
		}

		$.ajax( {
			type: 'post',
			dataType: 'json',
			url: ajaxurl,
			data: {
				action: 'tribe_events_virtual_check_oembed',
				url: url,
				nonce: nonce,
			},
		} )
			.done( function() {
				obj.hideOembedNotice();
			} )
			.error( function( response ) {
				obj.showOembedNotice( response );
			} );
	};

	/**
	 * Hide the notice and enable the checkbox.
	 *
	 * @since 1.0.0
	 */
	obj.hideOembedNotice = function() {
		$( obj.selectors.embedNotice ).removeClass( obj.selectors.embedNoticeShow.className() );
		$( obj.selectors.embedCheckbox ).prop( { disabled: false } );
	};

	/**
	 * Show the notice, disable and uncheck the checkbox.
	 *
	 * @since 1.0.0
	 *
	 * @param {object} response The ajax response object.
	 */
	obj.showOembedNotice = function( response ) {
		$( obj.selectors.embedNoticeText ).html( response.responseJSON.data );
		$( obj.selectors.embedNotice ).addClass( obj.selectors.embedNoticeShow.className() );
		$( obj.selectors.embedCheckbox ).prop( {
			disabled: true,
			checked: false,
		} );
	};

	/**
	 * Handle the enabling and disabling of the Show controls depending on the Display options.
	 *
	 * @since 1.0.0
	 */
	obj.handleShowOptionEnablement = function() {
		var checked = $( obj.selectors.displayOption ).find( ':checked:visible' ).length;
		var $showOptions = $( obj.selectors.showOptions );

		if ( checked > 0 ) {
			$showOptions.prop( { disabled: false } );

			return;
		}

		$showOptions.prop( { disabled: true } );
	};

	obj.handleShowOptionInteractivity = function( e ) {
		if ( ! ( e && e.hasOwnProperty( 'target' ) ) ) {
			// Empty on new posts.
			return;
		}

		var $this = $( e.target );
		if ( ! $this.prop( 'checked' ) ) {
			return;
		}

		if ( 'all' === $this.val() ) {
			return;
		}

		$( obj.selectors.showAll ).prop( 'checked', false );
	};

	/**
	 * Bind events for virtual events admin
	 *
	 * @since 1.0.0
	 *
	 * @return {void}
	 */
	obj.bindEvents = function() {
		$( obj.selectors.virtualContainer )
			.on( 'click', obj.selectors.configure, obj.setCheckboxCheckedAttr( true ) )
			.on( 'click', obj.selectors.remove, obj.setCheckboxCheckedAttr( false ) )
			.on( 'blur', obj.selectors.virtualUrl, obj.testEmbed )
			.on( 'click', obj.selectors.displayOptionCheckbox, obj.handleShowOptionEnablement )
			.on( 'change', obj.selectors.showOptions, obj.handleShowOptionInteractivity );
	};

	/**
	 * Handles the initialization of the admin when Document is ready
	 *
	 * @since 1.0.0
	 *
	 * @return {void}
	 */
	obj.ready = function() {
		obj.bindEvents();
		obj.testEmbed();
	};

	// Configure on document ready
	$document.ready( obj.ready );
} )( jQuery, tribe.events.virtualAdmin );
