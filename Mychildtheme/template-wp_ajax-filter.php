<?php

/*
Template Name: wp ajax post filter
*/
get_header(); ?>

<div class="wrap">

	<!-- <div id="primary" class="content-area"> -->
		<main id="main" class="site-main" role="main">
			<h2>Here I'm Going to used Wordpress ajax post filer</h2>
	<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
	<?php
		if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) : 
 
			echo '<select name="categoryfilter"><option value="">Select category...</option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
			endforeach;
			echo '</select>';
		endif;
	?>
	<input type="text" name="price_min" placeholder="Min price" />
	<input type="text" name="price_max" placeholder="Max price" />
	<label>
		<input type="radio" name="date" value="ASC" /> Date: Ascending
	</label>
	<label>
		<input type="radio" name="date" value="DESC" selected="selected" /> Date: Descending
	</label>
	<label>
		<input type="checkbox" name="featured_image" /> Only posts with featured images
	</label>
	<button>Apply filter</button>
	<input type="button" name="action" value="myfilter">
</form>

<div id="response">
	


</div>

				
	</main><!-- #main -->
	<!-- </div>#primary -->
		
</div><!-- .wrap -->





<script type="text/javascript">
	Query(function($){
	$('#filter').submit(function(){
		var filter = $('#filter');
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(xhr){
				filter.find('button').text('Processing...'); // changing the button label
			},
			success:function(ajaxurl,data){
				filter.find('button').text('Apply filter'); // changing the button label back
				$('#response').html(data); // insert data
			}
		});
		return false;
	});
});
</script>



<?php get_footer(); ?>