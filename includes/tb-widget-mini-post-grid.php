<?php
/**
 * Theme Blvd Mini Post Grid Widget
 *
 * @package Theme Blvd WordPress Framework
 * @author Jason Bobich
 */
class TB_Widget_Mini_Post_Grid extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'tb-mini_post_grid_widget',
			'description' => __('Show grid of posts or images from gallery.', 'theme-blvd-widget-pack')
		);
		$control_ops = array(
			'width' => 400,
			'height' => 350
		);
        parent::__construct( 'themeblvd_mini_post_grid_widget', 'Theme Blvd Mini Post Grid', $widget_ops, $control_ops );
	}

	/**
	 * Widget Options Form
	 */
	public function form($instance) {
		$defaults = array(
			'title' => 'Recent Posts',
			'thumb'	=> 'smaller',
			'align' => 'left',
			'category' => '',
			'numberposts' => 6,
			'query' => '',
			'gallery' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = isset($instance['title']) ? strip_tags($instance['title']): "";
		$thumb = isset($instance['thumb']) ? strip_tags($instance['thumb']): "";
		$align = isset($instance['align']) ? strip_tags($instance['align']): "";
		$category = isset($instance['category']) ? strip_tags($instance['category']): "";
		$numberposts = isset($instance['numberposts']) ? strip_tags($instance['numberposts']): "";
		$query = isset($instance['query']) ? strip_tags($instance['query']): "";
		$gallery = isset($instance['gallery']) ? strip_tags($instance['gallery']): "";
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'theme-blvd-widget-pack' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('thumb'); ?>"><?php _e( 'Thumbnail Sizes:', 'theme-blvd-widget-pack' ); ?> </label>
			<select class="widefat" id="<?php echo $this->get_field_id('thumb'); ?>" name="<?php echo $this->get_field_name('thumb'); ?>">
				<?php
				$list = null;
				$answers = array( 'small', 'smaller', 'smallest' );
				foreach ( $answers as $answer ) {
					$selected = "";
					if($answer == $thumb) $selected = 'selected="selected"';
					$list .= "<option $selected value='$answer'>$answer</option>";
				}
				echo $list;
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('align'); ?>"><?php _e( 'Thumbnail Alignment:', 'theme-blvd-widget-pack' ); ?> </label>
			<select class="widefat" id="<?php echo $this->get_field_id('align'); ?>" name="<?php echo $this->get_field_name('align'); ?>">
				<?php
				$list = null;
				$answers = array( 'left', 'right', 'center' );
				foreach ( $answers as $answer ) {
					$selected = "";
					if($answer == $align) $selected = 'selected="selected"';
					$list .= "<option $selected value='$answer'>$answer</option>";
				}
				echo $list;
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Category:', 'theme-blvd-widget-pack' ); ?> </label>
			<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
				<?php
				$list = null;
				$answers = array( 'all' => __( 'All Categories', 'theme-blvd-widget-pack' ) );
				if( isset( $GLOBALS['sitepress'] ) ) {
					// WPML compat
					global $sitepress;
					remove_filter('terms_clauses', array( $sitepress, 'terms_clauses' ));
					$categories = get_categories( array( 'hide_empty' => false ) );
					add_filter('terms_clauses', array( $sitepress, 'terms_clauses' ));
				} else {
					$categories = get_categories( array( 'hide_empty' => false ) );
				}
				foreach( $categories as $current_category ) {
					$answers[$current_category->slug] = $current_category->name;
				}
				foreach ( $answers as $key => $value ) {
					$selected = "";
					if($key == $category) $selected = 'selected="selected"';
					$list .= "<option $selected value='$key'>$value</option>";
				}
				echo $list;
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e( 'Number of Posts:', 'theme-blvd-widget-pack' ); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>" type="text" value="<?php echo esc_attr($numberposts); ?>" /></label>
		</p>
		<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">
			<p>
				<label for="<?php echo $this->get_field_id('query'); ?>"><strong><?php _e( 'Custom query string (optional)', 'theme-blvd-widget-pack' ); ?></strong>
				<input class="widefat" id="<?php echo $this->get_field_id('query'); ?>" name="<?php echo $this->get_field_name('query'); ?>" type="text" value="<?php echo esc_attr($query); ?>" /></label>
			</p>
			<p><?php _e( 'Here you can enter in a custom query string formatted for WordPress\'s <a href="http://codex.wordpress.org/Template_Tags/get_posts" target="_blank">get_posts</a>.', 'theme-blvd-widget-pack' ); ?></p>
			<p><?php _e( 'If you enter anything here, your category selection and number of posts selection above will be ignored.', 'theme-blvd-widget-pack' ); ?></p>
			<p>
				Example: "tag=whatever"<br>
				Example: "tag=whatever&category_name=portfolio"<br>
				Example: "tag=whatever&numberposts=5&offset=1"
			</p>
		</div>
		<div style="border: 1px solid #cccccc; margin: 0 0 5px 0; padding: 8px;">
			<p>
				<label for="<?php echo $this->get_field_id('gallery'); ?>"><strong><?php _e( 'Gallery override (optional)', 'theme-blvd-widget-pack' ); ?></strong>
				<input class="widefat" id="<?php echo $this->get_field_id('gallery'); ?>" name="<?php echo $this->get_field_name('gallery'); ?>" type="text" value="<?php echo esc_attr($gallery); ?>" /></label>
			</p>
			<p><?php _e( 'Use the [gallery] shortcode here to display a gallery of images for the mini post grid. Only "link" and "ids" parameters are used here.', 'theme-blvd-widget-pack' ); ?></p>
			<p>Example: [gallery link="file" ids="1,2,3"]</p>
			<p><?php _e( 'If you enter anything here, your category selection, number of posts selection, and custom query options will all be ignored.', 'theme-blvd-widget-pack' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Update Widget Settings
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['thumb'] = strip_tags($new_instance['thumb']);
        $instance['align'] = strip_tags($new_instance['align']);
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['numberposts'] = strip_tags($new_instance['numberposts']);
        $instance['query'] = strip_tags($new_instance['query']);
        $instance['gallery'] = strip_tags($new_instance['gallery']);
        return $instance;
	}

	/**
	 * Display Widget
	 */
	public function widget($args, $instance) {

		extract($args, EXTR_SKIP);

		// Title
		$title = $instance['title'];

		// Build query
		$query = $instance['query'];

		if( ! $query ) {
			$instance['category'] == 'all' ? $category = '' : $category = $instance['category'];
			$query  = 'category_name='.$category;
			$query .= '&numberposts='.$instance['numberposts'];
			$query .= '&suppress_filters=false'; // Mainly for WPML compat
		}
		// Widget output
		echo $before_widget;

		if ( $title ) {
			echo $before_title.$title.$after_title;
		}

		echo themeblvd_get_mini_post_grid( $query, $instance['align'], $instance['thumb'], $instance['gallery'] );
		echo $after_widget;
	}

}
