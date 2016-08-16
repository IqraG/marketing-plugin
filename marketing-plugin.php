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
function mrkting_plugin_style(){
	wp_enqueue_style('plugin-style', plugins_url('/labfour/style.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'mrkting_plugin_style' );

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

	// Determins what appears on the site
	public function widget($args, $instance){
		$c = !empty($instance['count']) ? '1' : '0'; // Count Enabled
		$d = !empty($instance['dropdown']) ? '1' : '0'; // Dropdown Enabled
		// If there is a title, display title, otherwise display Default Title
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Marketing Posts' : $instance['title'], $instance, $this->id_base); //apply_filter sanitizes code so no bad code gets inputted
		echo $args['before_widget'];
		
		if($title){
			// If  dropdown is checked, gets archives and displays them by year 
			echo $args['before_title'] . $title . $args['after_title'];
		}
		// The following code creates a drop-down *just copy this
		if($d){
			$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
			?>
			<label class="screen-reader-text" for="<?php echo esc_attr($dropdown_id); ?>"><?php echo $title; ?></label>
			<select id="<?php echo esc_attr($dropdown_id); ?>" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
				<?php
					$dropdown_args = apply_filters('mrkting_dropdown_args', array(
						'type' => 'yearly',
						'format' => 'option',
						'show_post_count' => $c // If post count checked, show the post count
					)); 
				?>
				<option value="Select Year">Select Year</option>
				<?php wp_get_archives($dropdown_args); ?>
			</select>
			
			<?php } 
			else { ?>

			<ul>
				<?php wp_get_archives(apply_filters('widget_archives_args', array(
						'type' => 'yearly',
						'show_post_count' => $c
					))); // gets a list of the archives and displays them by year. If the Count option is checked, this gets shown.
					?>
			</ul>

			<?php  }
				echo $args['after_widget']; // what's set up when you registered the sidebar
				}
				// Sets up the form for users to set their options/add content in the widget admin page
				public function form($instance){
					$instance = wp_parse_args((array) $instance, array('title'=>'','count'=> 0, 'dropdown'=> ''));
					$title = strip_tags($instance['title']);
					$count = $instance['count'] ? 'checked="checked"' : '';
					$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
					?>
					<p>
						<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
						<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
						</p>
						<p>
							<input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> 
							<label for="<?php echo $this->get_field_id('dropdown'); ?>">Display as dropdown</label>
							<br/>
							<input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> 
							<label for="<?php echo $this->get_field_id('count'); ?>">Show post count</label>
						</p>

			<?php }
			// Save, Submit, Sanitize 
			public function update($new_instance,$old_instance){
				$instance = $old_instance;
				$new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['count'] = $new_instance['count'] ? 1 : 0;
				$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;
				return $instance;
			}			
}
add_action('widgets_init',function(){ register_widget('YearlyArchives'); });






