<?php
/**
 * View: Virtual Events Metabox Zoom API link controls.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/virtual-metabox/zoom/controls.php
 *
 * See more documentation about our views templating system.
 *
 * @since   1.4.0
 *
 * @version 1.4.0
 *
 * @link    http://m.tri.be/1aiy
 *
 * @var \WP_Post             $event                   The event post object, as decorated by the `tribe_get_event` function.
 * @var string               $offer_or_label          The localized "or" string.
 * @var string               $generation_toogle_label The label of the accordion button to show the generation links.
 * @var array<string,string> $generation_urls         A map of the available URL generation labels and URLs.
 * @var string               $generate_label          The label used to designate the next step in generation of a Zoom Meeting or Webinar.
 * @var array<string,string> $hosts                   An array of users to be able to select as a host, that are formatted to use as options.
 *
 * @see     tribe_get_event() For the format of the event object.
 */

$metabox_id = 'tribe-events-virtual';
?>

<div
	id="tribe-events-virtual-meetings-zoom"
	class="tribe-events-virtual-meetings-zoom-details"
>
	<span class="tribe-events-virtual-meetings-zoom-details__or-label">
		<?php echo esc_html( $offer_or_label ); ?>
	</span>

	<button
		class="tribe-dependent tribe-events-virtual-meetings-zoom-details__generate-zoom-button button"
		type="button"
		data-depends="#<?php echo esc_attr( "{$metabox_id}-zoom-link-generate" ); ?>"
		data-condition-not-checked
	>
		<?php echo esc_html( _x( 'Generate Zoom Meeting', 'The button to open the Zoom Generate Settings', 'events-virtual' ) ); ?>
	</button>
	<div class="screen-reader-text">
		<label for="<?php echo esc_attr( "{$metabox_id}-zoom-link-generate" ); ?>">
			<input
				id="<?php echo esc_attr( "{$metabox_id}-zoom-link-generate" ); ?>"
				name="<?php echo esc_attr( "{$metabox_id}[virtual_zoom]" ); ?>"
				type="checkbox"
				value="yes"
			/>
			<?php
			echo esc_html(
				sprintf( /* Translators: single event term. */
					_x( 'Open the Zoom Generate Settings %1$s',
						'Setup settings for Zoom link checkbox label',
						'events-virtual'
					),
					tribe_get_event_label_singular_lowercase()
				)
			);
			?>
		</label>
	</div>
	<div
		class="tribe-dependent tribe-events-virtual-meetings-zoom-details__inner"
		data-depends="#tribe-events-virtual-zoom-link-generate"
		data-condition-checked
	>
		<div class="tribe-events-virtual-meetings-zoom-details__title">
			<?php echo esc_html( _x( 'Zoom Meeting', 'Title for Zoom Meeting or Webinar creation.', 'events-virtual' ) ); ?>
		</div>

		<?php $this->template( 'virtual-metabox/zoom/components/dropdown', $hosts ); ?>

		<div class="tribe-events-virtual-meetings-zoom-details__types">
			<?php foreach ( $generation_urls as $zoom_type => list( $generate_link_url, $generate_link_label ) ) : ?>

				<?php
				$this->template( 'virtual-metabox/zoom/components/radio', [
					'metabox_id' => $metabox_id,
					'zoom_type'       => $zoom_type,
					'link'       => $generate_link_url,
					'label'      => $generate_link_label,
					'checked'    => 'meeting',
					'attrs'       => [
						'placeholder' => _x(
						    'Select a Host',
						    'The placeholder for the dropdown to select a host.',
						    'events-virtual'
						),
						'data-zoom-type' => $zoom_type,
					],
				] );
				?>
			<?php endforeach; ?>
		</div>

		<span class="tribe-events-virtual-meetings-zoom-details__create-link-wrapper">
			<a
				class="button tribe-events-virtual-meetings-zoom-details__create-link"
				href="<?php echo esc_url( $generation_urls['meeting'][0] ); ?>"
			>
				<?php echo esc_html( $generate_label ); ?>
			</a>
		</span>

	</div>
</div>
