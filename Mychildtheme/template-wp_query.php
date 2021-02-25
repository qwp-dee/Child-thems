<?php

/*
Template Name: wp query
*/
get_header(); ?>

<div class="wrap">

	<!-- <div id="primary" class="content-area"> -->
		<main id="main" class="site-main" role="main">
			<h2>Here I'm Going to used Wp Query</h2>
				<?php
						$condition = array(
									"post-type"=>"post",
									"post_status"=>"publish",
									"category_name"=>"animals",
									"posts_per_page" => 8
									// Conditional Statements
						);

				$the_query = new WP_Query($condition);  //createing wp_query instance
					 // checking we have post or not provided condition
				if ($the_query->have_posts()) {   
					while($the_query->have_posts()){  // loop through on all posts
							$the_query->the_post();?>		
					<div class="col-md-6 p-4" style="margin-bottom: 10px; padding-bottom: 10px;">
						 <a href= "<?php the_permalink(); ?>">  <h2><?php the_title(); ?></a></h2>
					    <?php the_tags( '<b>Tags : </b> ', ', ', '<br />' );?>
					    <b>Category : <?php the_category(', '); ?></b><br/>
					    <b>Published on : </b><?php the_date( ' Fj, Y' ); ?>
					    <b>By : </b><?php the_author(); ?>
					</div>
					
				    <div class="col-md-6">
					   <?php the_post_thumbnail( array(500,500) );?>
				    </div>
			
					<div class="entry-summary">
					  <?php the_excerpt(); ?>
					  <span><a href="<?php the_permalink(); ?>">More..</a></span>
							
					 </div>

					<?php
					}
						wp_reset_postdata(); // restore our orignal post data
					}else{
						// no posts
					}

				
					?>
					
			
		</select>
			<div class="row">
				<?php
				
global $wpdb;

$result = $wpdb->get_results ( "
    SELECT * 
    FROM  $wpdb->posts
        WHERE post_type = 'page'
" );

foreach ( $result as $page )
{
   echo $page->post_content.'<br/>';
   echo $page->post_title.'<br/>';
}
?>
			</div>
			
		</main><!-- #main -->
	<!-- </div>#primary -->
		
</div><!-- .wrap -->









<?php


$args = array(
    'post_type'    =>  'stories',   // post type name cpt 
    'post_status'  =>  'publish',
    'orderby'      =>  'date', 
    'order'        =>  'DSC',
    'posts_per_page'    => -1,
    'paged'             => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'story_category', //taxonomy name 
            'field'    => 'slug',
            'terms'    => 'blog',         
        ),
    ),
);
$query = new WP_Query( $args );
$publish_date = get_the_date( ' Fj, Y' ); ?>

<div class="col-xs-12 col-sm-6 col-md-4 grid staff">

	<?php if ( $query->have_posts()) : ?>
	<div class="__team_bg">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="team_desc">
				<h4 style="height: 100px;">
					<small>Punlished on : <?php echo $publish_date; ?></small>
					<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
				</h4>
			<div class="_location">&nbsp;</div>
	 <?php endwhile; ?>	
	</div> <!-- End Team_desc -->
   <?php endif; ?>	
  </div><!-- End __team_bg -->

</div> <!-- End Row -->

<?php
/*


<!--Acey Award Recipietns - Honorees Only-->
<section id="Categories_term" class="padd-b40">
	<div class="container">
    	<div class="row">
 <!--Stories Blog Categories -->
<div class="col-xs-12 col-sm-12 col-md-12">             	
<!-- Wp_query arg -->
<?php
$args = array(
    'post_type'    =>  'stories', // post type cpt name
    'post_status'  =>  'publish',
    'orderby'      =>  'date', 
    'order'        =>  'DSC',
    'posts_per_page'    => -1,
    'paged'             => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'story_type', // taxonomy name 
            'field'    => 'slug',
            'terms'    => 'blog',      // taxonomy-term name    
        ),
    ),
);
$query = new WP_Query( $args ); ?>

<!-- if condition  -->
<?php if ( $query->have_posts()) : ?>
<h3>Collective Care Blog Posts</h3>

<div class="__team_content row" id="__team_isotop">
<!-- while condition  -->
<?php while ( $query->have_posts() ) : $query->the_post(); 
$publish_date = get_the_date( ' M j, Y' ); ?>
	<div class="col-xs-12 col-sm-6 col-md-4 grid staff">
		<div class="__team_bg">
			<div class="team_desc">
				<h4 style="height: 100px;">
					<small>Punlished on : <?php echo $publish_date; ?></small>
					<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
				</h4>
				<div class="__location">&nbsp;</div>
			</div>
		</div>
	</div>
	<!-- while End condition  -->
	 <?php endwhile; wp_reset_postdata(); ?>	
	</div>
	<!-- loop if end -->
	<?php endif; ?>	
</div>

            
            </div>  <!-- End Stories Blog Categories  -->
        </div>
    </div>
</section>
<!--Acey Award Recipietns-->


?>



*/ 
?>





<?php get_footer(); ?>