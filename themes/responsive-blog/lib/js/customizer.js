/**
 * Typography settings for custoizer
 */

jQuery(document).ready(function ($) {

	// Script to hide show the Google Heading Font input depending on value of the Heading select
	var font = $('#customize-control-font_heading select').val();
	if (font != 'google') {
		$('#customize-control-google_font_heading').hide();
	}
	else {
		$('#customize-control-google_font_heading').show();
	}
	$('#customize-control-font_heading select').change(function () {
		var font_change = $(this).val();
		if (font_change != 'google') {
			$('#customize-control-google_font_heading').hide();
		}
		else {
			$('#customize-control-google_font_heading').show();
		}
	});

	// Script to show hide the Google Text Font input depending on the value of the Text select
	var text = $('#customize-control-font_text select').val();
	if (text != 'google') {
		$('#customize-control-google_font_text').hide();
	}
	else {
		$('#customize-control-google_font_text').show();
	}
	$('#customize-control-font_text select').change(function () {
		var text_change = $(this).val();
		if (text_change != 'google') {
			$('#customize-control-google_font_text').hide();
		}
		else {
			$('#customize-control-google_font_text').show();
		}
	});
});

