$('.cat-list_item').on('click', function() {
  $('.cat-list_item').removeClass('active');
  $(this).addClass('active');

  $.ajax({
    type: 'POST',
    url: '/wp-admin/admin-ajax.php',
    dataType: 'html',
    data: {
      action: 'filter_projects',
      category: $(this).data('slug'),
    },
    success: function(res) {
      $('.project-tiles').html(res);
    }
  })
});

/*Query(function($){
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

*/
