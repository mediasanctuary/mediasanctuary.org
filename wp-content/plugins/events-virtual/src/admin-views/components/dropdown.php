<?php
/**
 * View: Virtual Events Metabox Dropdown.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/admin-views/components/dropdown.php
 *
 * See more documentation about our views templating system.
 *
 * @link    https://evnt.is/1aiy
 *
 * @since   1.8.0 - Add $classes_wrap, $classes_label and $wrap_attrs to be able to use with the dependency script.
 *
 * @version 1.8.0
 *
 * @var string               $label         Label for the dropdown input.
 * @var string               $id            ID of the dropdown input.
 * @var array<string,string> $classes_wrap  An array of classes for the dropdown wrap.
 * @var array<string,string> $classes_label An array of classes for the label.
 * @var string               $class         Class attribute for the dropdown input.
 * @var string               $name          Name attribute for the dropdown input.
 * @var string|int           $selected      The selected option id.
 * @var array<string,string> $attrs         Associative array of attributes of the dropdown.
 * @var array<string,string> $wrap_attrs    Associative array of attributes of the dropdown wrap.
 * @var array<string,string> $tooltip       An optional associative array containing information to display in a tooltip.
 */

$wrap_classes = [ 'tribe-events-virtual-meetings-control', 'tribe-events-virtual-meetings-control--select' ];
if ( ! empty( $classes_wrap ) ) {
	$wrap_classes = array_merge( $wrap_classes, $classes_wrap );
}

$label_classes = [ 'tribe-events-virtual-meetings-control__label' ];
if ( ! empty( $classes_label ) ) {
	$label_classes = array_merge( $label_classes, $classes_label );
}

if ( empty( $wrap_attrs ) ) {
	$wrap_attrs = [];
}
?>
<div
	<?php tribe_classes( $wrap_classes ); ?>
	<?php tribe_attributes( $wrap_attrs ) ?>
>
	<label
		<?php tribe_classes( $label_classes ); ?>
		for="<?php echo esc_attr( $id ); ?>"
	>
		<?php echo esc_html( $label ); ?>
	</label><?php // Move opening and closing php tags next to html tags to prevent whitespace and alignment issues.
		if ( ! empty( $tooltip['message'] ) ) {
			$this->template( 'components/tooltip', $tooltip );
		}
	?><select
		id="<?php echo esc_attr( $id ); ?>"
		name="<?php echo esc_attr( $name ); ?>"
		class="tribe-dropdown <?php echo esc_attr( $class ); ?>"
		value="<?php echo esc_attr( $selected ); ?>"
		style="width: 100%;" <?php /* This is required for selectWoo styling to prevent select box overflow */ ?>
		<?php tribe_attributes( $attrs ) ?>
	>
	</select>
</div>
