<?php

/**
 * @link              https://professionalwebsolutions.com.au/development-services/
 * @since             1.0.0
 * @package           Perthwake_Park_App_Endpoint
 *
 * @wordpress-plugin
 * Plugin Name:       Perthwake Park App Endpoint
 * Plugin URI:        https://professionalwebsolutions.com.au/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            PWS Developer
 * Author URI:        https://professionalwebsolutions.com.au/development-services/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       perthwake-park-app-endpoint
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
define( 'PERTHWAKE_PARK_APP_ENDPOINT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-perthwake-park-app-endpoint-activator.php
 */
function activate_perthwake_park_app_endpoint() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-perthwake-park-app-endpoint-activator.php';
	Perthwake_Park_App_Endpoint_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-perthwake-park-app-endpoint-deactivator.php
 */
function deactivate_perthwake_park_app_endpoint() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-perthwake-park-app-endpoint-deactivator.php';
	Perthwake_Park_App_Endpoint_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_perthwake_park_app_endpoint' );
register_deactivation_hook( __FILE__, 'deactivate_perthwake_park_app_endpoint' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-perthwake-park-app-endpoint.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_perthwake_park_app_endpoint() {

	$plugin = new Perthwake_Park_App_Endpoint();
	$plugin->run();

}
run_perthwake_park_app_endpoint();
