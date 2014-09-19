<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://fikrirasy.id/wordpress-plugin/conversion-bar/
 * @since             1.0.0
 * @package           Conversion_Bar
 *
 * @wordpress-plugin
 * Plugin Name:       Conversion Bar
 * Plugin URI:        http://fikrirasy.id/wordpress-plugin/conversion-bar/
 * Description:       Displaying "hello bar" on specific post which will display a popup content (usually with form)
 * Version:           1.0.0
 * Author:            Fikri Rasyid
 * Author URI:        http://fikrirasy.id/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       conversion-bar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-conversion-bar-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-conversion-bar-deactivator.php';

/** This action is documented in includes/class-conversion-bar-activator.php */
register_activation_hook( __FILE__, array( 'Conversion_Bar_Activator', 'activate' ) );

/** This action is documented in includes/class-conversion-bar-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Conversion_Bar_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-conversion-bar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_conversion_bar() {

	$plugin = new Conversion_Bar();
	$plugin->run();

}
run_conversion_bar();
