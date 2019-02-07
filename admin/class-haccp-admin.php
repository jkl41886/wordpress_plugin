<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       localhost
 * @since      1.0.0
 *
 * @package    Haccp
 * @subpackage Haccp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Haccp
 * @subpackage Haccp/admin
 * @author     Jonas <jonascal95@gmail.com>
 */
class Haccp_Admin {

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
		 * defined in Haccp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Haccp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/haccp-admin.css', array(), $this->version, 'all' );

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
		 * defined in Haccp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Haccp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/haccp-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function display_admin_page () {
		add_menu_page('HACCP', //page title
			'HACCP', //menu title
			'manage_options', //capabilities
			'haccp', //menu slug
			array($this, 'dailyChecks') //function
		);
		
		//this is a submenu
		add_submenu_page('haccp', //parent slug
			'Daily checks', //page title
			'Daily checks', //menu title
			'manage_options', //capability
			'haccp', //menu slug
			array($this, 'dailyChecks')); //function
		add_submenu_page('haccp', //parent slug
			'Goods in', //page title
			'Goods in', //menu title
			'manage_options', //capability
			'haccp_goods_in', //menu slug
			array($this, 'goodsIn')); //function
		add_submenu_page('haccp', //parent slug
			'Allergens', //page title
			'Allergens', //menu title
			'manage_options', //capability
			'haccp_allergens', //menu slug
			array($this, 'allergens')); //function
		add_options_page( 'HACCP', 'HACCP', 'manage_options', 'haccp_data', array($this, 'haccpData'));
		
	}
	public function haccpData () {
		// include plugins_url('haccp/admin/partial/haccp-data-entry.php');
		include('partials/haccp-data-entry.php');
		
	}
	public function dailyChecks () {
		include('partials/haccp-daily-checks.php');
	}
	public function goodsIn () {
		include('partials/haccp-goods-in.php');
	}
	public function allergens () {
		include('partials/haccp-allergens.php');
	}

}
