<?php
/**
 * @author            Dhanendran (https://dhanendranrajagopal.me/)
 * @link              https://dhanendranrajagopal.me/
 * @since             1.0
 * @package           termtaxconverter
 *
 * @wordpress-plugin
 * Plugin Name:       Term Taxonomy Converter
 * Plugin URI:        https://github.com/dhanendran/term-taxonomy-converter
 * Description:       Copy or convert terms between taxonomies. This plugin, allows you to copy (duplicate) or convert (move) terms from one taxonomy to another or to multiple taxonomies, while maintaining associated posts.
 * Tags:              importer, converter, copy, duplicate, categories and tags converter, taxonomy converter, copy taxonomies, duplicate taxonomies, terms
 * Version:           1.0
 * Author:            Dhanendran
 * Author URI:        http://dhanendranrajagopal.me/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       d9_ttc
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Term Taxonomy Converter.
 */
class D9_Term_Taxonomy_Converter {

	public $taxes = array();
	public $all_terms = array();
	public $hybrids_ids = array();
	
	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	public function add_menu() {
		add_submenu_page( 'tools.php', esc_html__( 'Term Taxonomy Converter', 'd9_ttc' ), esc_html__( 'Term Taxonomy Converter', 'd9_ttc' ), 'manage_options', 'term_tax_converter', array( $this, 'page' ) );
	}

	public function header( $current = 'category' ) {

		$this->populate_taxes();

		echo '<div class="wrap">';
		if ( ! current_user_can( 'manage_categories' ) ) {
			echo '<div class="narrow">';
			echo '<p>' . __( 'Cheatin&#8217; uh?', 'd9_ttc' ) . '</p>';
			echo '</div>';
		} else { ?>
			<h2 class="nav-tab-wrapper">
				<?php foreach ( $this->taxes as $name => $tax ) {
					if ( $name === $current )
						$classes = 'nav-tab nav-tab-active';
					else
						$classes = 'nav-tab';
					?>
					<a class="<?php echo $classes; ?>" href="tools.php?page=term_tax_converter&amp;tax=<?php echo $name; ?>"><?php echo $tax->label; ?></a>
				<?php } ?>
			</h2>
		<?php }
	}

	public function footer() {
		echo '</div>';
	}

	public function populate_taxes() {
		$taxonomies = get_taxonomies( array( 'public' => true ),'names' );
		foreach ( $taxonomies as $taxonomy ) {
			if ( $taxonomy !== 'post_format' )
				$this->taxes[ $taxonomy ] = get_taxonomy( $taxonomy );
		}
	}

	public function populate_tax( $tax ) {
		$terms = get_terms( array( $tax ), array( 'get' => 'all' ) );
		foreach ( $terms as $term ) {
			$this->all_terms[ $tax ][] = $term;
			if ( is_array( term_exists( $term->slug ) ) )
				$this->hybrids_ids[] = $term->term_id;
		}
	}

	public function page() {
		$tax = ( isset( $_GET['tax'] ) ) ? sanitize_text_field( $_GET['tax'] ) : 'category';
		$step = ( isset( $_GET['step'] ) ) ? (int) sanitize_text_field( $_GET['step'] ) : 1;

		echo '<br class="clear" />';

		$this->header( $tax );

		if ( current_user_can( 'manage_categories' ) ) {
			if ( 1 === $step )
				$this->tabs( $tax );
			elseif ( $step == 2 )
				$this->process($tax);
		}

		$this->footer();

	}

	public function tabs( $tax ) {
		$this->populate_tax( $tax );
		$num = ( ! empty( $this->all_terms[ $tax ] ) ) ? count( $this->all_terms[ $tax ] ) : 0;
		$details = $this->taxes[ $tax ];

		echo '<br class="clear" />';
		if ( $num > 0 ) {
			echo '<h2>' . esc_html__( 'Convert or Copy '.$details->label, 'd9_ttc' ) . '</h2>';
			echo '<div class="narrow">';
			echo '<p>' . esc_html__( 'Here you can selectively copy or convert existing terms from one taxonomy to another. To get started, choose the original taxonomy (above), choose option to copy or convert, select the terms (below), then click the Go button.', 'd9_ttc' ) . '</p>';
			echo '<p>' . esc_html__( 'NOTE: "converted" terms are removed from original taxonomy, and if you convert a term with children, the children become top-level orphans.', 'd9_ttc' ) . '</p></div>';

			$this->terms_form( $tax );
		} else {
			echo '<p>' . esc_html__( 'You have no terms to convert', 'd9_ttc' ) . '</p>';
		}
	}

	public function terms_form( $tax ) { ?>

		<script type="text/javascript">
			/* <![CDATA[ */
			var checkflag = "false";
			function check_all_rows() {
				field = document.term_list;
				if ( 'false' === checkflag ) {
					for ( i = 0; i < field.length; i++ ) {
						if ( 'terms_to_convert[]' === field[i].name )
							field[i].checked = true;
					}
					checkflag = 'true';
					return '<?php _e('Uncheck All', 'd9_ttc') ?>';
				} else {
					for ( i = 0; i < field.length; i++ ) {
						if ( 'terms_to_convert[]' === field[i].name )
							field[i].checked = false;
					}
					checkflag = 'false';
					return '<?php _e('Check All', 'd9_ttc') ?>';
				}
			}
			/* ]]> */
		</script>

		<form name="term_list" id="term_list" action="tools.php?page=term_tax_converter&amp;tax=<?php echo $tax; ?>&amp;step=2" method="post">

			<p>
				<label><input type="radio" name="convert" value="0" checked="checked" /> Copy</label>
				<label><input type="radio" name="convert" value="1" /> Convert</label>
			</p>
			<p>To taxonomy:
				<?php
				foreach ( $this->taxes as $name => $details ) {
					if ( $name == $tax )
						continue;
					?>
					<label><input type="checkbox" name="taxes[]" value="<?php echo $name; ?>" /> <?php echo $details->label; ?></label>
					<?php
				}
				?>
			</p>

			<p>
				<input type="button" class="button-secondary" value="<?php esc_attr_e('Check All', 'd9_ttc'); ?>" onclick="this.value=check_all_rows()" />
				<?php wp_nonce_field( 'd9_term_taxonomy_converter' ); ?>
			</p>
			<ul style="list-style:none">

				<?php
				$hier = _get_term_hierarchy( $tax );

				foreach ( $this->all_terms[ $tax ] as $term ) {
					$term = sanitize_term( $term, $tax, 'display' );

					if ( (int) $term->parent == 0 ) { ?>

						<li>
							<label><input type="checkbox" name="terms_to_convert[]" value="<?php echo intval( $term->term_id ); ?>" /> <?php echo $term->name . ' (' . $term->count . ')'; ?></label>
							<?php
							if ( in_array( intval( $term->term_id ),  $this->hybrids_ids ) )
								echo ' <a href="#note"> * </a>';

							if ( isset( $hier[ $term->term_id ] ) )
								$this->_term_children( $term, $hier, $tax ); ?>
						</li>
					<?php }
				} ?>
			</ul>
			<?php
			if ( ! empty( $this->hybrids_ids ) )
				echo '<p>' . esc_html__( '* This term is already in another taxonomy, converting will add the new taxonomy term to existing posts in that taxonomy.', 'd9_ttc' ) . '</p>'; ?>

			<p class="submit">
				<input type="submit" name="submit" class="button button-primary" value="<?php esc_attr_e('Go!', 'd9_ttc' ); ?>" />
			</p>
		</form>

	<?php }

	public function _term_children( $parent, $hier, $tax ) { ?>

		<ul style="list-style:none; margin:0.5em 0 0 1.5em;">
		<?php
		foreach ( $hier[ $parent->term_id ] as $child_id ) {
			$child = get_term( $child_id, $tax ); ?>
			<li>
				<label><input type="checkbox" name="terms_to_convert[]" value="<?php echo intval( $child->term_id ); ?>" /> <?php echo $child->name . ' (' . $child->count . ')'; ?></label>
				<?php

				if ( in_array( intval( $child->term_id ), $this->hybrids_ids ) )
					echo ' <a href="#note"> * </a>';

				if ( isset( $hier[ $child->term_id ] ) )
					$this->_term_children( $child, $hier, $tax ); ?></li>
		<?php	} ?>
		</ul><?php
	}

	public function process( $tax ) {
		global $wpdb;

		if (
		        ( ! isset( $_POST['terms_to_convert' ] ) || ! is_array( $_POST['terms_to_convert'] ) )
                && empty( $this->terms_to_convert ) || ( ! isset( $_POST['taxes'] ) )
        ) { ?>
            <div class="narrow">
                <p><?php printf( __( 'Uh, oh. Something didn&#8217;t work. Please <a href="%s">try again</a>.', 'd9_ttc' ), esc_attr( 'tools.php?page=term_tax_converter&amp;tax=' . $tax ) ); ?></p>
            </div>
			<?php
            return;
		}

		if ( empty( $this->terms_to_convert ) )
			$this->terms_to_convert = filter_input( INPUT_POST, 'terms_to_convert', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );

		$taxonomy = $this->taxes[ $tax ];

		$convert = sanitize_text_field( $_POST['convert'] );
		if ( $convert )
			$c_label = 'Convert';
		else
			$c_label = 'Copy';

		$new_taxes = filter_input( INPUT_POST, 'taxes', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );

		$hybrid_cats = $clear_parents = $parents = false;
		$clean_term_cache = array();

		echo '<ul>';

		foreach ( (array) $this->terms_to_convert as $term_id ) {
			$term_id = (int) $term_id;
			$exists = term_exists( $term_id, $tax );

			// check if the term exists in the current taxonomy (it always should!)
			if ( empty( $exists ) ) {
				echo '<li>' . sprintf( esc_html__( 'Term %s doesn&#8217;t exist in ' . $taxonomy->label . '!', 'd9_ttc' ),  $term_id ) . "</li>\n";
			} else {
				// if the term exist do the copy/convert
				// $term is the existing term
				$term = get_term( $term_id, $tax );
				echo '<li>' . sprintf( __( $c_label . 'ing term <strong>%s</strong> ... ', 'd9_ttc'), esc_attr( $term->name ) );

				// repeat process for each new taxonomy selected
				foreach ( $new_taxes as $new_tax ) {

					// check if the term is already in the new taxonomy & if not create it
					if ( ! ( $id = term_exists( $term->slug, $new_tax ) ) )
						$id = wp_insert_term( $term->name, $new_tax, array( 'slug' => $term->slug ) );

					// if the term couldn't be created return the error message
					if ( is_wp_error( $id ) ) {
						echo $id->get_error_message() . "</li>\n";
						continue;
					}

					// if the original term has posts, assign them to the new term
					$id = $id['term_taxonomy_id'];
					$posts = get_objects_in_term( $term->term_id, $tax );
					$term_order = 0;

					foreach ( $posts as $post ) {
						$type = get_post_type( $post );
						if ( in_array( $type, $taxonomy->object_type ) )
							$values[] = $wpdb->prepare( "(%d, %d, %d)", $post, $id, $term_order );
						clean_post_cache( $post );
					}

					if ( $values ) {
						$wpdb->query( "INSERT INTO $wpdb->term_relationships (object_id, term_taxonomy_id, term_order ) VALUES " . join( ',', $values ) . " ON DUPLICATE KEY UPDATE term_order = VALUES( term_order )");
						$wpdb->update( $wpdb->term_taxonomy, array( 'count' => $term->count ), array( 'term_id' => $term->term_id, 'taxonomy' => $new_tax ) );

						esc_html_e( 'Term added to posts. ', 'd9_ttc' );

						if ( ! $convert ) {
							$hybrid_cats = true;
						    echo '*';
						}
						$clean_term_cache[] = $term->term_id;
					}


					// Convert term
					if ( $convert ) {
						wp_delete_term( $term_id, $tax );

						// Set all parents to 0 (root-level) if their parent was the converted tag
						$wpdb->update( $wpdb->term_taxonomy, array( 'parent' => 0 ), array( 'parent' => $term_id, 'taxonomy' => $tax ) );

						if ( $parents ) $clear_parents = true;
						$clean_cat_cache[] = $term->term_id;
					}

					// Update term post count.
					wp_update_term_count_now( array( $id ), $new_tax );

					esc_html_e( $c_label.' successful.', 'd9_ttc' );
					echo "</li>\n";
				}
			}
		}
		echo '</ul>';

		if ( ! empty( $clean_term_cache ) ) {
			$clean_term_cache = array_unique( array_values( $clean_term_cache ) );
			clean_term_cache( $clean_term_cache, $new_tax);
		}

		if ( $clear_parents ) delete_option('category_children');

		if ( $hybrid_cats )
			echo '<p>' . esc_html__( '* This term is now in multiple taxonomies. The converter has added the new term to all posts with the original taxonomy term.', 'd9_ttc' ) . '</p>';
		echo '<p>' . sprintf( __( '<a href="%s">Convert More...</a>.', 'd9_ttc'), esc_attr( 'tools.php?page=term_tax_converter' ) ) . '</p>';
	}

}
new D9_Term_Taxonomy_Converter();
