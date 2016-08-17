<?php

// Self-Enclosed Shortcode to call the most recent posts
function recent_posts() {
   $posts_query = new WP_Query(array(
      'showposts' => 5, // Shows the 5 more recent posts
      'ignore_sticky_posts' => 1)); // Ignores the sticky post
   if ($posts_query->have_posts()) : while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
      <ul> <?php
      $recent_posts = wp_get_recent_posts(); // References this from Codex, wp_get_recent_posts gets the recent posts
         echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>'; // Displays the recent posts in a list
      ?>
      </ul>
   <?php
   endwhile;
   endif;
   wp_reset_query(); // Ends the query
}
add_shortcode( 'recent_posts', 'recent_posts' ); // Names for the shortcode