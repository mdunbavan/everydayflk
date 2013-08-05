

/*
$(function() {
  $(".instagram-image").each(function() {
  var $form = $(this).find('.forms');
  var $likeBtn = $(this).find('input.like');
    $likeBtn.on('click', function(event) {
     
    	$form.submit(function () {
        	$.ajax({
            	type: $form.attr('method'),
            	//url: $form.attr('action'),
            	url: "https://api.instagram.com/v1/users/USER-ID/relationship?access_token=TOKEN ",
            	data: $form.serialize(),
            	success: function (data) {
                	$(this).trigger('reset');
            	}
        	});

        	return false;
    		});
     
    	});
    
    });
});
*/


$(document).ready(function() {
      $('#more').click(function() {
        var tag   = $(this).data('tag'),
            maxid = $(this).data('maxid');
        
        $.ajax({
          type: 'GET',
          url: 'ajax.php',
          data: {
            tag: tag,
            max_id: maxid
          },
          dataType: 'json',
          cache: false,
          success: function(data) {
            // Output data
            $.each(data.images, function(i, src) {
              $('ul#photos').append('<li><img src="' + src + '"></li>');
            });
            
            // Store new maxid
            $('#more').data('maxid', data.next_id);
          }
        });
      });
    });