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

// Creates Custom Post Type
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'marketing',
    array(
      'labels' 			=> array(
        'name' 			=> __( 'Marketing' ),
        'singular_name' => __( 'Marketing' )
      ),
      'public' 		=> true,
      'has_archive' => true,
      'supports' 	=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    )
  );
}