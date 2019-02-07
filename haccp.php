<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              localhost
 * @since             1.0.0
 * @package           Haccp
 *
 * @wordpress-plugin
 * Plugin Name:       HACCP
 * Plugin URI:        localhost
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jonas
 * Author URI:        localhost
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       haccp
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-haccp-activator.php
 */
function activate_haccp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-haccp-activator.php';
	Haccp_Activator::activate();
	
	
}
function haccp_uninstall(){
	//  codes to perform during unistallation
	global $wpdb;
	$table_name = 'haccp_allergen1';
	$sql = "DROP TABLE IF EXISTS $table_name";
	$wpdb->query($sql);
	delete_option("my_plugin_db_version");
   
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-haccp-deactivator.php
 */
function deactivate_haccp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-haccp-deactivator.php';
	Haccp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_haccp' );
register_deactivation_hook( __FILE__, 'deactivate_haccp' );
//register_uninstall_hook( __FILE__, 'haccp_uninstall' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-haccp.php';

//-------test for ajax start------
include ( plugin_dir_path( __FILE__ ) . 'admin/partials/equip-server.php' );

add_action('wp_ajax_my_action', 'my_ajax_action_function');
//--------end--------

//=====create shortcode=====
add_shortcode('allergen_search', 'allergen_search_func');

function allergen_search_func () {
	include ( plugin_dir_path( __FILE__ ) . 'public/partials/allergen_search.php' );
}
//=======end=======
//--------csv download-----------
include ( plugin_dir_path( __FILE__ ) . 'admin/partials/download.php' );
if ( isset($_POST['download_goodsin']) ) {
    goodsin_csv();
} else if ( $_POST['download_dailychecks'] ) {
	daily_checks_csv();
}
//--------end-------
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_haccp() {

	$plugin = new Haccp();
	$plugin->run();

}
run_haccp();
