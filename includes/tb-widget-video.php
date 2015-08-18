<?php
/**
 * Theme Blvd Video Widget
 *
 * @package Theme Blvd WordPress Framework
 * @author Jason Bobich
 */
class TB_Widget_Video extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'tb-video_widget',
			'description' => __('Quickly embed a video with WordPress\'s built-in oEmbed.', 'theme-blvd-widget-pack')
		);
		$control_ops = array(
			'width' => 400,
			'height' => 350
		);
        parent::__construct( 'themeblvd_video_widget', 'Theme Blvd Video', $widget_ops, $control_ops );
	}

	/**
	 * Widget Options Form
	 */
	public function form($instance) {
		$defaults = array(
			'title' => '',
            'video_url' => '',
            'description' => ''
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'theme-blvd-widget-pack'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('video_url'); ?>"><?php _e('Video URL:', 'theme-blvd-widget-pack'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('video_url'); ?>" name="<?php echo $this->get_field_name('video_url'); ?>" type="text" value="<?php echo esc_attr($instance['video_url']); ?>" />
			<span style="display:block;padding:5px 0" class="description"><?php _e('Enter in a video URL that is compatible with WordPress\'s built-in oEmbed feature.', 'theme-blvd-widget-pack'); ?> <a href="http://codex.wordpress.org/Embeds" target="_blank"><?php _e('Learn More', 'theme-blvd-widget-pack'); ?></a></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'theme-blvd-widget-pack'); ?></label>
			<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text"><?php echo stripslashes($instance['description']); ?></textarea>
			<span style="display:block;padding:5px 0" class="description"><?php _e('Enter in any content you\'d liked displayed after the video.', 'theme-blvd-widget-pack'); ?></span>
		</p>
        <?php
	}

	/**
	 * Update Widget Settings
 	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['video_url'] = strip_tags($new_instance['video_url']);
        $instance['description'] = stripslashes($new_instance['description']);
        return $instance;
	}

	/**
	 * Display Widget
	 */
	public function widget($args, $instance) {

		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( ! $instance['video_url'] ) {
            _e('You forgot to enter a video URL.', 'theme-blvd-widget-pack' );
            echo $after_widget;
            return;
		}

		echo wp_oembed_get( $instance['video_url'] );

		if ( $instance['description'] ) {
			echo '<span class="tb-video_description">'.$instance['description'].'</span>';
		}

		echo $after_widget;
	}

}
