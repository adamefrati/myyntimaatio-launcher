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
 * @since             1.0.0
 * @package           Myyntimaatio Launcher
 *
 * @wordpress-plugin
 * Plugin Name:       Myyntimaatio Launcher
 * Plugin URI:        https://myyntimaatio.fi
 * Description:       Myyntimaatio Launcher plugin to install all required plugins and run all neccessary snippets according to company standard.
 * Version:           1.0.0
 * Author:            Shayan Abbas
 * Author URI:        https://linkedin.com/in/shayanabbas
 * License:           GPL-2.0+
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

		// Post SMTP Mailer/Email Log
		array(
			'name'      => 'Post SMTP Mailer/Email Log',
			'slug'      => 'post-smtp',
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
