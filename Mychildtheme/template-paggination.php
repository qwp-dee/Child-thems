<?php
/*
Template Name: Load  Ajax
*/

get_header();

global $wp_query; 

 ?>



<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				$args = array('post_type' => 'post','post_status'=>'publish',
					'posts_per_page' => 2,);
				$query = new WP_Query( $args );
              	 if( $query->have_posts() ):
					while( $query->have_posts() ): $query->the_post(); ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(500, 370)); ?></a>
					<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
							
							by <span><?php the_author_posts_link(); ?>
							Categories: <span><?php the_category( ' ' ); ?>
							<?php the_tags( ' Tags: <span>', ', ', '</span>' ); ?>
								
				
					<a href="btn btn-dark"><?php the_excerpt(); ?></a>	
					<?php
					// get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile; 
				 if (  $wp_query->max_num_pages > 1 )
	       				 echo '<div class="misha_loadmore">More posts</div>'; 
				get_next_posts_link(); 
				get_previous_posts_link();
				 
			else :

			 _e('Sorry, no posts matched your criteria.'); 

			endif;
			?>


		</main>

	</div>
</div>

<?php get_footer();
