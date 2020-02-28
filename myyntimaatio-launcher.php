<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://linkedin.com/in/shayanabbas
 * @since             1.0.2
 * @package           Myyntimaatio Launcher
 *
 * @wordpress-plugin
 * Plugin Name:       Myyntimaatio Launcher
 * Plugin URI:        https://myyntimaatio.fi
 * Description:       Myyntimaatio Launcher plugin to install all required plugins and run all neccessary snippets according to company standard.
 * Version:           1.0.2
 * Author:            Shayan Abbas
 * Author URI:        https://linkedin.com/in/shayanabbas
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       myyntimaatio-launcher
 * Domain Path:       /languages
 */

$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = $plugin_data['Version'];
define( 'MM_L_VERSION', $plugin_version );

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once plugin_basename( '/class-tgm-plugin-activation.php' );
/**
 * Include the Puc_v4_Factory class.
 */
require_once plugin_basename( '/plugin-update-checker/plugin-update-checker.php' );

// Adding plugin autoupdate feature
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/shayanabbas/myyntimaatio-launcher/',
	__FILE__,
	'myyntimaatio-launcher'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

add_action( 'tgmpa_register', 'myyntimaatio_register_required_plugins' );

/**
 * Register the required plugins.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function myyntimaatio_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Cookie Consent Plugin
		array(
			'name'      => 'Cookie Consent - Myyntimaatio',
			'slug'      => 'mm-cookie-consent-europe',
			'source'    => 'https://github.com/shayanabbas/mm-cookie-consent-europe/archive/master.zip',
			'required'  => true, // If false, the plugin is only 'recommended' instead of required.
		),

		// All-in-One WP Migration
		array(
			'name'      => 'All-in-One WP Migration By ServMask',
			'slug'      => 'all-in-one-wp-migration',
			'required'  => true,
			'force_activation' => true,
		),

		// All-in-One WP Migration Unlimited Extension
		array(
			'name'      => 'All-in-One WP Migration Unlimited Extension By ServMask',
			'slug'      => 'all-in-one-wp-migration-unlimited-extension',
			'source'    => dirname( __FILE__ ) . '/plugins/all-in-one-wp-migration-unlimited-extension.zip', // The plugin source.
			'required'  => true,
		),

		// Advanced Custom Field PRO Extension
		array(
			'name'      => 'Advanced Custom Fields PRO By Elliot Condon',
			'slug'      => 'advanced-custom-fields-pro',
			'source'    => dirname( __FILE__ ) . '/plugins/advanced-custom-fields-pro.zip', // The plugin source.
		),

		// Elementor
		array(
			'name'      => 'Elementor Page Builder',
			'slug'      => 'elementor',
			'required'  => true,
			'force_activation' => true,
		),

		// Elementor Pro
		array(
			'name'      => 'Elementor Page Builder Pro',
			'slug'      => 'elementor-pro',
			'source'    => dirname( __FILE__ ) . '/plugins/elementor-pro.zip', // The plugin source.
			'required'  => true,
		),

		// iThemes Security
		array(
			'name'      => 'iThemes Security',
			'slug'      => 'better-wp-security',
			'required'  => true,
		),

		// WP Fastest Cache By Emre Vona
		array(
			'name'      => 'WP Fastest Cache By Emre Vona',
			'slug'      => 'wp-fastest-cache',
			'required'  => true,
		),
		
		// Yoast SEO By Team Yoast
		array(
			'name'      => 'Yoast SEO By Team Yoast',
			'slug'      => 'wordpress-seo',
			'required'  => true,
		),
		
		// Redirection By John Godley
		array(
			'name'      => 'Redirection By John Godley',
			'slug'      => 'redirection',
			'required'  => true,
		),

		// Post SMTP Mailer/Email Log
		array(
			'name'      => 'Post SMTP Mailer/Email Log',
			'slug'      => 'post-smtp',
		),

		// Contact Form 7
		array(
			'name'      => 'Contact Form 7 Takayuki Miyoshi',
			'slug'      => 'contact-form-7',
		),

		// Flamingo By Takayuki Miyoshi
		array(
			'name'      => 'Flamingo By Takayuki Miyoshi',
			'slug'      => 'flamingo',
		),

		// Elementor Contact Form DB By Sean Barton - Tortoise IT
		array(
			'name'      => 'Elementor Contact Form DB By Sean Barton',
			'slug'      => 'sb-elementor-contact-form-db',
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'myyntimaatio-fi',        // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      	// Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', 	// Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    		// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'myyntimaatio-fi' ),
			'menu_title'                      => __( 'Install Plugins', 'myyntimaatio-fi' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'myyntimaatio-fi' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'myyntimaatio-fi' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'myyntimaatio-fi' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'myyntimaatio-fi'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'myyntimaatio-fi'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'myyntimaatio-fi'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'myyntimaatio-fi'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'myyntimaatio-fi'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'myyntimaatio-fi'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'myyntimaatio-fi'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'myyntimaatio-fi'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'myyntimaatio-fi'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'myyntimaatio-fi' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'myyntimaatio-fi' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'myyntimaatio-fi' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'myyntimaatio-fi' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'myyntimaatio-fi' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'myyntimaatio-fi' ),
			'dismiss'                         => __( 'Dismiss this notice', 'myyntimaatio-fi' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'myyntimaatio-fi' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'myyntimaatio-fi' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}


// define the filter_wpcf7_messages callback 
function filter_wpcf7_messages() { 
    // translating EN CF7 messages to Soumi
    	$messages = array(
		'mail_sent_ok' => array(
			'description'
				=> __( "Sender's message was sent successfully", 'contact-form-7' ),
			'default'
				=> __( "Kiitos viestistäsi. Se on lähetetty.", 'contact-form-7' ),
		),

		'mail_sent_ng' => array(
			'description'
				=> __( "Sender's message failed to send", 'contact-form-7' ),
			'default'
				=> __( "Viestin lähettämisessä tapahtui virhe. Yritä uudelleen myöhemmin.", 'contact-form-7' ),
		),

		'validation_error' => array(
			'description'
				=> __( "Validation errors occurred", 'contact-form-7' ),
			'default'
				=> __( "Yhdessä tai useammassa kentässä on virhe. Tarkista ja yritä uudelleen.", 'contact-form-7' ),
		),

		'spam' => array(
			'description'
				=> __( "Submission was referred to as spam", 'contact-form-7' ),
			'default'
				=> __( "Viestin lähettämisessä tapahtui virhe. Yritä uudelleen myöhemmin.", 'contact-form-7' ),
		),

		'accept_terms' => array(
			'description'
				=> __( "There are terms that the sender must accept", 'contact-form-7' ),
			'default'
				=> __( "Sinun on hyväksyttävä ehdot ennen viestin lähettämistä.", 'contact-form-7' ),
		),

		'invalid_required' => array(
			'description'
				=> __( "There is a field that the sender must fill in", 'contact-form-7' ),
			'default'
				=> __( "Kenttä on pakollinen.", 'contact-form-7' ),
		),

		'invalid_too_long' => array(
			'description'
				=> __( "There is a field with input that is longer than the maximum allowed length", 'contact-form-7' ),
			'default'
				=> __( "Kenttä on liian pitkä.", 'contact-form-7' ),
		),

		'invalid_too_short' => array(
			'description'
				=> __( "There is a field with input that is shorter than the minimum allowed length", 'contact-form-7' ),
			'default'
				=> __( "Kenttä on liian lyhyt.", 'contact-form-7' ),
		),

		'invalid_date' => array(
			'description' => __( "Date format that the sender entered is invalid", 'contact-form-7' ),
			'default' => __( "Päivämäärän muoto on väärä.", 'contact-form-7' )
		),

		'date_too_early' => array(
			'description' => __( "Date is earlier than minimum limit", 'contact-form-7' ),
			'default' => __( "Päivämäärä on ennen aikaisinta sallittua.", 'contact-form-7' )
		),

		'date_too_late' => array(
			'description' => __( "Date is later than maximum limit", 'contact-form-7' ),
			'default' => __( "Päivämäärä on viimeisimmän sallitun päivämäärän jälkeen.", 'contact-form-7' )
		),

		'upload_failed' => array(
			'description' => __( "Uploading a file fails for any reason", 'contact-form-7' ),
			'default' => __( "Tiedoston lataamisessa tapahtui tuntematon virhe.", 'contact-form-7' )
		),

		'upload_file_type_invalid' => array(
			'description' => __( "Uploaded file is not allowed for file type", 'contact-form-7' ),
			'default' => __( "Sinulla ei ole oikeutta ladata tämän tyyppisiä tiedostoja.", 'contact-form-7' )
		),

		'upload_file_too_large' => array(
			'description' => __( "Uploaded file is too large", 'contact-form-7' ),
			'default' => __( "Tiedosto on liian suuri.", 'contact-form-7' )
		),

		'upload_failed_php_error' => array(
			'description' => __( "Uploading a file fails for PHP error", 'contact-form-7' ),
			'default' => __( "Tiedoston lähettämisessä tapahtui virhe.", 'contact-form-7' )
		),

		'invalid_number' => array(
			'description' => __( "Number format that the sender entered is invalid", 'contact-form-7' ),
			'default' => __( "Numeromuoto on virheellinen.", 'contact-form-7' )
		),

		'number_too_small' => array(
			'description' => __( "Number is smaller than minimum limit", 'contact-form-7' ),
			'default' => __( "Luku on pienempi kuin sallittu vähimmäismäärä.", 'contact-form-7' )
		),

		'number_too_large' => array(
			'description' => __( "Number is larger than maximum limit", 'contact-form-7' ),
			'default' => __( "Lukumäärä on suurempi kuin suurin sallittu.", 'contact-form-7' )
		),

		'quiz_answer_not_correct' => array(
			'description' =>
				__( "Sender doesn't enter the correct answer to the quiz", 'contact-form-7' ),
			'default' =>
				__( "Vastaus tietokilpailuun on väärä.", 'contact-form-7' ),
		),

		'captcha_not_match' => array(
			'description' =>
				__( "The code that sender entered does not match the CAPTCHA", 'contact-form-7' ),
			'default' =>
				__( 'Antamasi koodi on väärä.', 'contact-form-7' ),
		),

		'invalid_email' => array(
			'description' =>
				__( "Email address that the sender entered is invalid", 'contact-form-7' ),
			'default' =>
				__( "Annettu sähköpostiosoite on virheellinen.", 'contact-form-7' ),
		),

		'invalid_url' => array(
			'description' =>
				__( "URL that the sender entered is invalid", 'contact-form-7' ),
			'default' =>
				__( "URL on virheellinen.", 'contact-form-7' ),
		),

		'invalid_tel' => array(
			'description' =>
				__( "Telephone number that the sender entered is invalid", 'contact-form-7' ),
			'default' =>
				__( "Puhelinnumero on virheellinen.", 'contact-form-7' ),
		)
	);
	return $messages; 
}; 

add_filter('wpcf7_messages', 'filter_wpcf7_messages' , 11, 0); 

// Check if PostMan Plugin is installed and activated
function postman_import_settings() {
	if ( is_plugin_active( 'post-smtp/postman-smtp.php' ) ) {
		/**
		 * Include the Postman class.
		 */
		require_once(plugin_dir_path( __DIR__ ) . 'post-smtp/Postman/Postman.php');

		$base64 = 'eNqFU8GS2yAM/RfOmWzW3aTbnPoLvXeGISAnTEBiQKR1O/33CjvOOpudWV8M70lIDz3+KkCreUig9opDUSt1osJoYgNK5LSmvvcWvuy2a0tR+ESZ1X77+nWlCqCDrCEaHyTcErKx3FOO5XscBmQfjWFP695LIuAFAiXQU9rnCZwNllZubrD1I3j76VYTchE0ScNXxlQ+zcGBjh7VrcmrJAFojLLBA7L27gOwgM3AE3EwxVs9srVAvh7zSeeLpGRK+UW5lflR067rvm0lIBp02YegTfL6DMNUq7V6zN7do03pseLHoCNZ4UJdhhQGzTTtpEEL7v3W2rvtYd6fwLjpTseDjCT6CFTlKnabVRONYEUkvuHPgstN6wAyXLV/2cg3dacbDGgOAZp4zhXUgonmt7CcPUi9bitJWeREck1HyuTqWGm2gc0+yWD8H6Gfu1dBY9LONxf9fJK1xCGxF6uasUEZ1UVsK7SD3tTAzbm1nOgiXmiDnETeIKYz4HUKwdjzErg72J4yRdB1Nk5vQji0hNGVi8fzwE0PZ/MeFrPV7LnNFQlhmdZLqdvrejhvYcfHWm+uE04ElnaXe9WtN+ud+vcfuCZgwA==';

		// Decryption starts
		$gz = base64_decode( $base64 );
		$json = @gzuncompress( $gz );
		$data = json_decode( $json, true );
		$data['basic_auth_password'] = base64_encode($data['basic_auth_password']);
		$postmanState = get_option( 'postman_state' );
		$postmanState ['version'] = $data ['version'];
		assert( $postmanState ['version'] == $data ['version'] );

		// If settings are not imported already
		if( PostmanOptions::getInstance()->getUsername() != 'contactforms@myyntimaatio.fi' ) {
			//Importing default configuration of Myyntimaatio SMTP account.
			update_option( 'postman_state', $postmanState );
			update_option( PostmanOptions::POSTMAN_OPTIONS, $data );
		}
	}
}

// Check if Better WP security(iThemes Security) Plugin is installed and activated
function ithemes_security_import_settings() {
	if ( is_plugin_active( 'better-wp-security/better-wp-security.php' ) ) {
		
		/**
		 * Include the Better WP security(iThemes Security) core class.
		 */
		require_once(plugin_dir_path( __DIR__ ) . 'better-wp-security/core/core.php');

		$data = array(  
			'enabled' 			=> true,
			'slug'				=> "kirjautuminen",
			'theme_compat' 		=> true,
			'theme_compat_slug' => "not_found",
			'post_logout_slug' 	=> "",
		);
		ITSEC_Modules::set_settings( 'hide-backend', $data );

		// Set default notification to first user (admin) only
		$get_notification = ITSEC_Modules::get_settings( 'notification-center' );
		$get_notification['default_recipients']['user_list'] = array( '1' );
		ITSEC_Modules::set_settings( 'notification-center', $get_notification );
		
	}
}

// Check if WP Fastest Cache Plugin is installed and activated
function wp_fastest_cache_import_settings() {
	if ( is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ) ) {

		/**
		 * Include the Better WP security(iThemes Security) core class.
		 */
		require_once(plugin_dir_path( __DIR__ ) . 'wp-fastest-cache/wpFastestCache.php');

		update_option( 'WpFastestCachePreLoad', '{"homepage":-1,"post":1,"category":0,"page":1,"tag":0,"attachment":1,"customposttypes":0,"customTaxonomies":0,"number":"4"}' );
		update_option( 'WpFastestCache', '{"wpFastestCacheStatus":"on","wpFastestCachePreload":"on","wpFastestCachePreload_homepage":"on","wpFastestCachePreload_post":"on","wpFastestCachePreload_category":"on","wpFastestCachePreload_page":"on","wpFastestCachePreload_tag":"on","wpFastestCachePreload_attachment":"on","wpFastestCachePreload_customposttypes":"on","wpFastestCachePreload_customTaxonomies":"on","wpFastestCachePreload_number":"4","wpFastestCachePreload_restart":"on","wpFastestCacheLoggedInUser":"on","wpFastestCacheMobile":"on","wpFastestCacheNewPost":"on","wpFastestCacheNewPost_type":"all","wpFastestCacheUpdatePost":"on","wpFastestCacheUpdatePost_type":"post","wpFastestCacheMinifyHtml":"on","wpFastestCacheMinifyCss":"on","wpFastestCacheCombineCss":"on","wpFastestCacheCombineJs":"on","wpFastestCacheGzip":"on","wpFastestCacheLBC":"on","wpFastestCacheDisableEmojis":"on","wpFastestCacheLanguage":"eng"}' );
		$wpfc = new WpFastestCache();
		$wpfc->deleteCache();
	}
}

// Check if ACF PRO is installed and activated
function wp_acf_pro_license_import_settings() {
	if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {

		/**
		 * Include the ACF Pro core class.
		 */
		require_once(plugin_dir_path( __DIR__ ) . 'advanced-custom-fields-pro/acf.php');

		// Connect to ACF API.
		$post = array(
			'acf_license'	=> trim('b3JkZXJfaWQ9MTM2ODI0fHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxOC0wOC0wOCAwODo1MzoyOQ=='),
			'acf_version'	=> acf_get_setting('version'),
			'wp_name'		=> get_bloginfo('name'),
			'wp_url'		=> home_url(),
			'wp_version'	=> get_bloginfo('version'),
			'wp_language'	=> get_bloginfo('language'),
			'wp_timezone'	=> get_option('timezone_string'),
		);
		//var_dump($post);
		$response = acf_updates()->request('v2/plugins/activate?p=pro', $post);

		// On success.
		if( $response['status'] == 1 ) {
			// Update license.
			acf_pro_update_license( $response['license'] );
			
			// Refresh plugins transient to fetch new update data.
			acf_updates()->refresh_plugins_transient();
			
			// Show notice.
			acf_add_admin_notice( $response['message'], 'success' );
		
		// On failure.	
		}
	}
}

function ml_register_settings() {
	
	add_option( 'ml_option_name', '' );
	add_option( 'wp_before_head', '' );
	add_option( 'wp_before_body', '' );
	register_setting( 'ml_options_group', 'ml_option_name', 'ml_callback' );
	register_setting( 'ml_options_group', 'wp_logo_url');
	register_setting( 'ml_options_group', 'wp_logo_height');
	register_setting( 'ml_options_group', 'wp_logo_width');
	register_setting( 'ml_options_group', 'wp_login_bg_color');
	register_setting( 'ml_options_group', 'wp_button_bg_color');
	register_setting( 'ml_options_group', 'wp_button_border_color');
	register_setting( 'ml_options_group', 'wp_button_text_color');
	register_setting( 'ml_options_group', 'wp_before_head');
	register_setting( 'ml_options_group', 'wp_before_body');
	
}
add_action( 'admin_init', 'ml_register_settings' );

function mm_global_styles()
{
 echo "<style>#adminmenu .wp-menu-image img {  max-width: 20px; max-height: 20px; padding: 7px !important; }</style>";
}
add_action('admin_enqueue_scripts', 'mm_global_styles', 100);

function ml_register_options_page() {
	
	add_menu_page( 'Myyntimaatio', 'Myyntimaatio',  'manage_options', 'myyntimaatio-launcher', 'ml_options_page', plugins_url( 'assets/img/LOGO_Myyntimaatio_circle.png', __FILE__ ) );
	
}
add_action('admin_menu', 'ml_register_options_page');

add_action ('wp_loaded', 'ml_options_callback');

// Flush rewrite rules
function flush_the_htaccess_file() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

function ml_options_callback() {
	$url = '/admin.php?page=myyntimaatio-launcher';
    if( isset($_GET['postman_import']) ) {
		if( $_GET['postman_import'] == 'true' ) {
			postman_import_settings();
			wp_redirect( admin_url( $url ) );
		}
	}
	if( isset($_GET['ithemes_security_import']) ) {
		if( $_GET['ithemes_security_import'] == 'true' ) {
			ithemes_security_import_settings();
			wp_redirect( admin_url( $url ) );
		}
	}
	if( isset($_GET['wordpress_import']) ) {
		if( $_GET['wordpress_import'] == 'true' ) {
		  	//Wordpress Settings
		  	$date_format = update_option( 'date_format', 'd/m/Y' ); // d/m/Y
		  	$time_format = update_option( 'time_format', 'H:i' ); // H:i
		  	$links_updated_date_format = update_option( 'links_updated_date_format', 'd/m/Y H:i' ); // d/m/Y H:i
		  	$permalink_structure = update_option( 'permalink_structure', '/%postname%/' ); // /%postname%/
		  	$WPLANG = update_option( 'WPLANG', 'fi' ); // fi
		  	$timezone_string = update_option( 'timezone_string', 'Europe/Helsinki' ); // Europe/Helsinki

			// Delete Extra themes
			$somePath = '../wp-content/themes';
			$directories = glob($somePath . '/*' , GLOB_ONLYDIR);
			$directories = array_diff($directories, ["../wp-content/themes/hello-elementor", "../wp-content/themes/Myyntimaatio"]);
			foreach ($directories as $dir) {
				delete_files($dir);
			}

			// Flush the rewrite rules
			add_action('admin_init', 'flush_the_htaccess_file');

			wp_redirect( admin_url( $url ) );
		}
	}
	if( isset($_GET['wp_fastest_cache_import']) ) {
		if( $_GET['wp_fastest_cache_import'] == 'true' ) {
			wp_fastest_cache_import_settings();
			wp_redirect( admin_url( $url ) );
		}
	}
	if( isset($_GET['acf_pro_license_import']) ) {
		if( $_GET['acf_pro_license_import'] == 'true' ) {
			wp_acf_pro_license_import_settings();
			wp_redirect( admin_url( $url ) );
		}
	}

}     

function ml_options_page()
{	
	wp_enqueue_script('jquery');
	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( 'assets/js/wp-color-picker-alpha.min.js', __FILE__ ), array( 'wp-color-picker' ) );
	wp_register_script( 'ml_backend_js', plugins_url( 'assets/js/backend.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ),  MM_L_VERSION );
	wp_enqueue_script( 'ml_backend_js' );

	wp_enqueue_style( 'ml_backend_css', plugins_url( 'assets/css/backend.css', __FILE__ ), array(), MM_L_VERSION );

?>
<div id="myyntimaatio_launcher">
  <?php screen_icon(); ?>
  <h2><?php _e("Myyntimaatio Launcher"); ?></h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'ml_options_group' ); ?>

  <!-- Start tabs -->
  <ul class="wp-tab-bar">
	<li class="wp-tab-active"><a href="#general">General</a></li>
	<li><a href="#login">Login Page</a></li>
	<li><a href="#header_footer">Header/Footer</a></li>
  </ul>
  <div class="wp-tab-panel" id="general">
	
	<fieldset>
	  <legend><?php _e("Configuration"); ?></legend>
	  
	  <table>
	  <?php
	  	//Wordpress Settings
	  	$date_format = get_option('date_format'); // d/m/Y
	  	$time_format = get_option('time_format'); // H:i
	  	$links_updated_date_format = get_option('links_updated_date_format'); // d/m/Y H:i
	  	$permalink_structure = get_option('permalink_structure'); // /%postname%/
	  	$WPLANG = get_option('WPLANG'); // fi
	  	$timezone_string = get_option('timezone_string'); // Europe/Helsinki

 		if ( $date_format == 'd/m/Y' AND  $time_format == 'H:i' AND $links_updated_date_format == 'd/m/Y H:i' AND $permalink_structure == '/%postname%/' AND $timezone_string == 'Europe/Helsinki' ) {

			$ml_wordpress_import = '<span style="color:green;">Configured</span>';

		} else {
 			$ml_wordpress_import = '<span style="color:red;">Not Configured</span>';
		}
 	  ?>
	  <tr valign="top">
	  	<th scope="row">Wordpress(FI) Settings (<?php _e($ml_wordpress_import); ?>)</th>
		  <td><a href="./admin.php?page=myyntimaatio-launcher&wordpress_import=true"><span class="dashicons dashicons-update-alt"></span></a></td>
	  </tr>

	  <?php
	  	//PostMan Settings
 		if ( is_plugin_active( 'post-smtp/postman-smtp.php' ) ) {
			require_once(plugin_dir_path( __DIR__ ) . 'post-smtp/Postman/Postman.php');
			if( PostmanOptions::getInstance()->getUsername() != 'contactforms@myyntimaatio.fi' ) $ml_postman_import = '<span style="color:red;">Not Configured</span>';
			else $ml_postman_import = '<span style="color:green;">Configured</span>';
 	  ?>
	  <tr valign="top">
	  	<th scope="row">Postman (<?php _e($ml_postman_import); ?>)</th>
		  <td><a href="./admin.php?page=myyntimaatio-launcher&postman_import=true"><span class="dashicons dashicons-update-alt"></span></a></td>
	  </tr>
	  <?php 
		}
 	  ?>

 	  <?php
	  	//Better WP Security (iThemes Security) Settings
 		if ( is_plugin_active( 'better-wp-security/better-wp-security.php' ) ) {
			require_once(plugin_dir_path( __DIR__ ) . 'better-wp-security/core/core.php');
			require_once(plugin_dir_path( __DIR__ ) . 'better-wp-security/core/lib/class-itsec-mail.php');

			if( parse_url(ITSEC_Mail::filter_admin_page_url( get_option( 'siteurl' ) ), PHP_URL_QUERY) != 'itsec-hb-token=kirjautuminen' ) $ml_ithemes_security_import = '<span style="color:red;">Not Configured</span>';
			else $ml_ithemes_security_import = '<span style="color:green;">Configured</span>';

 	  ?>
	  <tr valign="top">
	  	<th scope="row">iThemes Security (<?php _e($ml_ithemes_security_import); ?>)</th>
		  <td><a href="./admin.php?page=myyntimaatio-launcher&ithemes_security_import=true"><span class="dashicons dashicons-update-alt"></span></a></td>
	  </tr>
	  <?php 
		}
 	  ?>

 	  <?php
	  	//WP Fastest Cache Settings
 		if ( is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ) ) {
			$WpFastestCachePreLoad = get_option('WpFastestCachePreLoad');
			$WpFastestCache = get_option('WpFastestCache');

			if( $WpFastestCachePreLoad == '' AND $WpFastestCache == '' ) $ml_wp_fastest_cache_import = '<span style="color:red;">Not Configured</span>';
			else $ml_wp_fastest_cache_import = '<span style="color:green;">Configured</span>';

 	  ?>
	  <tr valign="top">
	  	<th scope="row">WP Fastest Cache (<?php _e($ml_wp_fastest_cache_import); ?>)</th>
		  <td><a href="./admin.php?page=myyntimaatio-launcher&wp_fastest_cache_import=true"><span class="dashicons dashicons-update-alt"></span></a></td>
	  </tr>
	  <?php 
		}
 	  ?>


 	  <?php
	  	//Advanced Custom Fields PRO Settings
 		if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			$acf_pro_license = get_option('acf_pro_license');

			if( $acf_pro_license == '' ) $ml_acf_pro_license_import = '<span style="color:red;">Not Configured</span>';
			else $ml_acf_pro_license_import = '<span style="color:green;">Configured</span>';

 	  ?>
	  <tr valign="top">
	  	<th scope="row">ACF License PRO (<?php _e($ml_acf_pro_license_import); ?>)</th>
		  <td><a href="./admin.php?page=myyntimaatio-launcher&acf_pro_license_import=true"><span class="dashicons dashicons-update-alt"></span></a></td>
	  </tr>
	  <?php 
		}
 	  ?>
	  </table>
    </fieldset>
  </div>
  <div class="wp-tab-panel" id="login" style="display: none;">
	
  	<fieldset>
	  <legend><?php _e("Login Page"); ?></legend>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Login Logo</th>
					<td>
						<input type="text" id="wp_logo_url" name="wp_logo_url" value="<?php echo esc_attr( get_option('wp_logo_url') ); ?>" />
						<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Logo">
						<p class="description"><i>It will appear in WP Administrator login page.</i></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Height</th>
					<td>
						<input type="text" name="wp_logo_height" value="<?php echo esc_attr( get_option('wp_logo_height') ); ?>" /> px					
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Width</th>
					<td>
						<input type="text" name="wp_logo_width" value="<?php echo esc_attr( get_option('wp_logo_width') ); ?>" /> px
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Background Color</th>
					<td>
						<input type="text" class="colorpicker" data-alpha="true" name="wp_login_bg_color" value="<?php echo esc_attr( get_option( 'wp_login_bg_color', "#f1f1f1" ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Button Background Color</th>
					<td>
						<input type="text" class="colorpicker" data-alpha="true" name="wp_button_bg_color" value="<?php echo esc_attr( get_option( 'wp_button_bg_color', "#0085ba" ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Button Border Color</th>
					<td>
						<input type="text" class="colorpicker" data-alpha="true" name="wp_button_border_color" value="<?php echo esc_attr( get_option( 'wp_button_border_color', "#006799" ) ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Button Text Color</th>
					<td>
						<input type="text" class="colorpicker" data-alpha="true" name="wp_button_text_color" value="<?php echo esc_attr( get_option( 'wp_button_text_color', "#ffffff" ) ); ?>" />
					</td>
				</tr>
			</table>
	</fieldset>
  </div>

  <div class="wp-tab-panel" id="header_footer" style="display: none;">
	
  	<fieldset>
	  <legend><?php _e("Header/Footer"); ?></legend>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Header (Before &lt;/head&gt; Tag) <br />
						<textarea id="code_editor_page_head" name="wp_before_head" class="widefat textarea" style="min-height: 300px;"><?php echo esc_textarea( get_option('wp_before_head') ); ?></textarea>
						<p class="description"><i>Can be used for JS/HTML code.</i></p>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">Footer (Before &lt;/body&gt; Tag) <br />
						<textarea id="code_editor_page_foot" name="wp_before_body" class="widefat textarea" style="min-height: 300px;"><?php echo esc_textarea( get_option('wp_before_body') ); ?></textarea>
						<p class="description"><i>Can be used for JS/HTML code.</i></p>
					</th>
				</tr>
			</table>
	</fieldset>
  </div>
<!-- End tabs -->

  <?php submit_button(); ?>
  </form>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#upload-btn').click(function(e) {
			e.preventDefault();
			var image = wp.media({ 
				title: 'Upload Logo',
				multiple: false
			}).open()
			.on('select', function(e){
				var uploaded_image = image.state().get('selection').first();
				console.log(uploaded_image);
				var image_url = uploaded_image.toJSON().url;
				$('#wp_logo_url').val(image_url);
			});
		});
	});
	</script>
</div>
<?php
}

/* Custom WordPress admin login header logo */
function wordpress_custom_login_logo() {
    $logo_url 				= get_option('wp_logo_url');
    $wp_logo_height 		= get_option('wp_logo_height');
    $wp_logo_width			= get_option('wp_logo_width');
    $wp_login_bg_color 		= get_option('wp_login_bg_color');
    $wp_button_bg_color 	= get_option('wp_button_bg_color');
    $wp_button_border_color = get_option('wp_button_border_color');
    $wp_button_text_color 	= get_option('wp_button_text_color');

	if(empty($wp_logo_height))
	{
		$wp_logo_height='100px';
	}
	else
	{
		$wp_logo_height.='px';
	}
	if(empty($wp_logo_width))
	{
		$wp_logo_width='100%';
	}	
	else
	{
		$wp_logo_width.='px';
	}
	if(!empty($logo_url))
	{
		echo '<style type="text/css">'.
             'h1 a { 
					background-image:url('.$logo_url.') !important;
					height:'.$wp_logo_height.' !important;
					width:'.$wp_logo_width.' !important;
					background-size:100% !important;
					line-height:inherit !important;
				}
			   body.login {
			   		background: '.$wp_login_bg_color.' !important;
			   }
			   #login .button-primary {
				    background: '.$wp_button_bg_color.' !important;
				    border-color: '.$wp_button_bg_color.' '.$wp_button_border_color.' '.$wp_button_border_color.' !important;
				    box-shadow: 0 1px 0 '.$wp_button_border_color.' !important;
				    color: '.$wp_button_text_color.' !important;
				    text-decoration: none !important;
				    text-shadow: 0 -1px 1px '.$wp_button_border_color.', 1px 0 1px '.$wp_button_border_color.', 0 1px 1px '.$wp_button_border_color.', -1px 0 1px '.$wp_button_border_color.' !important;
				}
				.login #backtoblog a, .login #nav a {
				    color: '.$wp_button_bg_color.' !important;
				}
				'.
         '</style>';
	}
}
add_action( 'login_head', 'wordpress_custom_login_logo' );

//Get Main Site URL for Login page logo
function my_custom_login_url($url) {
	return get_site_url();
}
add_filter( 'login_headerurl', 'my_custom_login_url' );

//Add text/html before </head>
function ml_wp_header() {
	echo get_option('wp_before_head');
}
add_action('wp_head', 'ml_wp_header');

//Add text/html before </body>
function ml_wp_footer() {
	echo get_option('wp_before_body');
}
add_action('wp_footer', 'ml_wp_footer');

/* 
 * php delete function that deals with directories recursively
 */
function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
            delete_files( $file );      
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}