<?php 

/*
 * Plugin Name: Marketing
 * PLugin URI: phoenix.sheridanc.on.ca/~ccit3685
 * Author: Iqra Ghazi
 * Author URI: phoenix.sheridanc.on.ca/~ccit3685
 * Description: Plugin Assignment for CCT460
 * Version: 1.0.0
 */

// Enqueued Style Sheet
function my_plugin_styles(){
	wp_enqueue_style('plugin-style', plugins_url('/css/style.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'my_plugin_styles' );