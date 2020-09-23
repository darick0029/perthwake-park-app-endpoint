<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://professionalwebsolutions.com.au/development-services/
 * @since      1.0.0
 *
 * @package    Perthwake_Park_App_Endpoint
 * @subpackage Perthwake_Park_App_Endpoint/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Perthwake_Park_App_Endpoint
 * @subpackage Perthwake_Park_App_Endpoint/public
 * @author     PWS Developer <darick@professionalwebsolutions.com.au>
 */
class Perthwake_Park_App_Endpoint_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->pwp_app_routes_registration();

	}
    
    public function pwp_app_routes_registration() {
        
        // All users route
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/endpoints/perthwake-park-app-endpoint-get-all-users-class.php';
        
        // User by ID route
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/endpoints/perthwake-park-app-endpoint-get-user-by-id-class.php';
        
        // Update user by ID route
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/endpoints/perthwake-park-app-endpoint-update-user-by-id-class.php';
        
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
		 * defined in Perthwake_Park_App_Endpoint_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Perthwake_Park_App_Endpoint_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/perthwake-park-app-endpoint-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Perthwake_Park_App_Endpoint_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Perthwake_Park_App_Endpoint_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/perthwake-park-app-endpoint-public.js', array( 'jquery' ), $this->version, false );

	}

}
