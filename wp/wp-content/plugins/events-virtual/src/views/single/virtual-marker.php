<?php
/**
 * Marker for a single virtual event.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-virtual/single/virtual-marker.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTICLE_LINK_HERE}
 *
 * @version 1.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

// Don't print anything when this event is not virtual.
if ( ! $event->virtual || ! $event->virtual_show_on_event ) {
	return;
}

$virtual_label = tribe_get_virtual_event_label_singular();

?>
<div class="tribe-events-virtual-single-marker">
	<em
		class="tribe-events-virtual-single-marker__icon"
		aria-label="<?php echo esc_attr( $virtual_label ); ?>"
		title="<?php echo esc_attr( $virtual_label ); ?>"
	>
		<?php $this->template( 'components/icons/virtual', [ 'classes' => [ 'tribe-events-virtual-single-marker__icon-svg' ] ] ); ?>
	</em>
	<?php echo esc_html( $virtual_label ); ?>
</div>
