<?php

/**
 * The plugin bootstrap file
 * @wordpress-plugin
 * Plugin Name:       Product Custom Post & Filter
 * Plugin URI:        https://https://github.com/AbhishekTewari/product_cpt_filter
 * Description:       This plugin creates a custom post type for products, establishes a taxonomy, and applies a filter on the frontend
 * Version:           1.0.0
 * Author:            Abhishek Tiwari
 * Author URI:        https://https://github.com/AbhishekTewari/product_cpt_filter/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pcp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PCP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pcp-activator.php
 */
function activate_pcp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pcp-activator.php';
	Pcp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pcp-deactivator.php
 */
function deactivate_pcp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pcp-deactivator.php';
	Pcp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pcp' );
register_deactivation_hook( __FILE__, 'deactivate_pcp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pcp.php';
$include_pcp = new Pcp;

