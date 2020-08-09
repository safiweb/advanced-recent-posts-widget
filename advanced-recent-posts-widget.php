<?php
/*
Plugin Name: Advanced Recent Posts Widget
Plugin URI: https://wordpress.org/plugins/advanced-recent-posts-widget/
Description: Adds a widget that can display recent posts from multiple taxonomies or from custom post types with thumbnails.
Version: 1.2
Author: Anthony Webbs
Author URI: http://www.safiweb.co.ke
Text Domain: advanced-recent-posts-widget
License:     GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

/* Inspiration from my son Ian :) */

class Advanced_Recent_Posts_Widget extends WP_Widget {
	
	/**
	 * Sets up a new Advanced Recent Posts widget instance.
	 *
	 * @since 1.0
	 */
	function __construct() {

    	$widget_ops = array(
			'classname'   => 'advanced_recent_posts_widget', 
            'description' => __('Shows recent posts / custom post types. Includes advanced options.'),
            'customize_selective_refresh' => true,
        );
        
        parent::__construct('advanced-recent-posts', __('Advanced Recent Posts'), $widget_ops);
        $this->alt_option_name = 'widget_advanced_recent_posts';
        add_action( 'save_post',				array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post',				array( $this, 'flush_widget_cache' ) );
        add_action( 'switch_theme',				array( $this, 'flush_widget_cache' ) );
        add_action('wp_print_styles',           array( $this, 'add_advanced_recent_posts_widget_stylesheet') );
	}

	/**
	 * Outputs the content for the current Advanced Recent Posts widget instance.
	 *
	 * @since 1.0
	 */
	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
        }
        
		extract( $args );
		
		$default_sort_orders = array('date', 'title', 'comment_count', 'rand');
		
        $title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title'], $instance, $this->id_base);	
        
		if ( ! $number = absint( $instance['number'] ) ) $number = 5;
		
		if ( in_array($instance['sort_by'], $default_sort_orders) ) {
        
            $sort_by = $instance['sort_by'];       
            $sort_order = (bool) $instance['asc_sort_order'] ? 'ASC' : 'DESC';
        
        } else {
        
            // by default, display latest first       
            $sort_by = 'date';        
            $sort_order = 'DESC';
        
		}
		
		if ( ! $title_length = absint( $instance['title_length'] ) ) $title_length = 1000;
        
        if ( ! $excerpt_length = absint( $instance['excerpt_length'] ) ) $excerpt_length = 5;
        
        if( ! $cats = $instance["cats"] )  $cats='';
        
        if( ! $show_type = $instance["show_type"] )  $show_type='post';
        
        if( ! $thumb_h =  absint($instance["thumb_h"] ))  $thumb_h=50;
        
        if( ! $thumb_w =  absint($instance["thumb_w"] ))  $thumb_w=50;
        
        if( ! $excerpt_readmore = $instance["excerpt_readmore"] )  $excerpt_readmore='Read more &rarr;';
         
        //Excerpt more filter
        $new_excerpt_more= create_function('$more', 'return " ";');	
        add_filter('excerpt_more', $new_excerpt_more);
               
        // Excerpt length filter
        $new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
        
        if ( $instance["excerpt_length"] > 0 ) add_filter('excerpt_length', $new_excerpt_length);

		$show_date = isset( $instance['date'] ) ? $instance['date'] : false;

        include 'includes/widget.php';

		if ( 'html5' === $format ) {
			echo '</nav>';
		}

        echo $args['after_widget'];
        
        remove_filter('excerpt_length', $new_excerpt_length);
        remove_filter('excerpt_more', $new_excerpt_more);

	}
	
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint($new_instance['number']);
		$instance['sort_by'] = isset( $new_instance['sort_by'] ) ? esc_attr($new_instance['sort_by']) : 'date';
		$instance['asc_sort_order'] = isset( $new_instance['asc_sort_order'] ) ? (bool) $new_instance['asc_sort_order'] : false;
		$instance['link_new_window'] = isset( $new_instance['link_new_window'] ) ? (bool) $new_instance['link_new_window'] : false;
		$instance['hide_current_post'] = isset( $new_instance['hide_current_post'] ) ? (bool) $new_instance['hide_current_post'] : false;
		$instance['hide_sticky'] = isset( $new_instance['hide_sticky'] ) ? (bool) $new_instance['hide_sticky'] : false;

		//title
		$instance['p_title'] = isset( $new_instance['p_title'] ) ? (bool) $new_instance['p_title'] : false;
		$instance['title_length'] = absint($new_instance['title_length']);
		
		//excerpt
		$instance['excerpt'] = isset( $new_instance['excerpt'] ) ? (bool) $new_instance['excerpt'] : false;
		$instance['excerpt_length'] = absint($new_instance['excerpt_length']);
		$instance['readmore'] = isset( $new_instance['readmore'] ) ? (bool) $new_instance['readmore'] : false;	
		$instance['excerpt_readmore'] = esc_attr($new_instance['excerpt_readmore']);

		//date
		$instance['date'] = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : false;

		//comments
		$instance['comment_num'] = isset( $new_instance['comment_num'] ) ? (bool) $new_instance['comment_num'] : false;

		//media
		$instance['thumb'] = isset( $new_instance['thumb'] ) ? (bool) $new_instance['thumb'] : false;
		$instance['thumb_w'] = absint($new_instance['thumb_w']);
		$instance['thumb_h'] = absint($new_instance['thumb_h']);

		//post types / taxonomies	
		$instance['show_type'] = isset($new_instance['show_type']) ? esc_attr($new_instance['show_type']) : 'post';
		$instance['cats'] = $new_instance['cats'];	
				
		return $instance;
	}
	
	
	
	function form( $instance ) {

		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Posts';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$sort_by = isset( $instance['sort_by'] ) ? esc_attr($instance['sort_by']) : 'date';
		$asc_sort_order = isset( $instance['asc_sort_order'] ) ? (bool) $instance['asc_sort_order'] : false;
		$link_new_window = isset( $instance['link_new_window'] ) ? (bool) $instance['link_new_window'] : false;
		$hide_current_post = isset( $instance['hide_current_post'] ) ? (bool) $instance['hide_current_post'] : false;
		$hide_sticky = isset( $instance['hide_sticky'] ) ? (bool) $instance['hide_sticky'] : false;
		
		//title
		$p_title = isset( $instance['p_title'] ) ? (bool) $instance['p_title'] : false;
		$title_length = isset($instance['title_length']) ? absint($instance['title_length']) : 1000;
		
		//excerpt
		$excerpt = isset( $instance['excerpt'] ) ? (bool) $instance['excerpt'] : false;
		$excerpt_length = isset($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 5;
		$readmore = isset( $instance['readmore'] ) ? (bool) $instance['readmore'] : false;		
		$excerpt_readmore = isset($instance['excerpt_readmore']) ? esc_attr($instance['excerpt_readmore']) : 'Read more &rarr;';

		//date
		$date = isset( $instance['date'] ) ? (bool) $instance['date'] : false;

		//comments
		$comment_num = isset( $instance['comment_num'] ) ? (bool) $instance['comment_num'] : false;

		//media
		$thumb = isset( $instance['thumb'] ) ? (bool) $instance['thumb'] : false;
		$thumb_h = isset($instance['thumb_h']) ? absint($instance['thumb_h']) : 50;
		$thumb_w = isset($instance['thumb_w']) ? absint($instance['thumb_w']) : 50;

		//post types / taxonomies
		$show_type = isset($instance['show_type']) ? esc_attr($instance['show_type']) : 'post';
        $instance['cats'] = $instance['cats'];		
	  
        include 'includes/form.php';

    }
    

	/**
	 * Load the widget's CSS in the HEAD section of the frontend
	 *
	 * @since 1.2
	 */
    public  function add_advanced_recent_posts_widget_stylesheet() {
		$plugin_dir = 'advanced-recent-posts-widget';
		if ( @file_exists( STYLESHEETPATH . '/advanced-recent-posts-widget.css' ) )
			$mycss_file = get_stylesheet_directory_uri() . '/advanced-recent-posts-widget.css';
		elseif ( @file_exists( TEMPLATEPATH . '/advanced-recent-posts-widget.css' ) )
			$mycss_file = get_template_directory_uri() . '/advanced-recent-posts-widget.css';
		else
			$mycss_file = plugins_url( 'css/advanced-recent-posts-widget.css',dirname(__FILE__) );
			
	    
	        wp_register_style( 'wp-advanced-rp-css', $mycss_file );
	        wp_enqueue_style( 'wp-advanced-rp-css' );
	   
    }   


}

/**
 * Register widget on init
 *
 * @since 1.2
 */
function register_advanced_recent_posts_widget () {
	register_widget( 'Advanced_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_advanced_recent_posts_widget', 1 );

?>