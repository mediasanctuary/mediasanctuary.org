<?php
/**
 * Marker for a virtual event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-virtual/components/virtual-event.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @since 1.0.4 -
 *
 * @version 1.0.4
 *
 * @var \WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

// Don't print anything when this event is not virtual.
if ( ! $event->virtual || ! $event->virtual_show_on_views ) {
	return;
}

// translators: %s (singular)
$virtual_label = tribe_get_virtual_label();
// translators: %s: Event (singular)
$virtual_event_label = tribe_get_virtual_event_label_singular();

?>
<div class="tribe-common-b2 tribe-common-b2--bold tribe-events-virtual-virtual-event">
	<em
		class="tribe-events-virtual-virtual-event__icon"
		aria-label="<?php echo esc_attr( $virtual_label ); ?>"
		title="<?php echo esc_attr( $virtual_label ); ?>"
	>
		<?php $this->template( 'components/icons/virtual', [ 'classes' => [ 'tribe-events-virtual-virtual-event__icon-svg' ] ] ); ?>
	</em>
	<span class="tribe-events-virtual-virtual-event__text">
		<?php echo esc_html( $virtual_event_label ); ?>
	</span>
</div>