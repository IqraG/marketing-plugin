<?php 

/*
 * Plugin Name: Marketing
 * PLugin URI: phoenix.sheridanc.on.ca/~ccit3685
 * Author: Iqra Ghazi
 * Author URI: phoenix.sheridanc.on.ca/~ccit3685
 * Description: Plugin Assignment for CCT460
 * Version: 1.0.0
 */

// Enqueues Style Sheet
function mrkting_plugin_styles(){
	wp_enqueue_style('mrkting-plugin-style', plugins_url('/css/style.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'mrkting_plugin_styles' );

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

// Creates Marketing Widget
class MarketingWidget extends WP_Widget{
	
	// Registers the Widget
	public function __construct(){
		$widget_ops = array(
			'classname' => 'marketing_cposts', // ID
			'description' => 'Displays Custom Marketing Posts'// Descrption
		);
		// Adds Widget Class and Description
		parent::__construct('customposts','Marketing Posts', $widget_ops);
	}

	// Determines what appears on the site
	public function widget($args, $instance){
		// If there is a title, display title, otherwise display Default Title
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Marketing Posts' : $instance['title'], $instance, $this->id_base); //apply_filter sanitizes code so no bad code gets inputted
		echo $args['before_widget'];
		
		if($title){
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>

			<ul class="mrkting-widget">
			<?php
			// Custom Query Arguments Setup
			$cpost_query = new WP_Query(array( 
				'post_type'		 => 'marketing', 
				'posts_per_page' => 4
			 	) );
			// Displays the custom posts from Marketing. Shows Title and Featured posts
			if ($cpost_query->have_posts()): while ($cpost_query->have_posts()): $cpost_query->the_post(); ?>		
				<li class="sidebar-cposts">
					<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        					<?php the_post_thumbnail(); ?>
    				</a>
				</li>				
				<?php 
					endwhile;
					wp_reset_postdata(); // Resets Post Data
					endif; 
					wp_reset_query(); // Ends Query
				?>
			</ul>

			<?php
			echo $args['after_widget']; // What comes up when Widget is registered
	}

	// Determines what appears on the dashboard. Allows users to control what appears on the website
	public function form($instance){
		$instance = wp_parse_args((array) $instance, array('title'=>''));
		$title = strip_tags($instance['title']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<?php 
	}

	// Save, Submit, Sanitize 
	public function update($new_instance,$old_instance){
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}			
}
add_action('widgets_init', function(){ register_widget('MarketingWidget'); });






