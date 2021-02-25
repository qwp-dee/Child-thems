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