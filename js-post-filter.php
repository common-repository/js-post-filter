<?php
/*
Plugin Name: JS Post Filter
Description: A plugin for filter the post based on it type.
Version: 1.0
Author: johnsha
Author URI: https://johnsaolli.wixsite.com/resume
License: GPL
*/
/* This calls recruitment() function when wordpress initializes.*/
/* Note that the recruitment doesnt have brackets.


/**
 * Register a custom menu page.
 */

// create a shortcode for post filter 
function js_post_filter_funcs()  {

  _e('<h2>Post Filter</h2>','js-post-filter');	
  $args = array('public'   => true);
  $post_types = get_post_types($args);
  _e('<select id="jsposttype">','js-post-filter');
  _e('<option>Select the post type</option>','js-post-filter');
  foreach ($post_types as $type)
  {
	  _e('<option value='.$type.'>'.$type.'</option>','js-post-filter');
  }
  _e('</select>','js-post-filter');
  
  _e ('<div id="filterresults"></div>','js-post-filter');
	
}
add_shortcode( 'js-post-filter', 'js_post_filter_funcs' );


// css enqueue code
add_action( 'wp_enqueue_scripts', 'js_post_filter_style' );

function js_post_filter_style(){
        wp_enqueue_style('style', plugin_dir_url( __FILE__ ).'assets/css/style.css');
}  


// js script code
add_action( 'wp_enqueue_scripts', 'js_post_filter_script' );
      function js_post_filter_script() {
		wp_enqueue_script('jquery');
        wp_enqueue_script( 'js-script', plugin_dir_url( __FILE__ ) . 'assets/js/js-script.js', false, '1.0.0' );
       }

	   
	   
// ajax filter code 
function jsajaxpostfilter(){
   global $wpdb;
	$type = $_POST['posttype'];

	$args = array( 'posts_per_page' => 5, 'post_type' => $type );
	$myposts =  new WP_Query(  $args );
	
	if ( $myposts->have_posts() ) :
		while ( $myposts->have_posts() ) : $myposts->the_post();
		    ?>
			<h3><?php the_title() ?> </h3>
			<?php the_excerpt() ?> 
			<span><?php _e ('By: ','js-post-filter'); ?> </span>
			<?php 
			the_author_posts_link(); ?>
			<span><?php _e ('On: ','js-post-filter'); ?> </span>
			<?php 
			the_time('F jS, Y'); ?> 
			<span><?php _e ('In: ','js-post-filter'); ?> </span>
			<?php
			the_category(', ');
		endwhile;
    else :
		_e('Sorry, no posts were found', 'js-post-filter');
    endif;
	
	die();
	
}
add_action('wp_ajax_nopriv_jsajaxpostfilter', 'jsajaxpostfilter');
add_action('wp_ajax_jsajaxpostfilter', 'jsajaxpostfilter');

// code for post content display 
function js_post_filter_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'js_post_filter_excerpt_length', 999 );

function js_post_filter_excerpt_more( $more ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More', 'js-post-filter' )
    );
}
add_filter( 'excerpt_more', 'js_post_filter_excerpt_more' );

