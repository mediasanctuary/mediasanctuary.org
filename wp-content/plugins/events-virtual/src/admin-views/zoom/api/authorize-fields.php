<?php
/**
 * View: Virtual Events Metabox Zoom API auth dis/connect button/link.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/zoom/api/authorize-fields.php
 *
 * See more documentation about our views templating system.
 *
 * @since   1.0.0
 *
 * @version 1.0.0
 *
 * @link    http://evnt.is/1aiy
 *
 * @var Api $api An instance of the Zoom API handler.
 * @var Url $url An instance of the URL handler.
 */

?>
<fieldset id="tribe-field-zoom_token" class="tribe-field tribe-field-text tribe-size-medium">
	<legend class="tribe-field-label"><?php esc_html_e( 'Zoom Connection', 'events-virtual' ); ?></legend>
	<div class="tribe-field-wrap">
		<?php
		$this->template(
			'zoom/api/authorize-fields/connect-link',
			[
				'api' => $api,
				'url' => $url,
			]
		);
		?>
	</div>
</fieldset>
