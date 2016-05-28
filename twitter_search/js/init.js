$(document).ready(function($) {
	function tabMove(obj, dur, easing){
	    if(!dur) dur = 800;
	    if(!easing) easing = 'easeInOutQuint';
	    $('html, body').animate({scrollTop:$('#'+obj).position().top + 200}, dur, easing);
	}

	var load_tweets = function(){
		$("#tweets_loading").show();
	 	$("#twitter_box .load-more").hide();
		if(next_results==null){
			$("#tweets_loading").hide();
			$("#no_tweet").show();
			return false;
		}
		var params = '?q=' + encodeURI(searchString) + '&max_id=' + next_max_id;
 		$.getJSON( '/twitter_search/xhr.php' + params, function( data ){
			$("#tweets_loading").hide();
 			if(data.result==null){
	 			$("#no_tweet").show();
 			}else{
				var body = data.body;
				$("#tweets_box").append(body);
				// if(next_results) tabMove('tweet_id_' + data.first_id);
				$("#twitter_box .load-more").show();
				next_results = data.next_results;
				next_max_id = data.next_max_id;
			}
		});
	};

	load_tweets();

	$('button.load-more').on('click', load_tweets);

	$("#tweets_box").on('click', '.photo', function(){
		$(this).css({'max-height':'none'});
	});

	var lazy_loading = new function(){
	    this.update = function() {
	        lazy_loading.lazy_load_images();
	        lazy_loading.lazy_load_youtube();
	    },
	    this.lazy_load_images = function(){
	        $.each($('div.lazyload-photo').not('.opened'), function(index, image){
	            if (!lazy_loading.is_on_the_screen(image)) return;
	            var img = '<img src="' + $(this).attr("data-src") + '">';
	            $(this).append(img).addClass('opened');
	        });
	    },
	    this.lazy_load_youtube = function(){
	        $.each($('div.lazyload-youtube').not('.opened'), function(index, image){
	            if (!lazy_loading.is_on_the_screen(image)) return;
	            // var embedparms = $(this).attr("data-src").split("youtu.be/")[1].replace(/\&/,'?');
	            var embedparms = $(this).attr("data-src").split("youtu.be/")[1];
	            if(!embedparms) var embedparms = $(this).attr("data-src").split("watch?v=")[1].split("&")[0];
	            var emu = 'http://www.youtube.com/embed/'+embedparms;
	            var html = '<iframe src=' + emu + '?wmode=transparent frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	            $(this).append(html).addClass('opened');
	            $(this).fitVids();
	        });
	    }
	    this.is_on_the_screen = function(elem){
	        var docViewTop = $(window).scrollTop();
	        var docViewBottom = docViewTop + $(window).height();
	        var elemTop = $(elem).offset().top;
	        var elemBottom = elemTop + $(elem).height();
	        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	    }
	}
    $(document).scroll(lazy_loading.update);
    lazy_loading.update();
});