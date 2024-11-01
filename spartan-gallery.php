<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              developerforwebsites@gmail.com
 * @since             1.0.0
 * @package           Spartan_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       Spartan Gallery
 * Plugin URI:        spartan-gallery.developerforwebsites.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Freelancer Martin
 * Author URI:        developerforwebsites@gmail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spartan-gallery
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.2.1' );


// Add the transient on plugin activation.
if ( ! function_exists( 'wpw_welcome_page' ) ) {
	// Hook that runs on plugin activation.
	register_activation_hook(  __FILE__, 'wpw_welcome_activate' );
	/**
	 * Add the transient.
	 *
	 * Add the welcome page transient.
	 *
	 * @since 1.0.0
	 */
	function wpw_welcome_activate() {
		// Transient max age is 60 seconds.
		set_transient( '_welcome_redirect_wpw', true, 60 );
	}
}
// Delete the Transient on plugin deactivation.
if ( ! function_exists( 'wpw_welcome_page' ) ) {
	// Hook that runs on plugin deactivation.
	register_deactivation_hook(  __FILE__ , 'wpw_welcome_deactivate' );
	/**
	 * Delete the Transient on plugin deactivation.
	 *
	 * Delete the welcome page transient.
	 *
	 * @since   2.0.0
	 */
	function wpw_welcome_deactivate() {
	  delete_transient( '_welcome_redirect_wpw' );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spartan-gallery-activator.php
 */
function activate_spartan_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spartan-gallery-activator.php';
	Spartan_Gallery_Activator::activate();
}


require_once plugin_dir_path( __FILE__ ) . 'admin/exopite-simple-options/exopite-simple-options-framework-class.php';

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spartan-gallery-deactivator.php
 */
function deactivate_spartan_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spartan-gallery-deactivator.php';
	Spartan_Gallery_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spartan_gallery' );
register_deactivation_hook( __FILE__, 'deactivate_spartan_gallery' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-spartan-gallery.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spartan_gallery() {

	$plugin = new Spartan_Gallery();
	$plugin->run();

}
run_spartan_gallery();
