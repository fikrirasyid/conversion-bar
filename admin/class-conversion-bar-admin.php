<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://fikrirasy.id/wordpress-plugin/conversion-bar/
 * @since      1.0.0
 *
 * @package    Conversion_Bar
 * @subpackage Conversion_Bar/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the conversion bar, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Conversion_Bar
 * @subpackage Conversion_Bar/admin
 * @author     Fikri Rasyid <fikrirasyid@gmail.com>
 */
class Conversion_Bar_Admin {

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
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conversion_Bar_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conversion_Bar_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/conversion-bar-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conversion_Bar_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conversion_Bar_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/conversion-bar-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registering custom post type that is used by Conversion bar
	 * 
	 * @since  	1.0.0
	 * @access  public
	 */
	public function register_post_type(){
		$labels = array(
			'name'               => _x( 'Conversion Bars', 'post type general name', 'conversion-bar' ),
			'singular_name'      => _x( 'Conversion Bar', 'post type singular name', 'conversion-bar' ),
			'menu_name'          => _x( 'Conversion Bars', 'admin menu', 'conversion-bar' ),
			'name_admin_bar'     => _x( 'Conversion Bar', 'add new on admin bar', 'conversion-bar' ),
			'add_new'            => _x( 'Add New', 'conversion bar', 'conversion-bar' ),
			'add_new_item'       => __( 'Add New Conversion Bar', 'conversion-bar' ),
			'new_item'           => __( 'New Conversion Bar', 'conversion-bar' ),
			'edit_item'          => __( 'Edit Conversion Bar', 'conversion-bar' ),
			'view_item'          => __( 'View Conversion Bar', 'conversion-bar' ),
			'all_items'          => __( 'All Conversion Bars', 'conversion-bar' ),
			'search_items'       => __( 'Search Conversion Bars', 'conversion-bar' ),
			'parent_item_colon'  => __( 'Parent Conversion Bars:', 'conversion-bar' ),
			'not_found'          => __( 'No conversion bars found.', 'conversion-bar' ),
			'not_found_in_trash' => __( 'No conversion bars found in Trash.', 'conversion-bar' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'			 => 'dashicons-megaphone',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'conversion-bar' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' ),
			'exclude_from_search'=> true
		);

		register_post_type( 'conversion_bar', $args );		
	}

	/**
	 * Add and manage metaboxes for conversion bar edit screen
	 * 
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_meta_boxes( $post ){
		global $wp_meta_boxes;

		// Before adding any meta boxes, remove any third party meta box first
		$page 		= get_current_screen();
		$page_id 	= $page->id;

		// Loop the metaboxes and unset everything except the core metabox
		if( isset( $wp_meta_boxes[$page_id] ) && is_array( $wp_meta_boxes[$page_id] ) ){
			foreach ($wp_meta_boxes[$page_id] as $meta_boxes_key => $meta_boxes ) {
				foreach ( $meta_boxes as $meta_box_key => $meta_box ) {

					// Unset all meta box except the core
					if( 'core' != $meta_box_key ){
						unset( $wp_meta_boxes[$page_id][$meta_boxes_key][$meta_box_key] );
					}
				}

			}		
		}

		// Registering conversion bar's meta box
	}

	/**
	 * Display conversion bar input below the title box
	 * 
	 * @access public
	 * 
	 * @since 1.0.0
	 */
	public function build_conversion_bar_input( $post ){
		/**
		 * Bail if this isn't admin screen
		 */
		if( !is_admin() ){
			return;
		}

		/**
		 * Bail if this isn't conversion bar screen
		 */
		if( !isset( $post->post_type ) || 'conversion_bar' != $post->post_type ){
			return;
		}

		/**
		 * Define post ID. This should be non-negative integer
		 */
		$post_id = ( int ) absint( $post->ID );

		/**
		 * Get current conversion-bar message
		 */
		$conversion_bar_message = get_post_meta( $post_id, '_conversion_bar_message', true );

		/**
		 * Create nonce field
		 */
		wp_nonce_field( "conversion_bar_{$post_id}", "_conversion_bar_nonce" );
		?>
		
		<div id="conversion-bar-div">
			<div id="conversion-bar-wrap">
				<label for="conversion-bar-text" id="conversion-bar-label"><?php _e( 'Conversion Bar Message:', 'conversion-bar' ); ?></label>
			<textarea type="text" name="conversion-bar-text" id="conversion-bar-text" placeholder="<?php _e( 'Type the message on your conversion bar (thing that will stick on the top of your browser) here', 'conversion bar' ); ?>"><?php echo esc_attr( htmlspecialchars( $conversion_bar_message ) ); ?></textarea>
			</div>

			<label for="content"><?php _e( 'Popup Message:' ); ?></label>
		</div>
		<?php
	}
}
