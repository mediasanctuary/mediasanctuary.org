<?php
/**
 * View: Virtual Events Metabox Zoom API link controls.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/virtual-metabox/zoom/setup.php
 *
 * See more documentation about our views templating system.
 *
 * @since   1.4.0
 * @since   1.5.0 - Add support for multiple accounts.
 * @since   1.6.0 - remove $offer_or_label.
 * @since   1.8.2 - Move create option links to their own template, add wrapper to messages, and add loader template.
 *
 * @version 1.8.2
 *
 * @link    http://m.tri.be/1aiy
 *
 * @var \WP_Post             $event                   The event post object, as decorated by the `tribe_get_event` function.
 * @var array<string,string> $attrs                   Associative array of attributes of the zoom account.
 * @var string               $account_label           The label used to designate the account of a Zoom Meeting or Webinar.
 * @var string               $account_name            The api account name of a Zoom Meeting or Webinar.
 * @var string               $generation_toogle_label The label of the accordion button to show the generation links.
 * @var array<string,string> $generation_urls         A map of the available URL generation labels and URLs.
 * @var string               $generate_label          The label used to designate the next step in generation of a Zoom Meeting or Webinar.
 * @var array<string,string> $hosts                   An array of users to be able to select as a host, that are formatted to use as options.
 * @var string               $remove_link_url         The URL to remove the event Zoom Meeting.
 * @var string               $remove_link_label       The label of the button to remove the event Zoom Meeting link.
 * @var string               $message                 A html message to display.
 * @var array<string|string> $zoom_message_classes    An array of message classes.
 *
 * @see     tribe_get_event() For the format of the event object.
 */

$metabox_id = 'tribe-events-virtual';
?>

<div
	id="tribe-events-virtual-meetings-zoom"
	class="tribe-events-virtual-meetings-zoom-details"
	<?php tribe_attributes( $attrs ) ?>
>

	<div class="tribe-events-virtual-meetings-video-source__inner tribe-events-virtual-meetings-zoom-details__inner">
		<a
			class="tribe-events-virtual-meetings-zoom-details__remove-link"
			href="<?php echo esc_url( $remove_link_url ); ?>"
			aria-label="<?php echo esc_attr( $remove_link_label ); ?>"
			title="<?php echo esc_attr( $remove_link_label ); ?>"
		>
			×
		</a>

		<div
			<?php tribe_classes( $zoom_message_classes ); ?>
			role="alert"
		>
			<?php echo $message; ?>
		</div>

		<div class="tribe-events-virtual-meetings-zoom-details__title">
			<?php echo esc_html( _x( 'Zoom Meeting', 'Title for Zoom Meeting or Webinar creation.', 'events-virtual' ) ); ?>
		</div>

		<div class="tribe-events-virtual-meetings-zoom__account">
			<?php echo esc_html( $account_label ); ?><?php echo esc_html( $account_name ); ?>
		</div>

		<?php $this->template( 'virtual-metabox/zoom/components/dropdown', $hosts ); ?>

		<?php $this->template( 'virtual-metabox/zoom/type-options', [ 'generation_urls' => $generation_urls ] ); ?>

		<span class="tribe-events-virtual-meetings-zoom-details__create-link-wrapper">
			<a
				class="button tribe-events-virtual-meetings-zoom-details__create-link"
				href="<?php echo esc_url( $generation_urls['meeting'][0] ); ?>"
			>
				<?php echo esc_html( $generate_label ); ?>
			</a>
		</span>

		<?php $this->template( '/components/loader' ); ?>

	</div>
</div>
