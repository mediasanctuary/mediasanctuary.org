<?php
/*
* Options customizer
*/

//Adding section in customizer
function responsive_blog_customize_register( $wp_customize ) {

/*================ Removing custom front page option from parent theme ======================*/
$wp_customize->remove_control('res_front_page');

/**
	 * Class Responsive_Blog_Form
	 *
	 * Creates a form input type with the option to add description and placeholders
	 *
	 */
	class Responsive_Blog_Form extends WP_Customize_Control {

		public $description = '';
		public $placeholder = '';

		public function render_content() {
			switch( $this->type ) {
				case 'text':
					?>
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<input type="text" <?php if( $this->placeholder != '' ): ?> placeholder="<?php echo esc_attr( $this->placeholder ); ?>"<?php endif; ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
						<?php if( $this->description != '' ) : ?>
							<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
						<?php endif; ?>
					</label>
					<?php
					break;
				case 'textarea':
					?>
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<textarea <?php if( $this->placeholder != '' ): ?> placeholder="<?php echo esc_attr( $this->placeholder ); ?>"<?php endif; ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> style="width: 97%; height: 200px;"></textarea>
						<?php if( $this->description != '' ) : ?>
							<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
						<?php endif; ?>
					</label>
					<?php
					break;
			}
		}
	}


	/**
	 * TYPOGRAPHY
	 */
	$wp_customize->add_section( 'responsive_blog_typography', array(
		'title'    => __( 'Typography', 'responsive' ),
		'priority' => 39
	) );

	// Heading font selection
	$wp_customize->add_setting( 'responsive_blog_font_heading', array(
		'default' => '"Roboto", sans-serif',
		'type'    => 'theme_mod',
		'sanitize_callback' => 'responsive_blog_text_sanitize'
	) );

	// Heading font selection
	$wp_customize->add_control( 'font_heading', array(
		'label'    => __( 'Title Font', 'responsive' ),
		'section'  => 'responsive_blog_typography',
		'settings' => 'responsive_blog_font_heading',
		'type'     => 'select',
		'choices'  => responsive_blog_fonts(),
		'priority' => 1
	) );

	// Google heading font
	$wp_customize->add_setting( 'responsive_blog_google_font_heading', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'responsive_blog_text_sanitize'
	) );

	// Google heading font
	$wp_customize->add_control( new Responsive_Blog_Form( $wp_customize, 'google_font_heading', array(
		'label'       => __( 'Google Title Font', 'responsive' ),
		'section'     => 'responsive_blog_typography',
		'settings'    => 'responsive_blog_google_font_heading',
		'type'        => 'text',
		'description' => __( 'Enter the Google Font name', 'responsive' ),
		'priority'    => 2
	) ) );

	// Text font selection
	$wp_customize->add_setting( 'responsive_blog_font_text', array(
		'default'           => '"Roboto", sans-serif',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'responsive_blog_text_sanitize'
	) );

	// Text font selection
	$wp_customize->add_control( 'font_text', array(
		'label'    => __( 'Text Font', 'responsive' ),
		'section'  => 'responsive_blog_typography',
		'settings' => 'responsive_blog_font_text',
		'type'     => 'select',
		'choices'  => responsive_blog_fonts(),
		'priority' => 3
	) );

	// Google text font
	$wp_customize->add_setting( 'responsive_blog_google_font_text', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'responsive_blog_text_sanitize'
	) );

	// Google text font
	$wp_customize->add_control( new Responsive_Blog_Form( $wp_customize, 'google_font_text', array(
		'label'       => __( 'Google Text Font', 'responsive' ),
		'section'     => 'responsive_blog_typography',
		'settings'    => 'responsive_blog_google_font_text',
		'type'        => 'text',
		'description' => __( 'Enter the Google Font name', 'responsive' ),
		'priority'    => 4
	) ) );


}
add_action( 'customize_register', 'responsive_blog_customize_register', 100 );

/**
 * Strips tags and html from input
 *
 * @param $input text
 *
 * @return string
 */
function responsive_blog_text_sanitize( $input ) {

	// Remove tags etc
	$input = sanitize_text_field( $input );

	return $input;
}

/**
 * Create an array of font options
 *
 * @return array
 */
function responsive_blog_fonts() {
	// Create an array of fonts
	$fonts = array(
		'google'                                           => 'Google Font',
		'Arial, Helvetica, sans-serif'                     => 'Arial',
		'Arial Black, Gadget, sans-serif'                  => 'Arial Black',
		'Comic Sans MS, cursive'                           => 'Comic Sans MS',
		'Courier New, monospace'                           => 'Courier New',
		'Georgia, serif'                                   => 'Georgia',
		'Impact, Charcoal, sans-serif'                     => 'Impact',
		'Lucida Console, Monaco, monospace'                => 'Lucida Console',
		'Lucida Sans Unicode, Lucida Grande, sans-serif'   => 'Lucida Sans Unicode',
		'"Open Sans", sans-serif'                          => 'Open Sans',
		'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
		'Tahoma, Geneva, sans-serif'                       => 'Tahoma',
		'Times New Roman, Times, serif'                    => 'Times New Roman',
		'Trebuchet MS, sans-serif'                         => 'Trebuchet MS',
		'Verdana, Geneva, sans-serif'                      => 'Verdana',
		'MS Sans Serif, Geneva, sans-serif'                => 'MS Sans Serif',
		'MS Serif, New York, serif'                        => 'MS Serif',
		'"Unica One", cursive' => 'Unica One',
		'"Source Sans Pro", sans-serif' => 'Source Sans Pro',
		'"Roboto", sans-serif' => 'Roboto'
	);

	return $fonts;
}

function responsive_blog_customizer_enqueue() {

	// Javascript
	wp_enqueue_script( 'responsive-blog-customizer', get_stylesheet_directory_uri() . '/lib/js/customizer.js', array(), '1.0.0.5', true );

}

add_action( 'customize_controls_enqueue_scripts',  'responsive_blog_customizer_enqueue' );
