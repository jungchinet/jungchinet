jQuery(function($){
	
	// Menu
	var menu = $('div.menu');
	var major = $('div.major');
	var li_list = major.find('>ul>li');
	
	// Selected
	function onselectmenu(){
		var myclass = [];
		
		$(this).parent('li').each(function(){
			myclass.push( $(this).attr('class') );
		});
		
		myclass = myclass.join(' ');
		if (!major.hasClass(myclass)) major.attr('class','major').addClass(myclass);
	}
	
	// Show Menu
	function show_menu(){
		t = $(this);
		li_list.removeClass('active');
		t.parent('li').addClass('active');
		// IE7 or IE7 documentMode bug fix
		if($.browser.msie) {
			var v = document.documentMode || parseInt($.browser.version);
			if (v == 7) {
				var subWidth = t.next('div.sub').eq(-1).width();
				t.next('div.sub').css('width',subWidth);
			}
		}
	}
	li_list.find('>a').click(onselectmenu).mouseover(show_menu).focus(show_menu);
	
	// Hide Menu
	function hide_menu(){
		li_list.removeClass('active');
	}
	menu.mouseleave(hide_menu);
	li_list.find('div.sub>ul').mouseleave(hide_menu);
	
	//icon
	major.find('div.sub').prev('a').find('>span').append('<span class="i"></span>');
	
	// Aside
	var aside_li = $('.menu>.inset>.aside>ul>li');
	var aside_a = $('.menu>.inset>.aside>ul>li>a');

	// Show Aside
	function show_aside(){
		li_list.removeClass('active');
		aside_li.removeClass('active');
		$(this).parent('li').addClass('active');

		// IE7 or IE7 documentMode bug fix
		if($.browser.msie) {
			var v = document.documentMode || parseInt($.browser.version);

			if (v == 7) {
				var sub = $(this).next('div.sub').eq(-1);
				sub.css('width', '').css('width', sub.width()+'px');
			}
		}
	}	
	aside_a.mouseover(show_aside).focus(show_aside);
	
	// Hide Aside
	function hide_aside(){
		aside_li.removeClass('active');
	}	
	menu.mouseleave(hide_aside);
	aside_li.find('div.sub>ul').mouseleave(hide_aside);

	// Hide Menu & Aside
	$('*:not(".menu *")').focus(hide_menu).focus(hide_aside);
	
});
