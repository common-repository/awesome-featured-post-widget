<?php
/**
 * Plugin Name:  Awesome Featured Post Widget
 * Description:  Easily to display Awesome Featured Post Widget via shortcode or widget.
 * Author: Accrete InfoSolution Technologies LLP
 * Version:      1.2
 * Author URI:   http://www.accreteinfo.com/
 **/

// It will exit if we try to accessed it directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'MFPW_Widget' ) ) :

	class MFPW_Widget {

		//constuctor method
		public function __construct() {

			// action hook allow to set the constants needed by the plugin
			add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

			// action hook allow to load the functions files
			add_action( 'plugins_loaded', array( &$this, 'includes' ), 2 );

			// action hook to register the widget
			add_action( 'widgets_init', array( &$this, 'register_widget' ) );

			// action hook to register new image size
			add_action( 'init', array( &$this, 'register_image_size' ) );

			// action hook to enqueue the front-end style
			add_action( 'wp_enqueue_styles', array( &$this, 'plugin_style' ) );
			
			// action hook to enqueue the front-end style scripts
			add_action( 'wp_enqueue_scripts', array( &$this, 'plugin_scripts' ) );
			
			// action hook allow to load the admin style
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );
			add_action( 'customize_controls_enqueue_scripts', array( &$this, 'admin_scripts' ) );

		}

		//It defines constants used by the featured post plugin
		public function constants() {

			// It sets constant path to the plugin directory
			define( 'MFPW_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			// It sets the constant path to the plugin directory URI
			define( 'MFPW_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			// It sets the constant path to the includes directory
			define( 'MFPW_INC', MFPW_DIR . trailingslashit( 'includes' ) );

			// It sets the constant path to the assets directory
			define( 'MFPW_ASSETS', MFPW_URI . trailingslashit( 'assets' ) );
			
			//echo MFPW_INC;

		}

		//It loads the initial files needed by the featured post plugin
		public function includes() {
			require_once( MFPW_INC . 'functions.php' );
			require_once( MFPW_INC . 'resizer.php' );
			require_once( MFPW_INC . 'posts.php' );
			require_once( MFPW_INC . 'shortcode.php' );
			require_once( MFPW_INC . 'widget.php' );
		}

		//Enqueue admin script and stylesheet used by featured post plugin
		function admin_scripts() {
			wp_enqueue_style( 'mfpw-admin-style', trailingslashit( MFPW_ASSETS ) . 'css/admin.css' );
			wp_enqueue_script( 'mfpw-admin-script', trailingslashit( MFPW_ASSETS ) . 'js/jquery-cookie.js', array( 'jquery-ui-tabs' ) );			
		}

		//It will register the widget -> most important
		function register_widget() {
			register_widget( 'Awesome_Featured_Post_Widget' );
		}

		//It will register new image size
		function register_image_size() {
			add_image_size( 'mfpw-thumbnail', 50, 50, true );
			add_image_size('owl_widget', 180, 100, true);
			add_image_size('owl_function', 600, 280, true);
		}

		//Enqueue stylesheets used by featured post plugin
		function plugin_style() {
			wp_enqueue_style( 'mfpw-style', trailingslashit( MFPW_ASSETS ) . 'css/frontend.css' );		
		}	
		
		//Enqueue scripts used by featured post plugin
		function plugin_scripts(){
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'mfpw-script-carousel', trailingslashit( MFPW_ASSETS ) . 'js/carousel.js');								
		}			

	}

endif;

new MFPW_Widget;
?>