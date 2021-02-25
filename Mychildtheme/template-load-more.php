<?php
/*
Template Name: Load More Ajax
*/

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<strong></strong>



<?php
global $wp_query; // you can remove this line if everything works for you
 
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 )
	echo '<div class="misha_loadmore">More posts</div>'; // you can use <a> as well
?>


			
			<?php

			$args1  = array('post_type' => 'post',
			   		   'posts_per_page'=> -1,

			   		  );

		// the query count posts
		$the_query = new WP_Query( $args1 ); 


		$args  = array('post_type' => 'post',
			   		   'paged'=>1,

			   		  );

		// the loop query
		$the_query = new WP_Query( $args ); ?>

	<div class="wrap" id="posts" data-count="<?php echo ceil($the_query->found_posts/2); ?>" >

		<?php if ( $the_query->have_posts() ) : ?>
    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
       		<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>

   		 <?php endwhile; ?>
    
    <?php wp_reset_postdata(); ?>
 
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
	
	</div>

	<div class="load-more">
			<button id="load-post" style="margin-left: 350px;">Load our new post</button>
	</div>
		
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
