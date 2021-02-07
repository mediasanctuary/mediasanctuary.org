<?php

/**
 * Remove the cyberchimps upgrade bar from options
 */

function responsive_blog_remove_core_func()
{
	remove_action( 'responsive_theme_options', 'responsive_upgrade_bar', 1 );
}
add_action('wp_loaded', 'responsive_blog_remove_core_func');

// User login and authentication check

if ( get_transient('cc_validate_user_details') === false)
{
	$cc_user_login_id = get_option("cc_account_user_details");

	if ( $cc_user_login_id != '' ) {
		$username = $cc_user_login_id['username'];	$password = $cc_user_login_id['password'];

		require_once( get_stylesheet_directory() . '/pro/class-cc-updater.php');
		if(isset($username) && isset($password) ) {
			$ccuser = new CC_Updater($username, $password );
			$ccuser->validate();
			set_transient('cc_validate_user_details' , 'validate_user' , WEEK_IN_SECONDS);
		}
	}
}
/**
 * Check for theme updates
 */
$cc_user_account_status = get_option("cc_account_status");
if (isset ( $cc_user_account_status ) && $cc_user_account_status == 'found' ) {
require_once( get_stylesheet_directory(). '/pro/wp-updates-theme.php');
new WPUpdatesThemeUpdater_1932( 'http://wp-updates.com/api/2/theme', basename( get_stylesheet_directory() ) );
}

// Add theme options page for account
function responsive_blog_theme_options_add_page() {
	
	$cyberchimps_login_page = add_theme_page( __( 'CyberChimps Account', 'responsive-blog' ), __( 'CyberChimps Account', 'responsive-blog' ), 'edit_theme_options', 'cyberchimps-account', 'cyberchimps_account_page' );
	
	add_action( "admin_print_styles-$cyberchimps_login_page", 'cyberchimps_load_styles_account' );
}
add_action( 'admin_menu', 'responsive_blog_theme_options_add_page' );

//Function to give style to the account page
function cyberchimps_load_styles_account() {

	// Set template directory uri
	$directory_uri = get_stylesheet_directory_uri();

	wp_enqueue_style( 'options-css', $directory_uri . '/pro/options.css' );
}

//Function to display login page
function cyberchimps_account_page() {
	$strResponseMessage = '';
	$cc_user_login_id = get_option("cc_account_user_details");

	if (isset($_POST['ccSubmitBtn']))
	{
		//Unset value if already set
		update_option('cc_account_user_details', '' );
		update_option('cc_account_status', '' );
		$username = $_POST['ccuname'];	$password = $_POST['ccpwd'];

		require_once ('class-cc-updater.php');
		if(isset($username) && isset($password) ) {
			$ccuser = new CC_Updater($username, $password );
			$strResponseMessage = $ccuser->validate();
			set_transient('cc_validate_user_details' , 'validate_user' , WEEK_IN_SECONDS);
			$cc_user_login_id = get_option("cc_account_user_details");
		}
	}
	?>							
				
				<div class="panel-heading"><h3 class="panel-title" style="line-height: 20px;"><?php echo "Enter CyberChimps Account Details";?></h3></div>				
				<div class="panel panel-primary">
<span class="ccinfo"><?php _e('To receive update notifications and to update automatically, please authenticate your access using your CyberChimps Login Credentials','responsive') ?></span>
		
					<span class="updateres"><?php if ($strResponseMessage != '' ) echo $strResponseMessage; ?></span>
				      <div class="panel-body">
						<form action="" id="formSettings" method="post">
							 <div class="form-group">
								<label for="ccuname">User Name</label>
							    <input type="text" id="ccuname" class="form-control" name="ccuname" placeholder="Enter Account User Name" data-placement="right" title="Please Enter User Name" value="<?php echo $cc_user_login_id['username'];?>"/>
								  <label for="ccpwd">Password</label>
								<input type="password" id="ccpwd" class="form-control" name="ccpwd" placeholder="Enter Password" data-placement="right" title="Please Enter Password" value="<?php echo $cc_user_login_id['password'];?>"/>
						   </div>
						   <input type="submit" id="ccSubmitBtn" name="ccSubmitBtn" class="button button-primary" value="Authenticate">						   
					   </form>
					</div>
				</div>
			 	   
	<?php 	 		
		}

//Function to display if inavalid account details
add_action('admin_notices', 'cyberchimps_invalid_account_details');
function cyberchimps_invalid_account_details() {

	if ( 'not_found' === get_option('cc_account_status') ) {
		printf( __(
		'<div class="notice notice-error is-dismissible"><p><strong>CyberChimps - Invalid Account Details</strong>. Please re-enter <a href="%1$s" class="button">Re-Enter</a></p></div>'),
		esc_url( admin_url( 'admin.php?page=cyberchimps-account' ) )
		);
	}

	if ( '' === get_option('cc_account_user_details') ) {
		printf( __(
		'<div class="notice notice-info"><p><strong>Please enter CyberChimps Account Details in order to receive auto updates when available</strong>. <a href="%1$s" class="button">Click Here</a></p></div>'),
		esc_url( admin_url( 'admin.php?page=cyberchimps-account' ) )
		);
	}
}


/**
 * Include the TGM_Plugin_Activation class.
 */
//require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins() {

	$plugins = array(

		array(
			'name'               => 'SlideDeck3', // The plugin name.
			'slug'               => 'slidedeck3-personal', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/pro/plugins/slidedeck3-personal.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
	);

	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
			'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
			'installing'                      => __( 'Installing Plugin: %s', 'theme-slug' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'theme-slug' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'theme-slug'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'theme-slug'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'theme-slug'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'theme-slug'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'theme-slug' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'theme-slug' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'theme-slug' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'theme-slug' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'theme-slug' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'theme-slug' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'tgmpa' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),		
	);
	tgmpa( $plugins, $config );
}
