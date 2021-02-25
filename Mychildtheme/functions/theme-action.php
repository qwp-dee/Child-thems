<?php
// Loading theme all action hooks 


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
       		<?php get_template_part( 'template-parts/post/content', get_post_format() );
       		//the_title(); ?>
   		 <?php endwhile; ?>
    
    		<?php wp_reset_postdata(); ?>
		 
		<?php else : ?>
		    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; 
	wp_die(); // this is required to terminate immediately and return a proper response
}


