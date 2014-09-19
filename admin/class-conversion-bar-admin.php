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
	 * Conversion bar can appear only appear on these selected post types
	 */
	private $post_type_support;

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
		$this->post_type_support = apply_filters( 'conversion_bar_post_type_support', array( 'post', 'page' ) );
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
	 * Display conversion bar input below the title box
	 * 
	 * @access public
	 * 
	 * @since 1.0.0
	 */
	public function the_message_input( $post ){
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

	/**
	 * Save conversion bar meta data
	 * 
	 * @access public
	 * 
	 * @since 1.0.0
	 */
	public function save_message( $post_id, $post, $update ){

		/**
		 * Bail if this isn't conversion_bar post type
		 */
		if( !isset( $post->post_type ) || 'conversion_bar' != $post->post_type ) {
			return;
		}

		/**
		 * Check current save status of post
		 */
		$is_post_autosave = (bool) wp_is_post_autosave( $post_id ); // Autosave, found in wp-includes/revisison.php
		$is_post_revision = (bool) wp_is_post_revision( $post_id ); // Revision, found in wp-includes/revision.php

		/**
		 * Check current subtitle nonce status of post
		 */
		$is_nonce_set = (bool) isset( $_POST[ '_conversion_bar_nonce' ] );
		/**
		 * If the nonce is set then check if it's verified.
		 * This gets rid of undefined index notices for _subtitle_data_nonce.
		 */
		if ( $is_nonce_set ) {
			$nonce = sanitize_key( $_POST[ '_conversion_bar_nonce' ] );
			$is_verified_nonce = (bool) wp_verify_nonce( $nonce, "conversion_bar_{$post_id}" );
		}
		else {
			$is_verified_nonce = null;
		}

		/**
		 * Bail if the save status or nonce status of the post isn't correct
		 */
		if ( $is_post_autosave || $is_post_revision || ! $is_verified_nonce || ! $is_nonce_set ) {
			return;
		}

		/**
		 * Bail if the current user doesn't have permission to edit the current post type
		 */
		$post_type_object = (object) get_post_type_object( $post->post_type );
		$can_edit_post_type = (bool) current_user_can( $post_type_object->cap->edit_post, $post_id );

		if ( ! $can_edit_post_type ) {
			return;
		}

		/**
		 * Validate and sanitize data
		 */
		$conversion_bar_allowed_tags = array(
			'i' 		=> array(), // italicized text
			'em' 		=> array(), // emphasized text
			'strong' 	=> array(), // strong text
			'a'			=> array() // link text
		);
		$conversion_bar_message = wp_kses( $_POST['conversion-bar-text'], $conversion_bar_allowed_tags );

		/**
		 * Save the conversion bar to post meta
		 */
		update_post_meta( $post_id, '_conversion_bar_message', $conversion_bar_message );
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
		add_meta_box( 'conversion-bar-setup', __( 'Setup', 'conversion-bar'), array( $this, 'the_setup_metabox'), 'conversion_bar', 'advanced', 'default', $post );
	}

	/**
	 * Display conversion bar setup metabox UI
	 * 
	 * @since 1.0.0
	 * 
	 * @access public
	 */
	public function the_setup_metabox( $post ){
		/**
		 * Define conversion bar ID
		 */
		$conversion_bar_id = ( int ) absint( $post->ID );

		/**
		 * Get current data
		 */
		$conversion_bar_assigned_to = get_post_meta( $conversion_bar_id, '_conversion_bar_assigned_to', true );

		?>
		<p><label for=""><?php _e( 'This conversion bar will be displayed on:' ); ?></label></p>
		<div class="content-selector post-type-post">
			<?php $this->get_recent_content( 1, $conversion_bar_assigned_to, $conversion_bar_id, false ); ?>	
		</div>
		<?php
	}

	/**
	 * Get recent post for conversion bar admin UI
	 * 
	 * @access private
	 * 
	 * @since 1.0.0
	 */
	private function get_recent_content( $paged = 1, $selected = array(), $conversion_bar_id = false, $list_only = false ){
		/**
		 * Get recent posts
		 */
		$recent_posts_args = array(
			'paged'				=> ( int ) absint( $paged ),
			'posts_per_page' 	=> 10,
			'post_status'		=> 'publish',
			'post_type'			=> $this->post_type_support
		);

		/**
		 * Exclude post which has been selected
		 */
		if( $selected && is_array( $selected ) && !empty( $selected ) ){
			$recent_posts_args['post__not_in'] = $selected;
		}

		/**
		 * Get recent posts object
		 */
		$recent_posts = new WP_Query( $recent_posts_args );

		/**
		 * Display ul based on param given
		 */
		if( !$list_only ){
			echo '<ul id="conversion-bar-targets">';
		}

		/**
		 * Loop recent posts
		 */
		if( $recent_posts->have_posts() ){

			/**
			 * Prepend selected posts on top of recent posts list
			 */
			if( $selected && is_array( $selected ) ){
				$this->get_selected_posts( $selected );
			}

			while ( $recent_posts->have_posts() ) {
				$recent_posts->the_post();

				?>
				<li>
					<label for="conversion-bar-target-<?php the_ID(); ?>">
						<input type="checkbox" name="conversion-bar-target[]" id="conversion-bar-target-<?php the_ID(); ?>" value="<?php the_ID(); ?>">
						<span class="post-type"><?php echo get_post_type(); ?></span> - <?php the_title(); ?>
					</label>							
				</li>
				<?php
			}

		} else {
			echo '<li>' . __( "No Post Found", "conversion-bar" ) . '</li>';
		}

		/**
		 * Display ul closing tag based on param given
		 */
		if( !$list_only ){
			echo '</ul>';

			if( $conversion_bar_id ){
				$load_more_url 		= admin_url() . 'admin-ajax.php?action=conversion_bar_recent_posts';
				$load_more_nonce 	= wp_create_nonce( "get_recent_posts_{$conversion_bar_id}" );
				$loading_img_src 	= includes_url( 'images/wpspin.gif' );

				echo '<img src="'. $loading_img_src .'" id="conversion-bar-loading-image" title="'. __( "Loading...", "conversion-bar" ) .'" />';
				echo '<a href="'. $load_more_url .'" class="button more" id="conversion-bar-load-more-content" data-paged="2" data-conversion-bar-id="'. $conversion_bar_id .'" data-nonce="'. $load_more_nonce .'">'. __( "Load More Content", "conversion-bar" ) .'</a>';
			}
		}

		/**
		 * Reset loop
		 */
		wp_reset_postdata();
	}

	/**
	 * Display post which uses current conversion bar as list - checkbox
	 * 
	 * @access private
	 * 
	 * @since 1.0.0
	 */
	private function get_selected_posts( $selected = array() ){
		if( is_array( $selected ) && !empty( $selected ) ){

			$selected_posts_args = array(
				'post__in' 				=> $selected,
				'posts_per_page' 		=> -1,
				'ignore_sticky_posts' 	=> true,
				'post_type'				=> $this->post_type_support
			);

			/**
			 * Get selected posts object
			 */
			$selected_posts = new WP_Query( $selected_posts_args );

			/**
			 * Loop selected posts
			 */
			if( $selected_posts->have_posts() ){

				while ( $selected_posts->have_posts() ) {
					$selected_posts->the_post();

					?>
					<li>
						<label for="conversion-bar-target-<?php the_ID(); ?>">
							<input type="checkbox" name="conversion-bar-target[]" id="conversion-bar-target-<?php the_ID(); ?>" value="<?php the_ID(); ?>" checked="checked">
							<strong><?php the_title(); ?></strong>
						</label>							
					</li>
					<?php

				}
			}		

			/**
			 * Reset loop
			 */
			wp_reset_postdata();				
		}
	}

	/**
	 * Get recent content endpoint for load more button
	 * 
	 * @access public
	 * 
	 * @since 1.0.0
	 */
	public function get_recent_content_ajax(){
		/**
		 * Only process the ajax call if the request has requeired parameter
		 */
		if( isset( $_REQUEST['paged'] ) && isset( $_REQUEST['conversion_bar_id'] ) && isset( $_REQUEST['_wpnonce']) ){
			$paged 				= ( int ) absint( $_REQUEST['paged'] );
			$conversion_bar_id 	= ( int ) absint( $_REQUEST['conversion_bar_id'] );
			$selected 			= get_post_meta( $conversion_bar_id, '_conversion_bar_assigned_to', true );
			$nonce 				= $_REQUEST['_wpnonce'];

			/**
			 * Only process ajax call if this is real deal
			 */
			if( $paged > 1 && $conversion_bar_id > 1 && wp_verify_nonce( $nonce, "get_recent_posts_{$conversion_bar_id}" ) ){
				$this->get_recent_content( $paged, $selected, $conversion_bar_id, true );
			}
		}

		die();
	}
}
