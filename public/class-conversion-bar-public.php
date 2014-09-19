<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://fikrirasy.id/wordpress-plugin/conversion-bar/
 * @since      1.0.0
 *
 * @package    Conversion_Bar
 * @subpackage Conversion_Bar/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the conversion bar, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Conversion_Bar
 * @subpackage Conversion_Bar/admin
 * @author     Fikri Rasyid <fikrirasyid@gmail.com>
 */
class Conversion_Bar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conversion_Bar_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conversion_Bar_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/conversion-bar-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conversion_Bar_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conversion_Bar_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/conversion-bar-public.js', array( 'jquery' ), $this->version, false );

	}

}
