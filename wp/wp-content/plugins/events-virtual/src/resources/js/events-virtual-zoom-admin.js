/* eslint-disable no-var */
/**
 * Makes sure we have all the required levels on the Tribe Object
 *
 * @since 1.0.0
 *
 * @type   {PlainObject}
 */
window.tribe = window.tribe || {};
tribe.events = tribe.events || {};
tribe.events.views = tribe.events.views || {};

/**
 * Configures Virtual Events Admin Object on the Global Tribe variable
 *
 * @since 1.0.0
 *
 * @type {PlainObject}
 */
tribe.events.virtualAdmin = tribe.events.virtualAdmin || {};

/**
 * Configures Virtual Events Admin Object on the Global Tribe variable
 *
 * @since 1.0.0
 *
 * @type   {PlainObject}
 */
tribe.events.virtualAdminZoom = tribe.events.virtualAdminZoom || {};

/**
 * Initializes in a Strict env the code that manages the Event Views
 *
 * @since 1.0.0
 *
 * @param  {PlainObject} $            jQuery
 * @param  {PlainObject} obj          tribe.events.virtualAdminZoom
 * @param  {PlainObject} virtualAdmin tribe.events.virtualAdmin
 *
 * @return {void}
 */
( function( $, obj, virtualAdmin ) {
	'use-strict';
	var $document = $( document ); // eslint-disable-line no-var
	var $window = $( window );

	/**
	 * Selectors used for configuration and setup
	 *
	 * @since 1.0.0
	 *
	 * @type {PlainObject}
	 */
	obj.selectors = {
		displayLinkOption: '#tribe-events-virtual-meetings-zoom-display-details',
		embedVideoOption: '#tribe-events-virtual-embed-video',
		hidden: '.tribe-events-virtual-hidden',
		linkedButtonOption: '#tribe-events-virtual-linked-button',
		meetingCreate: '.tribe-events-virtual-meetings-zoom__create-link',
		meetingDetails: '.tribe-events-virtual-meetings-zoom-details',
		meetingDetailsFloat: '.tribe-events-virtual-meetings-zoom-details--float',
		meetingRemove: '.tribe-events-virtual-meetings-zoom__remove-link',
		remove: '.tribe-remove-virtual-event',
		urlField: '.tribe-events-virtual-video-source__virtual-url-input',
		virtualContainer: '#tribe-virtual-events',
		zoomMeetingsContainer: '#tribe-events-virtual-meetings-zoom',
	};

	/**
	 * Original state of the UI controls related to Zoom meetings.
	 *
	 * @since 1.0.0
	 *
	 * @type {PlainObject}
	 */
	obj.originalState = {
		linkedButtonOption: {
			checked: $( obj.selectors.linkedButtonOption ).prop( 'checked' ),
		},
	};

	/**
	 * State of the UI controls related to Zoom meeting.
	 *
	 * @since 1.0.0
	 *
	 * @type {PlainObject}
	 */
	obj.state = {
		urlField: {
			value: '',
		},
	};

	/**
	 * Handles the click on a link to generate or remove a meeting.
	 *
	 * @since 1.0.0
	 *
	 * @param {Event} ev The click event.
	 */
	obj.handleMeetingRequest = function( ev ) {
		ev.preventDefault();
		var url = $( ev.target ).attr( 'href' );

		$.ajax(
			url,
			{
				contentType: 'application/json',
				context: $( obj.selectors.zoomMeetingsContainer ),
				success: obj.onMeetingHandlingSuccess,
			}
		);
	};

	/**
	 * Handles the successful response from the backend to a meeting-related request.
	 *
	 * @since 1.0.0
	 *
	 * @param {string} html The HTML that should replace the current meeting controls HTML.
	 */
	obj.onMeetingHandlingSuccess = function( html ) {
		$( obj.selectors.zoomMeetingsContainer ).replaceWith( html );
		obj.setupControls();
		obj.checkButtons();
		obj.handleMeetingDetailsClasses();
		obj.initMultipleControlsAccordion();

		if (
			virtualAdmin.handleShowOptionInteractivity &&
			typeof virtualAdmin.handleShowOptionInteractivity === 'function'
		) {
			virtualAdmin.handleShowOptionInteractivity();
		}
	};

	/**
	 * Handles the classes for the meeting details.
	 *
	 * @since 1.0.0
	 */
	obj.handleMeetingDetailsClasses = function() {
		var $meetingDetails = $( obj.selectors.meetingDetails );

		if ( ! $meetingDetails.length ) {
			return;
		}

		var $urlField = $( obj.selectors.urlField );
		var content = $urlField.parent();
		var isWide = content.width() >=
			$meetingDetails.outerWidth( true ) + $urlField.outerWidth( true );

		if ( isWide ) {
			$meetingDetails.addClass( obj.selectors.meetingDetailsFloat.className() );
		} else {
			$meetingDetails.removeClass( obj.selectors.meetingDetailsFloat.className() );
		}
	};

	/**
	 * Ensures that when we delete the virtual meta, we also delete the Meeting meta/details.
	 *
	 * @since 1.0.0
	 */
	obj.handleLinkedMetaRemove = function() {
		$( obj.selectors.meetingRemove ).click();
	};

	/**
	 * Bind events for virtual events admin.
	 *
	 * @since 1.0.0
	 *
	 * @return {void}
	 */
	obj.bindEvents = function() {
		$( obj.selectors.virtualContainer )
			.on( 'click', obj.selectors.meetingCreate, obj.handleMeetingRequest )
			.on( 'click', obj.selectors.remove, obj.handleLinkedMetaRemove )
			.on( 'click', obj.selectors.meetingRemove, obj.handleMeetingRequest );
		$( window ).on( 'resize', obj.handleMeetingDetailsClasses );
	};

	/**
	 * Check both the "Linked Button" and "Zoom Link w/ details" options.
	 *
	 * @since 1.0.0
	 *
	 * @return {void}
	 */
	obj.checkButtons = function() {
		var $displayLinkOption = $( obj.selectors.displayLinkOption );
		var $linkedButtonOption = $( obj.selectors.linkedButtonOption );

		$linkedButtonOption.prop( 'checked', true );
		$displayLinkOption.prop( 'checked', true );
	};

	/**
	 * Sets up the UI controls in accord w/ the current Zoom Meeting details state.
	 *
	 * @since 1.0.0
	 *
	 * @return {void}
	 */
	obj.setupControls = function() {
		var $urlField = $( obj.selectors.urlField );
		var $embedVideoOptionItem = $( obj.selectors.embedVideoOption ).closest( 'li' );
		var $displayLinkOptionItem = $( obj.selectors.displayLinkOption ).closest( 'li' );
		var $linkedButtonOption = $( obj.selectors.linkedButtonOption );

		if ( $( obj.selectors.meetingDetails ).length ) {
			// Disable the URL field.
			$urlField
				.prop( { disabled: true } )
				.attr(
					'placeholder',
					tribe_events_virtual_placeholder_strings.zoom
				);
			// Hide the "Embed Video" option.
			$embedVideoOptionItem.addClass( obj.selectors.hidden.className() );
			// Show the Zoom link display option.
			$displayLinkOptionItem.removeClass( obj.selectors.hidden.className() );
			// Store URL field value in state.
			obj.state.urlField.value = $urlField.val();
			$urlField.val( '' );
		} else {
			// Enable the URL field.
			$urlField
				.prop( { disabled: false } )
				.attr(
					'placeholder',
					tribe_events_virtual_placeholder_strings.video
				);
			// Show the "Embed Video" option.
			$embedVideoOptionItem.removeClass( obj.selectors.hidden.className() );
			// Hide the Zoom link display option.
			$displayLinkOptionItem.addClass( obj.selectors.hidden.className() );
			// Restore the status of the "Linked Button" option to its original state.
			$linkedButtonOption.prop( 'checked', obj.originalState.linkedButtonOption.checked );
			// Restore URL field value from state.
			$urlField.val( obj.state.urlField.value );
			obj.state.urlField.value = '';
		}
	};

	obj.initMultipleControlsAccordion = function() {
		if ( ! tribe.events.views.accordion ) {
			return;
		}
		var accordion = tribe.events.views.accordion;
		var controlsSelector = '#tribe-events-virtual-meetings-zoom' +
			'.tribe-events-virtual-meetings-zoom-controls--multi';
		var $container = $( controlsSelector );
		accordion.bindAccordionEvents( $container );
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
		obj.handleMeetingDetailsClasses();
		obj.initMultipleControlsAccordion();
	};

	// Configure on document ready
	$( obj.ready );

	// obj.handleMeetingDetailsClass should be called on Window Load again
	// since the page needs to be fully loaded for the necessary DOM calculations
	$window.on( 'load', obj.handleMeetingDetailsClasses );
} )( jQuery, tribe.events.virtualAdminZoom, tribe.events.virtualAdmin );
