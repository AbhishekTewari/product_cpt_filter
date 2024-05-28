<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/AbhishekTewari/product_cpt_filter
 * @since      1.0.0
 *
 * @package    Pcp
 * @subpackage Pcp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pcp
 * @subpackage Pcp/admin
 * @author     Abhishek Tiwari <tiwariabhishek687@gmail.com>
 */
class Pcp_Admin {

	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Defining all admin facing hooks.
	 */
	public function define_admin_hooks(){

		add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_styles' ), 10, 1 );
		add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_scripts' ), 10, 1 );
		add_action( 'init',  array( $this, 'register_custom_post_type_and_taxonomy' ) );
		add_shortcode('product_post_shortcode', array( $this, 'my_custom_shortcode' ));

	}

	/**
	 * Custom Shortcode to display Product post.
	 */
	function my_custom_shortcode() {
			$shortcode_html = require_once plugin_dir_path( __FILE__ ) . 'partials/pcp-product-shotcode.php';
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pcp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pcp-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Cretae custom post type of Product
	 */
	public function create_product_post_type() {
    $labels = array(
        'name'                  => _x( 'Products', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Product', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Products', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Product', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Product', 'textdomain' ),
        'new_item'              => __( 'New Product', 'textdomain' ),
        'edit_item'             => __( 'Edit Product', 'textdomain' ),
        'view_item'             => __( 'View Product', 'textdomain' ),
        'all_items'             => __( 'All Products', 'textdomain' ),
        'search_items'          => __( 'Search Products', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Products:', 'textdomain' ),
        'not_found'             => __( 'No products found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No products found in Trash.', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'product' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions' ),
    );

    register_post_type( 'product', $args );
}

	/**
	 * Cretae custom taxonomy
	 */
	public function create_product_taxonomy() {
			// Size Taxonomy
			$labels = array(
				'name'              => _x( 'Sizes', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Size', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Search Sizes', 'textdomain' ),
				'all_items'         => __( 'All Sizes', 'textdomain' ),
				'parent_item'       => __( 'Parent Size', 'textdomain' ),
				'parent_item_colon' => __( 'Parent Size:', 'textdomain' ),
				'edit_item'         => __( 'Edit Size', 'textdomain' ),
				'update_item'       => __( 'Update Size', 'textdomain' ),
				'add_new_item'      => __( 'Add New Size', 'textdomain' ),
				'new_item_name'     => __( 'New Size Name', 'textdomain' ),
				'menu_name'         => __( 'Sizes', 'textdomain' ),
		);

		$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'size' ),
		);

		register_taxonomy( 'size', array( 'product' ), $args );

		// Color Taxonomy
		$labels = array(
				'name'              => _x( 'Colors', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Color', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Search Colors', 'textdomain' ),
				'all_items'         => __( 'All Colors', 'textdomain' ),
				'parent_item'       => __( 'Parent Color', 'textdomain' ),
				'parent_item_colon' => __( 'Parent Color:', 'textdomain' ),
				'edit_item'         => __( 'Edit Color', 'textdomain' ),
				'update_item'       => __( 'Update Color', 'textdomain' ),
				'add_new_item'      => __( 'Add New Color', 'textdomain' ),
				'new_item_name'     => __( 'New Color Name', 'textdomain' ),
				'menu_name'         => __( 'Colors', 'textdomain' ),
		);

		$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'color' ),
		);

		register_taxonomy( 'color', array( 'product' ), $args );
	}

	/**
	 *callback function to creare custom Post type and taxonomy names as Size & Color.
	 */
	public function register_custom_post_type_and_taxonomy() {
			$this->create_product_post_type();
			$this->create_product_taxonomy();
	}



}
