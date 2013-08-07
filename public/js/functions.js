$(".loading").hide();
$(document).ready(function() {
      $('#more').click(function() {
        var tag   = $(this).data('tag'),
            maxid = $(this).data('maxid');
        
        $.ajax({
          type: 'GET',
          url: '/ajax',
          data: {
            tag: tag,
            max_tag_id: maxid
          },
          dataType: 'json',
          cache: false,
          success: function(data) {
            // Output data
            $.each(data.images, function(i, src) {
			var $content = $('<article class="instagram-image"><form id="" class="forms" action="'+base+'" method="post"><a class="fancybox" href="'+ data.images[i].data_link +'"><img alt="' + data.images[i].data_text + '" src="' + data.images[i].data_url + '" alt="' + data.images[i].data_text + '" /></a><button onClick="post_form("'+data.images[i].data_id+'",unlike);" class="ajax instabtn unlike icon-heart" type="submit" name="action" value="Unlike"></button><button onClick="post_form("'+data.images[i].data_id+'",like);" class="ajax instabtn like icon-heart" type="submit" name="action" value="Like"></button><input type="hidden" name="id" value="'+ data.images[i].data_id +'"><p>'+ data.images[i].data_likes +'</p></form></article>');
              $('section#images').append($content).fadeIn(1000);
              });
            // Store new maxid
            $('#more').data('maxid', data.next_id);
          }
        });
      });
    });

		function post_form(id, action)
		{
			var token = $('.forms').attr('id');
			var itemId = $('.forms').find('input.id').val();
			var instaUrl = 'https://api.instagram.com/v1/media/'+itemId+'/likes?access_token='+token+'';
			console.log(token);
			console.log(itemId);
			console.log(instaUrl);
			
			var dataString = +action;
			console.log(dataString);
			$.ajax({
				type: "POST",
				url: base,
				//data: $('.forms').serialize(),
				data: {
    				id: itemId,
    				action: dataString
  				},
				crossDomain: true,
				beforeSend: function()
				{
				   $("#loading").fadeIn("slow");
					if ( action == "like" )
					{
						$("#open"+comment_id).hide();
						$("#loading_like_or_unlike"+comment_id).html('<img src="loader.gif" align="absmiddle" alt="Loading...">');
					}
					else if ( action == "unlike" )
					{
						$("#close"+comment_id).hide();
						$("#loading_like_or_unlike"+comment_id).html('<img src="loader.gif" align="absmiddle" alt="Loading...">');
					}
					else {}

				},
				success: function(response)
				{
					response.action
					if ( action == "like" )
					{
						$("#close"+comment_id).show();
					}
					else if ( action == "unlike" )
					{
						$("#open"+comment_id).show();
					}
					else {}
					$("#loading").fadeOut("slow");
				}
			});
			event.preventDefault();
		}

$(document).ready(function() {
	$('button.like').each(function() {
		$(this).on('click', function(){
			post_form();
		});
	});
});



    
/*
$(document).ready(function () {
    $(document).ajaxStart(function () {
        $(".loading").show();
    }).ajaxStop(function () {
        $(".loading").hide();
    });
});
*/



/*
$(".loading").hide();
$(document).ready(function() {
      $('#more').click(function() {
        var tag   = $(this).data('tag'),
            maxid = $(this).data('maxid');
        
        $.ajax({
          type: 'GET',
          url: '/ajax',
          data: {
            tag: tag,
            max_tag_id: maxid
          },
          dataType: 'json',
          cache: false,
          success: function(data) {
            // Output data
            $.each(data.images, function(i, src) {
            $.each(this, function() {

              $('section#images').append(
               '<article class="instagram-image"><div class="loading"></div><form class="forms" action="/image" method="post"><a class="fancybox" href="'+ data.images[i].data_link +'"><img alt="' + data.images[i].data_text + '" src="' + data.images[i].data_url + '" alt="' + data.images[i].data_text + '" /></a><button class="ajax instabtn like icon-heart" type="submit" name="action" value="Like"></button><input type="hidden" name="id" value="'+ data.images[i].data_id +'"><p>'+ data.images[i].data_likes +'</p></form></article>'
              
              );
              });
            });
            // Store new maxid
            $('#more').data('maxid', data.next_id);
          }
        });
      });
    });
    
$(document).ready(function () {
    $(document).ajaxStart(function () {
        $(".loading").show();
    }).ajaxStop(function () {
        $(".loading").hide();
    });
});
*/