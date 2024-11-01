<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       developerforwebsites@gmail.com
 * @since      1.0.0
 *
 * @package    Spartan_Gallery
 * @subpackage Spartan_Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Spartan_Gallery
 * @subpackage Spartan_Gallery/admin
 * @author     Freelancer Martin <developerforwebsites@gmail.com>
 */

 if ( ! defined( 'WPINC' ) ) {

     die;

 }


class Spartan_Gallery_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Spartan_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spartan_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/spartan-gallery-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . 'popup-style', plugin_dir_url( __FILE__ ) . 'css/popup.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Spartan_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spartan_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/spartan-gallery-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name . 'popup.js', plugin_dir_url( __FILE__ ) . 'js/popup.js', array( 'jquery' ), $this->version, false );

    wp_enqueue_script( $this->plugin_name . 'chosen.jquery.min.js', plugin_dir_url( __FILE__ ) . 'exopite-simple-options/assets/chosen.jquery.min.js', array( 'jquery' ), $this->version, false );




	}

}
