<?php

class Pcp_Public {

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

		add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_styles' ), 10, 1 );
		add_action( 'wp_enqueue_scripts',  array( $this, 'enqueue_scripts' ), 10, 1 );
		add_action('wp_ajax_apply_filters', array( $this, 'filter_product_callback' ) );
		add_action('wp_ajax_nopriv_apply_filters', array( $this, 'filter_product_callback' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pcp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pcp-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'pcp_ajax_object', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('pcp_nonce')
	));
	}

	/**
	 * This filter will filter the product according to the selected option at product page.
	 */
	public function filter_product_callback(){
		global $post;
		$security_nonce = check_ajax_referer('pcp_nonce', 'security');

			$size_filterValues = isset($_POST['size_filterValues']) && !empty($_POST['size_filterValues']) ? explode( ",", $_POST['size_filterValues']) : array();
		
			$color_filterValues = isset($_POST['color_filterValues']) && !empty($_POST['color_filterValues']) ?  explode( ",", $_POST['color_filterValues']) : array();

			if( $security_nonce ){
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => -1,
					'orderby'        => 'date',
					'order'          => 'DESC'
				);

			if( !empty( $color_filterValues ) || !empty( $size_filterValues  ) )
			{
				$args['tax_query'] = array(
					'relation' => 'OR',
						array(
								'taxonomy' => 'color',
								'field'    => 'slug',
								'terms'    => $color_filterValues,
								'operator' => 'IN'
						),
						array(
							'taxonomy' => 'size',
							'field'    => 'slug',
							'terms'    => $size_filterValues,
							'operator' => 'IN'
						)
				);
			}

			$query = get_posts( $args );
			
			$html = ""; 
			if ( !empty( $query ) ) {
				foreach( $query as $post ){
					setup_postdata($post);
					$html .= '<div class="flex-item">';
					$html .= "<div class='image-container'>";
					$featured_image_url = get_the_post_thumbnail_url(get_the_id(), 'full');
					if (!empty( $featured_image_url )) {
							$attachment_id = attachment_url_to_postid( $featured_image_url );
							if ( $attachment_id ) {
								$html .= wp_get_attachment_image( $attachment_id, 'full' );
							} 
					}
					$html .= "</div>";
					$html .= '<h2>'.get_the_title().'</h2>';
					$html .= '<div>'.get_the_excerpt().'</div>';
					$html .= '</div>';
				}
				wp_reset_postdata();
				$return = array(
					'status'  => true,
					'html' => $html
				);
				echo json_encode($return);
			}
			else{
				$return = array(
					'status'  => false,
					'html' => '<div class="flex-item">No Product Found</div>'
				);
				echo json_encode($return);
			}
		}else{
			$return = array(
				'status'  => false,
				'html' => 'Something Went Wrong'
			);
			echo json_encode($return);
		}
		wp_die();

	}
}
