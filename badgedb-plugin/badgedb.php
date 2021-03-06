<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/IVCTool/badge_database/tree/master/badgedb-plugin
 * @since             1.0.0
 * @package           Badgedb
 *
 * @wordpress-plugin
 * Plugin Name:       NATO Simulation Interoperability Capability Badge Database
 * Plugin URI:        https://github.com/IVCTool/badge_database/tree/master/badgedb-plugin
 * Description:       A plugin to provide simulation interoperability badge database capabilities to your site. 
 * Version:           1.0.0
 * Author:            NATO MSG-163 / NATO MSG-134
 * Author URI:        https://www.mscoe.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       badgedb
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BADGEDB_VERSION', '1.0.0' );
define( 'BADGEDB_PATH', plugin_dir_path(__FILE__));

/**
 * Current database version and table prefix name
 */
define('BADGEDB_DATABASE_VERSION', '1.0.0');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-badgedb-activator.php
 */
function activate_badgedb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-badgedb-activator.php';
	Badgedb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-badgedb-deactivator.php
 */
function deactivate_badgedb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-badgedb-deactivator.php';
	Badgedb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_badgedb' );
register_deactivation_hook( __FILE__, 'deactivate_badgedb' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-badgedb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_badgedb() {

	$plugin = new Badgedb();
	$plugin->run();

}
run_badgedb();
