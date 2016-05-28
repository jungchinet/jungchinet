/*!
 * Remote providers data scrolling using jQuery
 *
 * Author : eyesonlyz(eyesonlyz@nate.com)
 * Copyright (c) 2011-2012 eyesonlyz
 * Created : 2011-09-25
 * Updated : 2013-01-11
 * License : GPL
 * Preview : http://ir.twing.kr/
 * Version : 0.6
 */
(function ($, undefined) {
	if (typeof ($.ix_rolling_tpls) != 'undefined') {
		return;
	}
	var date_string = function (d) {
		var today_int = (Date.parse(Date().valueOf()));
		var v = Math.abs(today_int - d);
		var result = parseInt(v / 1000);
		if (result > 59) {
			result = parseInt(result / 60);
			if (result > 59) {
				result = parseInt(result / 60);
				if (result > 23) {
					result = parseInt(result / 24);
					if (result > 30) {
						return parseInt(result / 30) + "개월전";
					} else {
						return result + "일전";
					}
				} else {
					return result + "시간전";
				}
			} else {
				return result + "분전";
			}
		} else {
			return result + "초전";
		}
	};
	/**
	 * global ix_rolling templates
	 *
	 */
	$.ix_rolling_tpls = {};

	/**
	 * twitter 탬플릿
	 */
	$.ix_rolling_tpls['twitter'] = {

		/**
		 * 아이템별 body 출력
		 */
		body: function (item, options) {
			var html = "", date, date_int;
			var text = $.ix_rolling_tpls['twitter']._bodyParser(item.text, options.target_string);
			if (options.screen_name) {
				date_int = Date.parse(item.created_at.replace('+', 'UTC+'));
				date = date_string(date_int);
				html += '<p>';
				html += '<a href="http://twitter.com/' + options.screen_name + '/status/' + item.id_str + '" ' + options.target_string + ' class="sns-icon">&nbsp;</a>';
				html += text;
				//if (options.show_date) {
				//	html += '<span class="timer" title="' + date_int + '">' + date + '</span>';
				//}
			} else {
				date_int = Date.parse(item.created_at);
				date = date_string(date_int);
				html += '<p>';
				if (options.use_profile_img) {
					html += "<a href=\"http://twitter.com/intent/user?screen_name=";
					html += item.from_user + "\" " + options.target_string + ">";
					html += '<img class="profile-img" align="left" src="' + item.profile_image_url + '" title="' + item.from_user + '"/></a>';
				}
				html += '<a href="http://twitter.com/' + item.from_user + '/status/' + item.id_str + '" ' + options.target_string + ' class="sns-icon">&nbsp;</a>' + text;
				//if (options.show_date) {
				//	html += '<span class="timer" title="' + date_int + '">' + date + '</span>';
				//}
			}
			html += '<span class="inline-menu">';
			if (options.show_date) {
				html += '<span class="timer" title="' + date_int + '">' + date + '</span><span class="divide">|</span>';
			}
			html += '<a href="https://twitter.com/intent/tweet?in_reply_to=' + item.id_str + '" target="_blank">reply</a><span class="divide">|</span>';
			html += '<a href="https://twitter.com/intent/retweet?tweet_id=' + item.id_str + '" target="_blank">retweet</a><span class="divide">|</span>';
			html += '<a href="https://twitter.com/intent/favorite?tweet_id=' + item.id_str + '" target="_blank">favorite</a>';
			html += '</span>';
			html += '<br class="clear"/></p>';

			return html;
		},
		/**
		 * 기본옵션
		 */
		default_options: {
			keyword: null,
			screen_name: null,
			dataType: 'jsonp',
			dataKey: null,
			cut_text: null, //문자열 자르기항상없음,
			since_id: '',
			use_profile_img: true,
			className: 'twitter',
			cache: false
		},
		get_url: function (options) {
			var url;
			options.dataType = 'jsonp';
			if (options.screen_name) {
				if (options.cache) {
					options.dataType = 'json';
					url = options.ix_path + "/user_timeline.php?screen_name=" + options.screen_name + "&count=" + options.count;
				} else {
					url = "http://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" + options.screen_name + "&count=" + options.count;
				}
				options.dataKey = null;
			} else {
				url = "http://search.twitter.com/search.json?q=" + encodeURI(options.keyword) + '&count=' + options.count;
				options.dataKey = 'results';
			}
			return url;
		},
		get_data: function (data, options) {
			if (data && data.error) {
				return [];
			} else {
				return options.dataKey ? (data[options.dataKey] || {}) : data;
			}
		},
		_bodyParser: function (text, target_string) {
			text = text.replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig, '<a href="$1" ' + target_string + '>$1</a>');
			text = text.replace(/(^|\s)@(\w+)/g, "$1@<a href=\"http://www.twitter.com/$2\" " + target_string + ">$2</a>");
			text = text.replace(/(^|\s)#(\w+)/g, "$1#<a href=\"http://search.twitter.com/search?q=%23$2\" " + target_string + ">$2</a>");
			return text;
		},
		_open_window: function (obj) {
			window.open(obj.href, '', 'width=550,height=550,scrollbars=1,resizable=1');
			return false;
		},
		body_click: function (evt) {
			if (evt.target.tagName == 'A') {
			} else if (evt.target.tagName == 'IMG') {
				evt.preventDefault();
				if (evt.target.parentNode.tagName == 'A') {
					if (evt.target.parentNode.href) {
						window.open(evt.target.parentNode.href, '_blank', 'left=100,top=100,width=550,height=550,scrollbars=1,resizable=1');
					}
				}
			}
		},
		header: function ($$, options) {
		}
	};

	$.fn.ix_rolling = function (settings) {

		var template = settings.template ? $.ix_rolling_tpls[settings.template] || null : null;
		if (!template || !template.default_options) {
			return this;
		}
		var options = {
			height: '200px', ///< 높이
			width: '300px', ///< 너비
			time: 30, ///< ajax 요청 초단위임
			cut_text: null, ///< 문자열 자르기
			target: '_new', ///< 내용링크 타넷
			count: 10, ///< 출력 갯수
			className: null, ///< 탬플릿별 css 처리를 위한 clssname
			show_date: true, ///< 날자(시간) 출력 여부
			use_profile_img: false, ///<프로필 이미지 출력 여부
			body_click: function () { ///< item body 클릭 이벤트
			},
			request_end: function () { ////cancel...
			},
			sleep: 3000, //멈춤시간
			ix_path: "/ix_rolling", ///< ix_rolling 웹 절대경로
			item_body_tag: 'text', ///< item 데이타 본문 키
			item_id_tag: 'id', ///< item 아이디 태그
			item_time_tag: 'created_at', ///< @todo..
			skip_prepare_item: true, ///< count 보다 대기 아이템이 많은경우 유지여부
			prepare_alert: true ///<대기 아이템 갯수 메세지박스 출력여부
		};

		switch (settings.template) {
			case 'tf':
				options.time = 3600;
				//1시간
				break;
			case 'facebook':
			case 'xml':
			case 'gnu4':
				options.time = 1800;
				//30분
				break;
			default:
				options.time = 60;
			//1분
		}

		$.extend(options, template.default_options, settings);
		options.target_string = options.target ? 'target="' + options.target + '"' : '';
		return this.each(function () {

			var timeOut = null;
			var $$ = $(this);
			var __inline_data = [];
			if ($$.find("ul")) {
				__inline_data = $$.find("ul>li").clone();
				$$.html("");
			}

			/** @formatter:off */
			!(options.count < 3) || (options.count = 3);
			!(options.time < 60) || (options.time = 60);
			!(options.width) || $$.css('width', options.width + 'px');
			!(options.screen_name) || $$.addClass('screen_name');
			!(options.className) || $$.addClass(options.className);
			(options.use_profile_img) || $$.addClass('no-profile-img');
			/** @formatter:on */
			options.time = options.time * 1000;
			// body click event
			$$.click(template.body_click);


			$$.data({
				total: 0,
				idxs: {},
				recently_max_id: 0,
				add_els: [],
				started: false,
				stoped: false
			});

			var message_box = $('<div class="ix-rolling-message"></div>').appendTo($$).slideUp();
			options.header = $('<div class="ix-header"></div>').appendTo($$);
			if (options.template == 'twitter' && options.screen_name) {
				$.getJSON('https://api.twitter.com/1/users/show.json?screen_name=' + options.screen_name + '&include_entities=false&callback=?', function (results) {
					var _html = "<div>";
					_html += "<a href=\"http://twitter.com/intent/user?screen_name=";
					_html += options.screen_name + "\" " + options.target_string + ">";
					_html += '<img class="s-profile-img" align="left" src="https://api.twitter.com/1/users/profile_image?screen_name=' + results.screen_name + '&size=mini " title="' + options.screen_name + '"/></a>';
					_html += ' <strong>' + results.screen_name + '</strong>';

					if (results.description) {
						_html += results.description.replace(/(http:\/\/\S+)/g, '<a href="$1" ' + options.target_string + '>$1</a>');
					}
					_html += '<br class="clear"/></div>';
					options.header.append(_html);
					//reload();
				});
				options.header_height = options.header.height();
				message_box.css("top", options.header_height);
				message_box.hide();
			} else {
				if (options.template == 'youtube') {
					if (template.header_parser) {
						template.header_parser(options);
					}
					options.header.show();
				} else {
					options.header.hide();
				}
			}
			//var url = template.get_url(options);

			var btn_move_up = $("<span class='btn-move btn-move-up' unselectable='on'> &nbsp;&nbsp; </span>").appendTo($$);
			var btn_move_down = $("<span class='btn-move btn-move-down' unselectable='on'> &nbsp;&nbsp; </span>").appendTo($$);
			var sync_count = 0, now_sync = $("<span class='sync' unselectable='on'>┛</span>").appendTo($$).toggle(function () {
				$$.data("old_height", $$.height());
				if (window.location != window.parent.location) {

				} else {
					$$.animate({
						height: uls.height() - 2
					}, 400);
				}
				;
			}, function () {
				if (window.location != window.parent.location) {
				} else {
					$$.animate({
						height: $$.data("old_height")
					}, 200);
				}
				;
			}), uls = $("<ul></ul>").appendTo($$);

			if (window.location != window.parent.location) {//@todo
				now_sync.hide();
			}

			var start = function (sc) {
				if (!sc && $$.data("stoped") == true) {
					window.clearTimeout(timeOut);
					timeOut = null;
					return;
				}
				var update = false, last = null, first = uls.find("li:first"), item = null, data = $$.data();
				if (data.add_els && data.add_els.length > 0 && data.recently_max_id == first.data("id")) {
					item = $$.data("add_els").pop();
					last = $('<li unselectable="on">' + template.body(item, options) + "</li>").css("display", "none").appendTo(uls);
					last.data("id", item[options.item_id_tag]);
					update = true;
					data.recently_max_id = item[options.item_id_tag];
					$$.data('recently_max_id', data.recently_max_id);
				} else {
					last = uls.find("li:last");
				}


				if (uls.find("li").length < 2) {//@todo
					return;
				}

				var move_last_height = "+=" + last.outerHeight();
				if (sc && sc == 'up') {
					move_last_height = "-=" + first.outerHeight();
				}

				uls.stop(true, true).animate({
					top: move_last_height
				}, 800, function () {
					uls.css({
						top: '0px'
					});
					if (sc == 'up') {
						var id = first.data("id");
						first.css("display", "none").insertAfter(last).fadeIn(function () {
							$(this).removeClass("first");
							uls.find("li:first").addClass("first");
						}).data("id", id);
					} else {
						var id = last.data("id");
						last.css("display", "none").insertBefore(first).fadeIn(function () {
							if (update) {
								$(this).addClass("first");
							}
						}).data("id", id);
						if (update) {
							uls.find("li:last").remove();
							first.removeClass("first");
							if (options.prepare_alert) {
								var _len = $$.data("add_els").length;
								if (_len > 0 && message_box) {
									message_box.html(_len > 0 ? _len + "개 대기중.." : '').show().slideDown().delay(1000).slideUp();
								}
							}
						}
					}
					window.clearTimeout(timeOut);
					last = null;
					timeOut = null;
					data = null;
					item = null;
					if (options.show_date) {
						$.each(uls.find("span.timer"), function (i, item) {
							item.innerText = date_string(item.title);
						});
					}
					if (!sc) {
						if ($$.data("stoped") == false) {
							timeOut = window.setTimeout(start, options.sleep);
						}
					}
				});
			}, stop = function () {
				$$.data("stoped", true);
			};
			$$.hover(function (evt) {
				stop();
				btn_move_up.show();
				btn_move_down.show();
			}, function () {
				btn_move_up.hide();
				btn_move_down.hide();
				if ($$.data("stoped") == true) {
					$$.data("stoped", false);
					window.clearTimeout(timeOut);
					timeOut = window.setTimeout(start, 1000);
				}
			});

			$(btn_move_down).click(function () {
				start('down');
			});
			$(btn_move_up).click(function () {
				start('up');
			});

			///<@todo
			menu_box = $('<div class="ix-rolling-menu">prev | next | sync</div>').appendTo(now_sync);

			$$.css("height", options.height);

			var reload_time = null;
			var url = template.get_url(options);
			var reload = function () {
				if (!url) {
					return;
				}
				;
				$.ajax({
					url: url + (!options.screen_name ? "&since_id=" + $$.data('recently_max_id') : ""),
					type: "GET",
					cache: false,
					dataType: options.dataType,
					timeout: 30000,
					statusCode: {///1.5
						404: function () {
							//message_box.html('page not found!').slideDown();
						},
						400: function () {
							//message_box.html('page not found!').slideDown();
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {///1.5
						$$.css({
							"backgroundImage": "none"
						});
						try {
							if (jqXHR && jqXHR.getResponseHeader('X-message')) {
								message_box.html(jqXHR.getResponseHeader('X-message')).show().slideDown();
							}
						} catch (e) {
							//console.log(jqXHR);
						}
					},
					success: function (json) {
						var i = 0;
						var rows = new Array();
						var add_els = new Array();

						//alert(json);

						//message_box.html("Request").slideDown().delay(1000).slideUp();

						if (rows = template.get_data(json, options, $$)) {
							//console.log(rows);

							var total = $$.data('total');
							var item_body_tag = options.item_body_tag;
							var item_id_tag = options.item_id_tag;
							$.each(rows, function (i, item) {
								if (item[item_body_tag] && item[item_body_tag].length > 0) {
									if (typeof ($$.data("idxs")[item[item_id_tag]]) == 'undefined') {
										if (sync_count > 0) {
											if (item[item_id_tag] > $$.data('recently_max_id')) {
												add_els.push(item);
												$$.data("idxs")[item[item_id_tag]] = item[item_id_tag];
												if (options.skip_prepare_item && add_els.length > options.count) {
													var j = add_els.length - options.count;
													while (j > 0) {
														add_els.shift();
														--j;
													}
												}
											}
										} else {
											if (total < options.count) {
												$('<li unselectable="on">' + template.body(item, options) + "</li>")[sync_count > 0 ? 'prependTo' : 'appendTo'](uls).data('id', item[item_id_tag]);
												$$.data("idxs")[item[item_id_tag]] = item[item_id_tag];
												$$.data("total", ++total);
												if ($$.data('recently_max_id') < item[item_id_tag]) {
													$$.data('recently_max_id', item[item_id_tag]);
												}
											}
										}
									}
								}
							});
						}
						++sync_count;
						if (sync_count == 1) {
							uls.find("li:first").addClass("first");
							$$.css({
								"backgroundImage": "none"
							});
						}
						if (add_els.length > 0) {
							$$.data("add_els", add_els);
							if (options.prepare_alert) {//debug 용
								//message_box.html("request " + add_els.length + "개 대기중..").slideDown().delay(1000).slideUp();
							}
						}
						if (reload_time) {
							clearTimeout(reload_time);
						}
						reload_time = setTimeout(reload, options.time);
						if (false == $$.data("started") && total > 0) {
							$$.data("started", true);
							setTimeout(start, 2000);
						}
						json = null;
					}
				});
			};
			if (!url) {
				$$.css({
					"backgroundImage": "none"
				});
				for (var i = 0; i < __inline_data.length; i++) {
					$('<li unselectable="on">' + $(__inline_data[i]).html() + "</li>").appendTo(uls).data('id', i);
				}
				setTimeout(start, 2000);
				return;
			} else {
				//if (!options.screen_name) {
				reload();
				//}
			}
			;
		});
	};
	///< facebook 검색 탬플릿
	$.ix_rolling_tpls['facebook'] = {
		body: function (item, options) {
			if (options.show_date) {
				var date_int = item.created_at * 1000;
				var date = date_string(date_int);
			}
			var html = "<p>";
			var target_string = options.target_string;
			var message = item[options.item_body_tag];
			var text = (options.cut_text > 0 && message.length > options.cut_text) ? message.substr(0, options.cut_text) : message;
			text = text.replace(/(http:\/\/\S+)/g, '<a href="$1" ' + target_string + '>$1</a>');
			if (options.use_profile_img) {
				html += '<a href="http://www.facebook.com/profile.php?id=' + item.from.id + '" ' + target_string + '><img src="http://graph.facebook.com/' + item.from.id + '/picture' + '" class="fp_' + item.from.id + ' profile-img" align="left"/></a>';
			}
			html += '<a href="' + (item.link || "javascript:void(0)") + '" ' + target_string + ' class="sns-icon">&nbsp;</a>';
			html += (options.cut_text > 0 && message.length.length > options.cut_text) ? text + '...' : text;
			if (options.show_date) {
				html += '<span class="timer" title="' + date_int + '">' + date + '</span>';
			}
			return html + '<br class="clear"/></p>';
		},
		get_data: function (data, options, $$) {
			if (options.where == 'search') {
				for (var n in data.data) {
					data.data[n].created_at = data.data[n].created_time;
				}
			} else {
				options.item_body_tag = 'content';
				options.item_id_tag = 'id';
				options.use_profile_img = false;
				for (var n in data.entries) {
					//data.entries[n].created_at = data.entries[n].published;
					data.entries[n].link = data.entries[n].alternate;
				}

				return data.entries;
			}
			return data.data;
		},
		get_url: function (options) {
			var url;
			switch (options.where) {
				case 'page':
					url = options.ix_path + '/parser_f_page.php?where_id=' + options.where_id;
					//url = "https://www.facebook.com/feeds/page.php?format=json&id="+options.where_id;
					break;
				default:
					url = "https://graph.facebook.com/search?q=" + encodeURI(options.keyword) + "&date_format=U&type=" + options.type + "&limit=" + options.count;
			}
			return url;
		},
		default_options: {
			where_id: '',
			where: 'search',
			dataType: 'jsonp',
			item_body_tag: 'message',
			item_id_tag: 'id',
			cut_text: 140,
			className: 'facebook',
			use_profile_img: true,
			time: 120,
			count: 10,
			type: 'post' ///<facebook search object type
		}
	};

	///< 그누보드용 탬플릿
	$.ix_rolling_tpls['gnu4'] = {
		body: function (item, options) {
			var target_string = options.target_string;
			var text = item.text.replace(/(http:\/\/\S+)/g, '<a href="$1" ' + target_string + '>$1</a>');

			if (options.show_date) {
				var date_int = Date.parse(item.created_at);
				var date = date_string(date_int);
			}

			var html = '';
			if (item.profile_image_url) {
				html = '<a href="#" ' + (target_string) + '>';
				html += '<img class="profile-img" src="' + item.profile_image_url + '" title="' + item.from_user + '"/></a>';
			}
			var el;
			html += '<a href="' + item.href + '" ' + target_string + '>';
			html += (options.cut_text > 0 && text.length > options.cut_text) ? text.substr(0, options.cut_text) + '...' : text;
			html += '</a>';
			if (options.show_date) {
				html += '<span class="timer" title="' + date_int + '">' + date + '</span>';
			}
			html += '<br class="clear"/>';
			return html;
		},
		get_data: function (data, options) {
			return (data && data.results) ? data.results : [];
		},
		get_url: function (options) {
			if (!options.data_parser) {
				options.data_parser = 'parser_gnu4.php';
			}
			var url = options.ix_path + '/' + options.data_parser + '?bo_table=' + options.bo_table;
			if (options.euckr) {
				url += '&euckr=1';
			}
			return url;
		},
		default_options: {
			bo_table: null,
			euckr: false, //gnuboard euckr
			dataType: 'json',
			className: 'gnu4',
			use_profile_img: false,
			g4_path: "../",
			time: 120,
			cut_text: 140,
			count: 10
		}
	}

	///< XML 탬플릿
	$.ix_rolling_tpls['xml'] = {
		body: function (item, options) {
			var target_string = options.target_string;
			var text = item.text.replace(/(http:\/\/\S+)/g, '<a href="$1" ' + target_string + '>$1</a>');

			if (options.show_date) {
				var date_int = Date.parse(item.created_at);
				var date = date_string(date_int);
			}

			var html = '<p>';
			if (item.profile_image_url) {
				html += '<a href="#" ' + (target_string) + '>';
				html += '<img class="profile-img" src="' + item.profile_image_url + '" title="' + item.from_user + '" align="left"/></a>';
			}
			var el;
			if (item.title) {
				html += '<a href="' + item.href + '" ' + target_string + ' class="all-href title">' + item.title + '</a><br/>';
			}
			html += '<a href="' + item.href + '" ' + target_string + ' class="all-href">';
			html += (options.cut_text > 0 && text.length > options.cut_text) ? text.substr(0, options.cut_text) + '...' : text;
			html += '</a>';
			if (options.show_date) {
				html += '<span class="timer" title="' + date_int + '">' + date + '</span>';
			}
			html += '<br class="clear"/></p>';
			return html;
		},
		get_data: function (data, options, $$) {
			if (options.header.html() == "") {
				if (data.title) {
					var _html = '';
					if (data.logo) {
						_html += '<img class="s-profile-img" align="left" src="' + data.logo + '"/></a>';
					}
					_html += '<a href="' + data.link + '" target="blank">' + data.title + '</a>';
					options.header.html(_html);
					options.header.show();
				}
			}
			return data && data.data ? data.data : [];
		},
		get_url: function (options) {
			if (!options.data_parser) {
				options.data_parser = 'parser_xml.php';
			}
			var url = options.ix_path + '/' + options.data_parser + '?xml=' + encodeURIComponent(options.url);
			return url;
		},
		default_options: {
			dataType: 'json',
			className: 'rss20',
			use_profile_img: false,
			cut_text: 240,
			time: 3600,
			count: 10
		}
	};

	$.ix_rolling_tpls["tf"] = {
		body: function (item, options) {
			var html = "<p>";
			var date = date_string(item.created_at);
			var target_string = options.target_string;

			if (item.stype == 't') {
				text = $.ix_rolling_tpls["twitter"]._bodyParser(item.text, target_string);
			} else if (item.stype == 'y') {
				text = item.text;
			} else {
				text = item.text.substr(0, 140);
				text = text.replace(/(http:\/\/\S+)/g, '<a href="$1" ' + target_string + '>$1</a>');
			}
			html += '<img class="profile-img" align="left" src="' + item.profile_image_url + '" title="' + item.from_user + '"/></a>';
			html += '<a href="' + item.profile_href + '" ' + options.target_string + ' class="sns-icon ' + item.stype + '">&nbsp;</a>';
			html += text;
			if (options.show_date) {
				html += '<span class="timer" title="' + item.created_at + '">' + date + '</span>';
			}
			html += '<br class="clear"/></p>';
			return html;
		},
		default_options: {
			dataType: 'json',
			className: 'tf',
			cut_text: null,
			count: 10
		},
		get_url: function (options) {
			if (!options.data_parser) {
				options.data_parser = 'parser_tf.php';
			}
			return options.ix_path + '/' + options.data_parser + '?keyword=' + options.keyword + "&count=" + options.count + "&no_cache=" + options.no_cache;
		},
		get_data: function (data, options) {
			return data.results;
		}
	};

	$.ix_rolling_tpls['youtube'] = {
		body: function (item, options) {
			var target_string = options.target_string;
			var text = item.body.replace(/(http:\/\/\S+)/g, '<a href="$1" ' + target_string + '>$1</a>');
			if (options.show_date) {
				var date_int = Date.parse(item.created_at);
				var date = date_string(date_int);
			}

			var html = "<p>";

			html += '<a href="' + item.link + '" ' + (target_string) + '><img align="left" src="' + item.thumb + '" class="profile-img-youtube"/></a>';


			html += '<a href="' + item.link + '" ' + target_string + '>';
			html += (options.cut_text > 0 && text.length > options.cut_text) ? text.substr(0, options.cut_text) + '...' : text;
			html += '</a>';
			if (options.show_date) {
				html += '<span class="timer" title="' + date_int + '">' + date + '</span>';
			}
			html += '<br class="clear"/></p>';

			return html;
		},
		header_parser: function (options) {
			$.getJSON("https://gdata.youtube.com/feeds/api/users/" + options.userid + '?alt=json-in-script&callback=?&max-result=' + options.count, function (json) {
				var target_string = options.target_string;
				var _html = "<div>";
				_html += '<a href="http://www.youtube.com/user/' + options.userid + '" ' + target_string + '><img src="' + json.entry.media$thumbnail.url + ' class="s-profile-img" align="left" height="24"/></a>';
				_html += '<span>' + json.entry.content.$t + '</span>';
				_html += '<br class="clear"/></div>';
				options.header.append(_html);
				options.header.show();
			});
		},
		default_options: {
			dataType: 'jsonp',
			className: 'yt',
			cut_text: null,
			show_date: 1,
			use_profile_img: true,
			item_body_tag: 'body',
			item_id_tag: 'item_id',
			target_string: 'target="_new"',
			count: 10
		},
		get_url: function (options) {
			var url = "http://gdata.youtube.com/feeds/users/" + options.userid + "/uploads?alt=json";
			return url;
		},
		get_data: function (data, options) {
			var items = [];
			for (var n in data.feed.entry) {
				items[n] = {
					"link": data.feed.entry[n].link[0].href,
					"body": data.feed.entry[n].title.$t,
					'item_id': data.feed.entry[n].published.$t,
					'thumb': data.feed.entry[n].media$group.media$thumbnail[1].url,
					'created_at': data.feed.entry[n].published.$t
				};
			}
			return items;
		}
	};

	$.ix_rolling_tpls["inline"] = {
		body: function (item, options) {
		},
		default_options: {},
		get_url: function () {

		},
		get_data: function () {

		}
	};

})(jQuery);
