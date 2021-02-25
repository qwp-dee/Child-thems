<?php

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
	function Mychildtheme_enqueue_child_styles() {
	   // loading parent style
	   wp_register_style('parent-style', CHI_PRENT_THEME_URI . '/style.css');
	   wp_enqueue_style( 'parent-style' );
	   // loading child style
	   wp_register_style('child-style', CHI_THEME_URI. '/style.css');
	   wp_enqueue_style( 'child-style');
	   
	   // loading custom css file.
	   wp_enqueue_style('custom-css', CHI_THEME_URI . '/assets/css/child-theme.css', array(), '1.1', 'all');
 
	   // loading js file cdn link.
	   wp_register_style( 'animation_js', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css' );
	   wp_enqueue_style('animation_js');


	   // loading inner theme's custom js files.
	   wp_enqueue_script( 'jsfile', CHI_THEME_URI . '/test.js', array ( 'jquery' ), 1.1, true);	  
	   wp_enqueue_script( 'script', CHI_THEME_URI . '/assets/js/custom.js', array ( 'jquery' ), 1.1, true);
	   // loading load more post.

	   // Custom JS
	wp_enqueue_script('jc-custom-min', CHI_THEME_URI .'/ajax/load-more.js', false, '1', true);
    wp_localize_script('jc-custom-min', 'LMAjax', array( 'Ajax_Url' => admin_url( 'admin-ajax.php' ) ) );
	  
	 }
}
add_action( 'wp_enqueue_scripts', 'Mychildtheme_enqueue_child_styles' );




function misha_my_load_more_scripts() {
	global $wp_query; 
	// In most cases it is already included on the page and this line can be removed
	wp_enqueue_script('jquery');
	// register our main script but do not enqueue it yet
	wp_register_script( 'my_loadmore', CHI_THEME_URI . '/ajax/script.js', array('jquery') );
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
 
 	wp_enqueue_script( 'my_loadmore' );
}
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );


























/* add_action( 'wp_footer', 'my_action_javascript' ); // Write our JS below here
function my_action_javascript() {

	 wp_enqueue_script('load_more', CHI_THEME_URI . '/ajax/load-more.js', array('jquery'), 1.1 ,true );
	 wp_localize_script('load_more', 'my_action', array( 'Ajax_Url' => admin_url( 'admin-ajax.php' )) );

}*/

// add_action( 'wp_enqueue_scripts', 'my_enqueue' );
// function my_enqueue() {
//  wp_enqueue_script('like_post', get_template_directory_uri().'/js/post-like.js', '1.0', 1 );
//  wp_localize_script('like_post', 'ajax_var', array(
//  'url' => admin_url('admin-ajax.php'),
//  'nonce' => wp_create_nonce('ajaxnonce')
//  ));
// }

/*

add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	
	$args  = array('post_type' => 'post',
			   		   'paged'=>$_POST['page'],
			   		  );
	$the_query = new WP_Query( $args );
		// the query
		$the_query = new WP_Query( $args ); ?>
		 
		<?php if ( $the_query->have_posts() ) : ?>
    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
       		<h2><?php the_title(); ?></h2>
   		 <?php endwhile; ?>
    
    		<?php wp_reset_postdata(); ?>
		 
		<?php else : ?>
		    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; 
	wp_die(); // this is required to terminate immediately and return a proper response
}
*/




/*
 add_action( 'wp_footer', 'my_action_javascript' ); // Write our JS below here
function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		var page = 2;
		var post_count = jQuery("#posts").data('count');
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		jQuery("#load-post").click(function(){
			var data = {
				'action': 'my_action',
				'page': page
			};
		jQuery.post(ajaxurl, data, function(response) {
			jQuery("#posts").append(response);
				if (post_count == page) {
					jQuery("#load-post").hide();
				}
					console.log(page++);	
		});
	  });
	});
	</script> <?php
}
add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	
	$args  = array('post_type' => 'post',
			   		   'paged'=>$_POST['page'],
			   		  );
	$the_query = new WP_Query( $args );
		// the query
		$the_query = new WP_Query( $args ); ?>
		 
		<?php if ( $the_query->have_posts() ) : ?>
    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
       		<h2><?php the_title(); ?></h2>
   		 <?php endwhile; ?>
    
    		<?php wp_reset_postdata(); ?>
		 
		<?php else : ?>
		    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; 
	wp_die(); // this is required to terminate immediately and return a proper response
}
*/








function wpdocs_excerpt_more( $more ) {
    return '<a href="'.get_the_permalink().'" rel="nofollow">Read More...</a>';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );