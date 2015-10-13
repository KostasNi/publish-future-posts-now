<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.kostasni.com/
 * @since      0.1.0
 *
 * @package    Publish_Future_Posts_Now
 * @subpackage Publish_Future_Posts_Now/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Publish_Future_Posts_Now
 * @subpackage Publish_Future_Posts_Now/public
 * @author     Kostas Nicolacopoulos <kostas@kostasni.com>
 */
class Publish_Future_Posts_Now_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Publish_Future_Posts_Now_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Publish_Future_Posts_Now_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/publish-future-posts-now-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Publish_Future_Posts_Now_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Publish_Future_Posts_Now_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/publish-future-posts-now-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * This function is called when a post is saved.
	 * It checks if the post has future post date (scheduled).
	 * If it does it changes the post status from "future" to "publish".
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_id The ID of the post being saved.
	 */
	function kn_publish_future_post( $post_id ) {
		if ( ! wp_is_post_revision( $post_id ) ) {
			/*
			 * Unhook this function so it doesn't loop infinitely.
			 * See: https://codex.wordpress.org/Function_Reference/wp_update_post#Caution_-_Infinite_loop
		     */
			remove_action( 'save_post', 'kn_publish_future_post' );

			$post_status = get_post_status( $post_id );
			if ( 'future' === $post_status ) {
				$post_date = date( 'Y-m-d H:i:s' );
				$post_new_args = array(
					'ID' => $post_id,
					'post_date_gmt' => $post_date,
					'post_status' => 'publish',

				);
				wp_update_post( $post_new_args );
			}

			// Re-hook this function.
			add_action( 'save_post', 'kn_publish_future_post' );
		}
	}

}
