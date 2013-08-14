
$(".loading").hide();

function has_class(){
var form = $('.forms');
	if( form.hasClass("status-false") ){
		form.addClass("notLiked");
	}
	if( form.hasClass("status-true") ){
		form.addClass("Liked");
	}
}

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
          complete: function(){
   		  },
          success: function(data) {
            // Output data
            $.each(data.images, function(i, src) {
			var $content = $('<article class="instagram-image"><form id="'+ data.images[i].data_token +'" class="forms status-'+ data.images[i].data_like +'" action="'+base+'" method="post"><a class="fancybox" href="'+ data.images[i].data_link +'"><img alt="' + data.images[i].data_text + '" src="' + data.images[i].data_url + '" alt="' + data.images[i].data_text + '" /></a><input type="hidden" name="id" value="'+ data.images[i].data_id +'"><p>'+ data.images[i].data_likes +'</p></form></article>');
				var duration = 1000, n = 0.1;
				/*
function dropIn() {
					$content.each(function(n) {
    					$(this).delay(n * duration).fadeIn();
					});
				}
*/
              $('section#images').delay(n * duration).fadeIn().append().each(function() {$content});
              if( $content.find('form').hasClass("status-false") ){
					$content.find('form').addClass("notLiked");
					//$('.notLiked').find('button.unlike').hide();
					$content.find('form a').after('<button class="ajax instabtn button-like like icon-heart" type="submit" name="action" value="Like"></button>');
				}
				if( $content.find('form').hasClass("status-true") ){
					$content.find('form').addClass("Liked");
					//$('.Liked').find('button.like').hide();
					$content.find('form a').after('<button class="ajax instabtn button-unlike unlike icon-heart" type="submit" name="action" value="Unlike"></button>');
				}
              });
            // Store new maxid
            $('#more').data('maxid', data.next_id);
          }
        });
      });
    });
    
    

/*
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

    $("form.forms").each(function () {
    var $this = $(this);
    var $parent = $this.parent();
    	$this.submit(function () {
        	post_form();
        return false;
    	});
	});
*/
/*
$('.button-like').each(function () {
	$(this).on('click', function () {
	var $form = $(this).parent('.forms');
    	$form.submit();
    	console.log($form);
    });
});
*/

    
/*
    $(".button-like").each(function () {
    $(this).click(function (){ 
    var $thisItem = $(this);
	var $parent = $thisItem.parent(".forms");
    	$parent.submit(function () {
        	var data = {
      "action": "like"
    };
    data = $parent.serialize() + "&" + $.param(data);
    var itemId = $parent.find('input.id').val();
    $.ajax({
      type: "POST",
      url: "/actions/", 
      data: data,
      success: function(data) {
        console.log('Like submitted successfully sent');
        $('body').addClass('liked');
      }
    });
        return false;
    	});
    	});
	});
*/


/*
$(".button-like").each(function () {
    var $thisItem = $(this);
    var $parent = $thisItem.parent(".forms");
    $parent.submit(function () {
        var data = {
            "action": "like"
        };
        data = $parent.serialize() + "&" + $.param(data);
        var itemId = $parent.find('input.id').val();
        $.ajax({
            type: "POST",
            url: "/actions/",
            data: data,
            success: function (data) {
                console.log('Like submitted successfully sent');
                //$thisItem.addClass('isliked');
                $thisItem.after('<button class="ajax instabtn button-unlike unlike icon-heart" type="submit" name="action" value="Unlike"></button>');
                $thisItem.remove();
            }
        });
        return false;
    });
    $thisItem.on("click", function (event) {
        $parent.submit();
        event.preventDefault();
    });
});
*/
$("section#images").on("submit", ".forms", function() {
var $likedClick = $(this).find('.button-like').data('clicked', true);
var $unlikedClick = $(this).find('.button-unlike').data('clicked', true);
var $unlikedBtn = $(this).find('.button-unlike'), $likedBtn = $(this).find('.button-like'), $loader = $(this).find('.formSubmit-feedback');

if($likedClick.data('clicked')) {
    //$likedBtn.removeClass("icon-heart").addClass("loading");
    $loader.fadeIn(1000);
    var data = {
            "action": "like"
        };
        data = $(this).serialize() + "&" + $.param(data);
        var itemId = $(this).find('input.id').val();
        $.ajax({
            type: "POST",
            url: "/actions/",
            data: data,
            success: function (data) {
                console.log('Like submitted successfully sent');
                //$thisItem.addClass('isliked');
                //var $thisItem = $likedClick.find('.button-like');
                console.log($likedBtn);
                console.log($likedClick);
                $likedBtn.after('<button class="ajax instabtn button-unlike unlike icon-heart" type="submit" name="action" value="Unlike"></button>');
                $likedBtn.remove();
                $unlikedBtn.addClass("icon-heart");
                $loader.fadeOut(1000);
            }
        });
        return false;
} else if ($unlikedClick.data('clicked')) {
	$loader.fadeIn(1000);
    var data = {
            "action": "unlike"
        };
        data = $(this).serialize() + "&" + $.param(data);
        var itemId = $(this).find('input.id').val();
        $.ajax({
            type: "POST",
            url: "/actions/unlike",
            data: data,
            success: function (data) {
                console.log('Like submitted successfully sent');
                //$thisItem.addClass('isliked');
                var $thisItem = $unlikedClick.find('.button-unlike');
                console.log($unlikedBtn);
                console.log($unlikedClick);
                $unlikedBtn.after('<button class="ajax instabtn button-like like icon-heart" type="submit" name="action" value="Like"></button>');
                $unlikedBtn.remove();
                $loader.fadeOut(1000);
            }
        });
        return false;
}


});
/*
$('.forms').on('click', '.button-like', function() {
	var $parent = $(this).parent('.forms');
	$thisItem = $parent.find('.button-like');
	console.log($parent);
	$parent.submit(function () {
        var data = {
            "action": "like"
        };
        data = $parent.serialize() + "&" + $.param(data);
        var itemId = $parent.find('input.id').val();
        $.ajax({
            type: "POST",
            url: "/actions/",
            data: data,
            success: function (data) {
                console.log('Like submitted successfully sent');
                //$thisItem.addClass('isliked');
                $thisItem.after('<button class="ajax instabtn button-unlike unlike icon-heart" type="submit" name="action" value="Unlike"></button>');
                $thisItem.remove();
            }
        });
        return false;
    });
    $parent.submit();
});
*/



/*
$(".button-unlike").each(function () {
    var $thisItem = $(this), $like = $(".button-like");
    var $parent = $thisItem.parent(".forms");
    $parent.submit(function () {
        var data = {
            "action": "unlike"
        };
        data = $parent.serialize() + "&" + $.param(data);
        var itemId = $parent.find('input.id').val();
        $.ajax({
            type: "POST",
            url: "/actions/unlike",
            data: data,
            success: function (data) {
                console.log('Unlike submitted successfully sent');
                $thisItem.after('<button class="ajax instabtn button-like like icon-heart" type="submit" name="action" value="Like"></button>');
                $thisItem.remove();
            }
        });
        return false;
    });
    $thisItem.on("click", function (event) {
        $parent.submit();
        event.preventDefault();
    });
});
*/
	
	
/*
$("document").ready(function(){
	$(".forms").each(function(){
  $(this).submit(function(){
    var data = {
      "action": "like"
    };
    data = $(this).serialize() + "&" + $.param(data);
    var itemId = $(this).find('input.id').val();
    $.ajax({
      type: "POST",
      url: "/actions/", 
      data: data,
      success: function(data) {
        console.log('Like submitted successfully sent');
        $('body').addClass('liked');
      }
    });
    return false;
  });
	});
});
*/

