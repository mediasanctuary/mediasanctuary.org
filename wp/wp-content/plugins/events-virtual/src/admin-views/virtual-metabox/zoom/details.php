<?php
/**
 * View: Virtual Events Metabox Zoom API link controls.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/virtual-metabox/zoom/details.php
 *
 * See more documentation about our views templating system.
 *
 * @since   1.0.0
 *
 * @version 1.0.0
 *
 * @link    http://m.tri.be/1aiy
 *
 * @var \WP_Post      $event             The event post object, as decorated by the `tribe_get_event` function.
 * @var string        $remove_link_url   The URL to remove the event Zoom Meeting.
 * @var string        $remove_link_label The label of the button to remove the event Zoom Meeting link.
 * @var string        $details_title     The title of the details box.
 * @var string        $id_label          The label used to prefix the meeting ID.
 * @var array<string> $phone_numbers     A list of the available meeting dial-in phone numbers.
 *
 * @see     tribe_get_event() For the format of the event object.
 */

?>

<?php
if ( ! isset( $event->virtual, $event->zoom_join_url, $event->zoom_meeting_id ) ) {
	return;
}

// Remove the query vars from the zoom URL to avoid too long a URL in display.
$short_zoom_url = implode(
	'',
	array_intersect_key( wp_parse_url( $event->zoom_join_url ), array_flip( [ 'host', 'path' ] ) )
);
?>


<div
	id="tribe-events-virtual-meetings-zoom"
	class="tribe-events-virtual-meetings-zoom-details"
>

	<a
		class="tribe-events-virtual-meetings-zoom__remove-link"
		href="<?php echo esc_url( $remove_link_url ); ?>"
		aria-label="<?php echo esc_attr( $remove_link_label ); ?>"
		title="<?php echo esc_attr( $remove_link_label ); ?>"
	>
		×
	</a>

	<span class="tribe-events-virtual-meetings-zoom__title">
		<?php echo esc_html( $details_title ) ?>
	</span>

	<div class="tribe-events-virtual-meetings-zoom__url-wrapper">
		<?php
		$this->template(
			'virtual-metabox/zoom/icons/video',
			[
				'classes' => [
					'tribe-events-virtual-meeting-zoom__icon',
					'tribe-events-virtual-meeting-zoom__icon--video',
				],
			]
		);
		?>
		<div class="tribe-events-virtual-meetings-zoom__url">
			<a
				href="<?php echo esc_url( $event->zoom_join_url ); ?>"
				class="tribe-events-virtual-meetings-zoom__url-meeting-link"
			>
				<?php echo esc_html( $short_zoom_url ); ?>
			</a>
			<div class="tribe-events-virtual-meetings-zoom__url-meeting-id">
				<?php echo esc_html( $id_label ); ?>
				<?php echo esc_html( $event->zoom_meeting_id ); ?>
			</div>
		</div>
	</div>

	<?php if ( count( $phone_numbers ) ) : ?>
		<div class="tribe-events-virtual-meetings-zoom__phone-wrapper">
			<?php
			$this->template(
				'virtual-metabox/zoom/icons/phone',
				[
					'classes' => [
						'tribe-events-virtual-meeting-zoom__icon',
						'tribe-events-virtual-meeting-zoom__icon--phone',
					],
				]
			);
			?>
			<ul class="tribe-events-virtual-meetings-zoom__phone-list">
				<?php foreach ( $phone_numbers as $phone_number => $country ) : ?>
					<li class="tribe-events-virtual-meetings-zoom__phone-list-item">
						<a
							href="<?php echo esc_url( 'tel:' . trim( str_replace( ' ', '', $phone_number ) ) ); ?>"
							class="tribe-events-virtual-meetings-zoom__phone-list-item-number"
						>
							<?php echo esc_html( "({$country}) {$phone_number}" ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

</div>
