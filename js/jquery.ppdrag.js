/*
 * ppDrag 0.2 - Extremely Fast Drag&Drop for jQuery
 * http://ppdrag.ppetrov.com/
 *
 * Copyright (c) 2008 Peter Petrov (ppetrov AT ppetrov.com)
 * Licensed under the LGPL (LGPL-LICENSE.txt) license.
 */

(function($) {
	
	$.fn.ppdrag = function(options) {
		if (typeof options == 'string') {
			if (options == 'destroy') return this.each(function() {
				$.ppdrag.removeEvent(this, 'mousedown', $.ppdrag.start, false);
				$.data(this, 'pp-ppdrag', null);
			});
		}
		return this.each(function() {
			$.data(this, 'pp-ppdrag', { options: $.extend({}, options) });
			$.ppdrag.addEvent(this, 'mousedown', $.ppdrag.start, false);
		});
	};
	
	$.ppdrag = {
		start: function(event) {
			if (!$.ppdrag.current) {
				$.ppdrag.current = { 
					el: this,
					oleft: parseInt(this.style.left) || 0,
					otop: parseInt(this.style.top) || 0,
					ox: event.pageX || event.screenX,
					oy: event.pageY || event.screenY
				};
				var current = $.ppdrag.current;
				var data = $.data(current.el, 'pp-ppdrag');
				if (data.options.zIndex) {
					current.zIndex = current.el.style.zIndex;
					current.el.style.zIndex = data.options.zIndex;
				}
				$.ppdrag.addEvent(document, 'mouseup', $.ppdrag.stop, true);
				$.ppdrag.addEvent(document, 'mousemove', $.ppdrag.drag, true);
			}
			if (event.stopPropagation) event.stopPropagation();
			if (event.preventDefault) event.preventDefault();
			return false;
		},
		
		drag: function(event) {
			if (!event) var event = window.event;
			var current = $.ppdrag.current;
			current.el.style.left = (current.oleft + (event.pageX || event.screenX) - current.ox) + 'px';
			current.el.style.top = (current.otop + (event.pageY || event.screenY) - current.oy) + 'px';
			if (event.stopPropagation) event.stopPropagation();
			if (event.preventDefault) event.preventDefault();
			return false;
		},
		
		stop: function(event) {
			var current = $.ppdrag.current;
			var data = $.data(current.el, 'pp-ppdrag');
			$.ppdrag.removeEvent(document, 'mousemove', $.ppdrag.drag, true);
			$.ppdrag.removeEvent(document, 'mouseup', $.ppdrag.stop, true);
			if (data.options.zIndex) {
				current.el.style.zIndex = current.zIndex;
			}
			if (data.options.stop) {
				data.options.stop.apply(current.el, [ current.el ]);
			}
			$.ppdrag.current = null;
			if (event.stopPropagation) event.stopPropagation();
			if (event.preventDefault) event.preventDefault();
			return false;
		},
		
		addEvent: function(obj, type, fn, mode) {
			if (obj.addEventListener)
				obj.addEventListener(type, fn, mode);
			else if (obj.attachEvent) {
				obj["e"+type+fn] = fn;
				obj[type+fn] = function() { return obj["e"+type+fn](window.event); }
				obj.attachEvent("on"+type, obj[type+fn]);
			}
		},
		
		removeEvent: function(obj, type, fn, mode) {
			if (obj.removeEventListener)
				obj.removeEventListener(type, fn, mode);
			else if (obj.detachEvent) {
				obj.detachEvent("on"+type, obj[type+fn]);
				obj[type+fn] = null;
				obj["e"+type+fn] = null;
			}
		}
		
	};

})(jQuery);
