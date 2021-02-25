<?php

/*
Template Name: wp ajax query filter template
*/
get_header(); ?>

<div class="wrap"> 
	<!-- <div id="primary" class="content-area"> -->
		<main id="main" class="site-main" role="main">
			<h2>Ajax wp - query</h2>

<?php $categories = get_categories(); ?>
<ul class="cat-list">
  <li><a class="cat-list_item active" href="#!" data-slug="">All projects</a></li>

  <?php foreach($categories as $category) : ?>
    <li>
      <a class="cat-list_item" href="#!" data-slug="<?= $category->slug; ?>">
        <?= $category->name; ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>


			<!-- Wp Query for post -->

			<?php 
  $projects = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => -1,
    'order_by' => 'date',
    'order' => 'desc',
  ]);
?>

<?php if($projects->have_posts()): ?>
  <ul class="project-tiles">
    <?php
      while($projects->have_posts()) : $projects->the_post(); 
      		$publish_date = get_the_date( ' Fj, Y' ); ?>


       <div class="team_desc">
				<h4 style="height: 100px;">
					<small>Punlished on : <?php echo $publish_date; ?></small>
					<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
				</h4>

				    <div class="col-md-6">
					   <?php the_post_thumbnail( array(500,500) );?>
				    </div>
			<div class="_location">&nbsp; <?php the_content(); ?></div>
			<?php
      endwhile;
    ?>
  </ul>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
		
		</main><!-- #main -->
	<!-- </div>#primary -->
		
</div><!-- .wrap -->

