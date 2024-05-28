<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class Pcp {

	/**
	 * The unique identifier of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 */
	protected $version;


	public function __construct() {
		if ( defined( 'PCP_VERSION' ) ) {
			$this->version = PCP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'pcp';

		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {

		/**
		 * The class responsible for defining all actions that occur in the admin-facing.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pcp-admin.php';
		$plugin_admin = new Pcp_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_admin->define_admin_hooks();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_hooks() {
		
		/**
		 * The class responsible for defining all actions that occur in the public-facing.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pcp-public.php';
		$plugin_public = new Pcp_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_public->define_admin_hooks();

		
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
