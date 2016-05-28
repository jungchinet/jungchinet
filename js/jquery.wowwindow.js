/*
 * Wowwindow, version 0.6.0 beta (2011-02-10)
 * (c) Copyright 2010 Abel Mohler
 * http://wayfarerweb.com/jquery/plugins/wowwindow/
 * Licensed under the MIT license
 * http://wayfarerweb.com/mit.php
 */
(function($){
$.fn.wowwindow = function(o) {
    var defaults = {
        testMode: false,
        draggable: false,
        fixedWindow: false,//overlay.playgroundFixed
        width: 500,//images don't use this
        height: 500,//only used by iframe and videos
        overlay: {
            background: '#000',
            opacity: .6,
            zIndex: 1000,
            fixed: true,
            clickToClose: true,
            destroyOnClose: false
        },
        before: function() {},
        after: function() {},
        onclose: function() {},
        zoom: true,
        rotate: false,
        rotations: 1,
        clockwise: true,
        speed: 800,
        autoplay: true,//only used by videos
        videoIframe: true,//false to use object and embed for flash (as of 2010-12-23 the YouTube Iframe embed is a beta, so there might be bugs in it)
        showRelated: true,//only used by YouTube
        autoYouTubeThumb: null,//set to '0', '1', '2', '3', or 'default' to automatically grab the YouTube thumbnail
        closeButton: '<a class="wowwindow-close" title="close" href="javascript:jQuery(document.body).overlayPlayground(\'close\');void(0)">Close</a>',
        wrapHTML: '<div id="wowwindow-inner"></div>',
        beforeHTML: '<div class="wowwindow-controlbar">{%close%} <span class="wowwindow-title">{%title%}</span></div>',
        afterHTML: '',
        verticalCenter: true,
        forceImageFade: false,
        yabbadabbadoo: false//take the red pill, take the blue pill
    }

    o = o || {}
    if(o.overlay === false) {
        o.overlay = {}
        o.overlay.overlay = false;
    }
    if(o.overlay) {
        o.overlay = $.extend(defaults.overlay, o.overlay);
    }
    o = $.extend(defaults, o);
    o.overlay.playgroundFixed = o.fixedWindow;
    o.overlay.onclose = o.onclose;

    if(o.testMode) {
        if(!window.console) {
            window.console = {};
            window.console.log = function() {}
        }
        $.fn.wowwindow.ii = 0;
    }

    var transform_supported = transformSupported(), loaded = [], seed = Math.round(Math.random() * 10000), minus_or_plus = o.clockwise ? '+' : '-';

    function apply_filters(text) {
        if(this.title) {
            text = text.replace(/\{\%title\%\}/, this.title);
        }
        else if($(this).find('img').length == 1 && $(this).find('*').length == 1) {
            //if IMG element is the only child, we can use its ALT attribute for the title
            var element = $(this).find('img')[0];
            var alt = element.alt || '';
            text = text.replace(/\{\%title\%\}/, alt);
        }
        else {
            text = text.replace(/\{\%title\%\}/, '');
        }
        var closeButton = o.closeButton || '';
        text = text.replace(/\{\%close\%\}/, closeButton);
        return text;
    }

    return this.each(function(){
        //first, replace thumbnail with YouTube Thumbnail if autoYouTubeThumb is set and IMG is a child of said object
        if($(this).attr('href').match(/\/\/www\.youtube\.com\/watch\?/) && o.autoYouTubeThumb && $(this).find('>img').length > 0) {
            var protocol = (document.location.protocol == 'https:') ? 'https://' : 'http://';//we could just use '//:' for the protocol, but this breaks local demo content
            $(this).find('>img').eq(0).attr('src', protocol + 'img.youtube.com/vi/' + this.href.split('v=')[1].split('&')[0] + '/' + o.autoYouTubeThumb + '.jpg');
        }
        $(this).click(function(event){
            event.preventDefault();
            var that = this, path_last_four = $(this).attr('href').slice(-4);//used to detect images
            var is_image = (path_last_four == '.jpg' || path_last_four == '.png' || path_last_four == '.gif' || path_last_four == '.bmp');
            var iframe = false;
            if($(this).attr('href').indexOf('#') === 0) {//inline content
                o.overlay.html = '<div id="wowwindow">' + apply_filters.call(this, $($(this).attr('href')).html()) + '</div>';
            }
            else if(is_image) {//image
                if(loaded[this.href] && !o.forceImageFade) {
                    o.overlay.html = '<div id="wowwindow"><div id="wowwindow-image"><img src="' + this.href + '?' + seed + '"></div></div>';
                }
                else {
                    o.overlay.html = '<div id="wowwindow"><div id="wowwindow-image"><div id="wowwindow-image-loading">&nbsp;</div></div></div>';
                }
            }
            else {//external resource
                iframe = true;
                var iframe_type = '', video_ref;
                if(this.href.match(/\/\/www\.youtube\.com\/watch\?/)) {
                    iframe_type = 'youtube';
                    video_ref = this.href.split('v=')[1].split('&')[0];
                }
                else if(this.href.match(/\/\/vimeo\.com\/([0-9]+)$/) || this.href.match(/\/\/www\.vimeo\.com\/([0-9]+)$/)) {
                    iframe_type = 'vimeo';
                    video_ref = this.href.split('//')[1].split('/')[1];
                }
                o.overlay.html = '<div id="wowwindow-image"><div id="wowwindow-image-loading">&nbsp;</div></div>';
                o.overlay.html = '<div id="wowwindow">' + o.overlay.html + '</div>';
            }

            if(typeof o.before == 'function') {
                o.before.call(this);
            }
            if(iframe && iframe_type != '') {
                o.overlay.onclose = function() {
                    $('#wowwindow iframe, #wowwindow-video-flash').remove();
                }
            }
            $(document.body).overlayPlayground(o.overlay);
            if(iframe) {
                var src = this.href, className = '';
                switch (iframe_type) {
                    case 'youtube':
                        //youtube works with either http:// or https:// hence we let it default to whatever the current page is:
                        src = '//www.youtube.com/embed/' + video_ref + '?rel=' + (o.showRelated ? '1' : '0') + (o.autoplay ? '&autoplay=1' : '');
                        className = 'wowwindow-video wowwindow-video-youtube';
                        if(!o.videoIframe) {
                            $('<div id="wowwindow-video-flash"><object width="' + o.width + '" height="' + o.height + '"><param name="movie" value="http://www.youtube.com/v/' + video_ref + '?fs=1&rel=' + (o.showRelated ? '1' : '0') + (o.autoplay ? '&autoplay=1' : '') + '"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' + video_ref + '?fs=1&rel=' + (o.showRelated ? '1' : '0') + (o.autoplay ? '&autoplay=1' : '') + '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' + o.width + '" height="' + o.height + '"></embed></object></div>').appendTo('#wowwindow');
                        }
                        break;

                    case 'vimeo':
                        //vimeo currently only supports http://
                        src = 'http://player.vimeo.com/video/' + video_ref + '?title=0&byline=0&portrait=0' + (o.autoplay ? '&autoplay=1' : '');
                        className = 'wowwindow-video wowwindow-video-vimeo';
                        if(!o.videoIframe) {
                            $('<div id="wowwindow-video-flash"><object width="' + o.width + '" height="' + o.height + '"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=' + video_ref + '&server=vimeo.com&show_title=0&show_byline=0&show_portrait=0&color=00adef&fullscreen=1' + (o.autoplay ? '&autoplay=1' : '&autoplay=0') + '&loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=' + video_ref + '&server=vimeo.com&show_title=0&show_byline=0&show_portrait=0&color=00adef&fullscreen=1' + (o.autoplay ? '&autoplay=1' : '&autoplay=0') + '&loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="' + o.width + '" height="' + o.height + '"></embed></object></div>').appendTo('#wowwindow');
                        }
                        break;
                }
                if(iframe_type == '' || o.videoIframe) {
                    $(document.createElement('iframe')).attr({
                        id: 'wowwindow-iframe',
                        className: className,
                        src: src,
                        height: o.height,
                        width: o.width,
                        type: 'text/html',
                        frameBorder: '0'
                    }).css({
                        display: 'none'
                    }).load(function() {
                        $(this).fadeIn(300, function() {
                            if(iframe_type == 'youtube') {
                                $(this).parent().html($(this).parent().html());
                            }
                        });
                    }).appendTo('#wowwindow');
                }
            }

            if(!o.fixedWindow) {
                $('body > .overlayPlaygroundPlayground').css({
                    top: $(window).scrollTop() + 'px'
                });
            }

            $('#wowwindow').click(function(){
                $.fn.wowwindow.overLayClickDefault = false;
            });
            if(o.overlay.clickToClose && !$.fn.wowwindow.overLayClickEventSet) {
                $(document.body).click(function(){
                    if($.fn.wowwindow.overLayClickDefault) {
                        $(document.body).overlayPlayground('close');
                    }
                    $.fn.wowwindow.overLayClickDefault = true;
                });
                $.fn.wowwindow.overLayClickEventSet = true;
            }
            $('#wowwindow >*').wrapAll(o.wrapHTML);
            $('#wowwindow').prepend(apply_filters.call(this, o.beforeHTML));
            $('#wowwindow').append(apply_filters.call(this, o.afterHTML));

            if(iframe) {
                $('#wowwindow-iframe').parent().height(o.height);
            }

            if(o.zoom)
                $('#wowwindow').scale(0);

            if(iframe)
                $('#wowwindow').width(o.width + 20);
            else if(!is_image)
                $('#wowwindow').width(o.width);
            else {
                var que_image_load = o.forceImageFade;
                if($('#wowwindow-image-loading').length == 1 || o.forceImageFade) {
                    $('#wowwindow').width($('#wowwindow-image-loading').width() + 20);
                    $('#wowwindow-image-loading').parent().height($('#wowwindow-image-loading').height());
                    que_image_load = true;
                }
                else {
                    var width = $('#wowwindow-image img').width();
                    var height = $('#wowwindow-image img').height();
                    if(o.testMode) {
                        $.fn.wowwindow.ii += 1;
                        console.log('!' + $.fn.wowwindow.ii + '. ' + width + ',' + height);
                    }
                    if(width) {
                        $('#wowwindow').width(width + 20);
                    }
                }
            }

            function _do_after() {
                $('#wowwindow')[0].style.MozTransform = 'none';//if we don't remove this attribute, Firefox won't display video.  We don't need it any more anyhow...
                $('#wowwindow')[0].style.WebkitTransform = 'none';//so we'll do it for webkit too
                $('#wowwindow')[0].style.transform = 'none';//and we'll do it to the regular transform just in case the next FF has this problem
            }

            function _set_draggable() {
                //only works if there's a wowwindow-controlbar and draggable option is set to true
                if(!o.draggable || $('#wowwindow .wowwindow-controlbar').length == 0) return;
                var defaultMousedown = true, startX, startY, windowStartX, windowStartY, drag = false;
                $('#wowwindow .wowwindow-controlbar').mousedown(function(e) {
                    if(defaultMousedown) {
                        startX = e.pageX;
                        startY = e.pageY;
                        if($('#wowwindow')[0].style.top && $('#wowwindow')[0].style.left) {
                            windowStartX = Math.round(parseFloat($('#wowwindow').css('left').replace(/px/, '')));
                            windowStartY = Math.round(parseFloat($('#wowwindow').css('top').replace(/px/, '')));
                        }
                        else {
                            windowStartX = Math.round($('body > .overlayPlaygroundPlayground').width() / 2);
                            windowStartY = Math.round($('body > .overlayPlaygroundPlayground').height() / 2);
                        }
                        drag = true;
                    }
                    defaultMousedown = true;
                });
                $('#wowwindow .wowwindow-controlbar .wowwindow-close').mousedown(function() {
                    defaultMousedown = false;
                });
                $(document.body).mousemove(function(e) {
                    if(drag) {
                        var moveX = e.pageX - startX, moveY = e.pageY - startY,
                        windowMoveX = windowStartX + moveX, windowMoveY = windowStartY + moveY;
                        $('#wowwindow').css({
                            left: windowMoveX + 'px',
                            top: windowMoveY + 'px'
                        });
                    }
                });
                $(window).mouseup(function() {
                    drag = false;
                });
                $('#wowwindow .wowwindow-controlbar').mouseup(function() {
                    drag = false;//IE7-IE8 doesn't detect when attached to the window/body in some cases
                });
            }

            function _zoom_and_or_rotate() {
                if(o.zoom) {
                    $(document.body).overlayPlayground('open');
                    $('#wowwindow').animate({scale: '+=1.00'}, {
                        queue: false, duration: o.speed, complete: function(){
                            if(transform_supported) {
                                _do_after();
                                if(typeof o.after == 'function') o.after.call(that);
                                _set_draggable.call(this);
                            }
                        }
                    });
                }
                else {
                    $(document.body).overlayPlayground('open');
                }

                if(o.rotate) {
                    $('#wowwindow').animate({rotate: minus_or_plus + '=' + (360 * o.rotations) + 'deg'}, {
                        queue: false, duration: o.speed, complete: function() {
                            if(transform_supported && !o.zoom) {
                                _do_after();
                                if(!o.zoom && typeof o.after == 'function') o.after.call(that);
                                _set_draggable.call(this);
                            }
                        }
                    });
                }
                $('#wowwindow').css({
                    marginTop: '-' + ($('#wowwindow').outerHeight() / 2) + 'px',
                    marginLeft: '-' + ($('#wowwindow').outerWidth() / 2) + 'px'
                });
                if(transform_supported) {
                    $('#wowwindow').css({//position determined relative to window, even if !o.fixedWindow, since playground is initially placed relative to scrollbars
                        left: event.clientX + 'px',
                        top: event.clientY + 'px'
                    }).animate({
                        left: ($('body > .overlayPlaygroundPlayground').width() / 2) + 'px',
                        top: ($('body > .overlayPlaygroundPlayground').height() / 2) + 'px'
                    }, o.speed);
                }
            }

            if(!is_image || width || que_image_load) {
                _zoom_and_or_rotate.call(this);
            }
            else {
                var id = setInterval(function() {
                    var width = $('#wowwindow-image img').width();
                    var height = $('#wowwindow-image img').height();
                    if(o.testMode) {
                        $.fn.wowwindow.ii += 1;
                        console.log('!' + $.fn.wowwindow.ii + '. ' + width + ',' + height);
                    }
                    if(width) {
                        $('#wowwindow').width(width + 20);
                        _zoom_and_or_rotate.call(that);
                        clearInterval(id);
                    }
                }, 1);
            }

            if(que_image_load) {
                var img = new Image();
                $(img).attr({//load and hide image so we can read image's dimensions
                    id: 'wowwindow-loaded-image',
                    src: $(that).attr('href') + '?' + seed
                }).css({//positioning off screen like this allows attributes to be read before we need it
                    position: 'absolute',
                    top: '-999em',
                    bottom: '-999em'
                });
                $(img).load(function() {
                    var image = this;
                    $(this).appendTo('#wowwindow-image');
                    var id = setInterval(function() {//occasionally, we need to repeat this until there are readable dimensions
                        var height = $(image).height();
                        var width = $(image).width();
                        if(o.testMode) {
                            $.fn.wowwindow.ii += 1;
                            console.log($.fn.wowwindow.ii + '. ' + width + ',' + height);
                        }
                        if(width) {
                            $('#wowwindow').animate({//this code doesn't get executed until the image loads
                                width: (width + 20) + 'px',
                                marginTop: '-' + ((height + 20) / 2) + 'px',
                                marginLeft: '-' + ((width + 20) / 2) + 'px'
                            }, {
                                queue: o.yabbadabbadoo,
                                duration: 300,
                                complete: function() {
                                    $('#wowwindow-loaded-image').css({
                                        top: '10px',
                                        left: '10px',
                                        display: 'none'
                                    }).fadeIn(300);
                                }
                            });
                            $('#wowwindow-loaded-image').parent().animate({
                                height: height + 'px'
                            });
                            $(img).unbind('load');//otherwise possible baddie for IE users
                            clearInterval(id);
                        }
                    }, 1);
                    loaded[that.href] = true;
                });
            }

            if(!o.zoom && !o.rotate && transform_supported && typeof o.after == 'function') {
                _do_after();
                o.after.call(this);
                _set_draggable.call(this);
            }
            if(!transform_supported && typeof o.after == 'function') {
                _do_after();
                o.after.call(this);
                _set_draggable.call(this);
            }
            return false;
        });
    });
}

//aliases, in case it's forgotten that wowwindow is all lowercase
$.fn.wowWindow = $.fn.WowWindow = $.fn.wowwindow;

$.fn.wowwindow.overLayClickEventSet = false;
$.fn.wowwindow.overLayClickDefault = true;

$.fn.overlayPlayground = function(o){
    var defaults = {
        background: '#000',
        opacity: .75,
        zIndex: 1000,
        fixed: true,
        playgroundFixed: false,
        html: '',
        overlay: true,
        open: true,
        destroyOnClose: false,
        onclose: null
    }
    var modifyContents = true;
    if (o == 'close') o = {open: false};
    if (o == 'open') {
        o = {open: true};
        modifyContents = false;
    }
    o = $.extend(defaults, o);

    if(typeof o.onclose == 'function') {
        $.fn.overlayPlayground.onclose = o.onclose;
    }
    else if(typeof $.fn.overlayPlayground.onclose == 'function') {
        o.onclose = $.fn.overlayPlayground.onclose;
    }

    var ie6 = (typeof document.body.style.maxWidth == "undefined") ? true : false;
    return this.each(function(){
        if(o.open) {
            var playGroundExists = false;
            if($(this).find('> .overlayPlaygroundOverlay, > .overlayPlaygroundPlayground').length > 0) {
                playGroundExists = true;
                $(this).find('> .overlayPlaygroundOverlay, > .overlayPlaygroundPlayground').show();
            }
            $('html,body').css({
                height: '100%'
            });
            if(!modifyContents) return;
            if(o.overlay) {
                var cssObj = {
                    opacity: o.opacity,
                    filter: 'alpha(opacity='+(o.opacity * 100)+')',
                    background: o.background,
                    zIndex: o.zIndex,
                    padding: 0,
                    margin: 0,
                    height: $(document).height() + 'px',
                    width: '100%',
                    left: 0,
                    top: 0,
                    position: 'absolute'
                }
                if(playGroundExists) {
                    $(this).find('> .overlayPlaygroundOverlay').css(cssObj);
                }
                else {
                    $('<div class="overlayPlaygroundOverlay">&nbsp;</div>').css(cssObj).appendTo(this);
                }
            }
            //these style properties are either applied to the new object or the existing one
            var cssObj2 = {
                zIndex: o.zIndex + 10,
                padding: 0,
                margin: 0,
                height: '100%',
                width: '100%',
                left: 0,
                top: 0,
                position: (ie6 || !o.playgroundFixed) ? 'absolute' : 'fixed'
            }
            if(playGroundExists) {
                $(this).find('> .overlayPlaygroundPlayground').css(cssObj2).html(o.html);
            }
            else {
                $('<div class="overlayPlaygroundPlayground"></div>').css(cssObj2).html(o.html).appendTo(this);
                if(ie6 && o.playgroundFixed) {
                    //fix IE6's lack of fixed positioning if called to do so. (maybe not best solution, but it's a diminishing browser and this is easy solution)
                    var that = this;
                    $(window).scroll(function() {
                        $(that).find('> .overlayPlaygroundPlayground').css('top', $(window).scrollTop() + 'px');
                    });
                    $(window).scroll();//simulate scroll event in case we're already down the page
                }
            }
        }
        else {
            if(!o.destroyOnClose)
                $(this).find('.overlayPlaygroundOverlay,.overlayPlaygroundPlayground').hide();
            else
                $(this).find('.overlayPlaygroundOverlay,.overlayPlaygroundPlayground').remove();
            if(typeof o.onclose == 'function')
                o.onclose.call(this);
        }
    });
}

function transformSupported() {
    var properties = ['transform', 'WebkitTransform', 'MozTransform', 'msTransform', 'OTransform'], p;
    while(p = properties.shift()) {
        if(typeof document.body.style[p] != 'undefined') {
            return true;
        }
    }
    return false;
}

// Monkey patch jQuery 1.3.1+ css() method to support CSS 'transform'
// property uniformly across Webkit/Safari/Chrome, Firefox 3.5+, and IE 9+.
// 2009-2010 Zachary Johnson www.zachstronaut.com
// Updated 2010.11.26
function getTransformProperty(element)
{
    // Try transform first for forward compatibility
    var properties = ['transform', 'WebkitTransform', 'MozTransform', 'msTransform', 'OTransform'];
    var p;
    while (p = properties.shift())
    {
        if (typeof element != 'undefined' && typeof element.style[p] != 'undefined')
        {
            return p;
        }
    }

    // Default to transform also
    return 'transform';
}

var proxied = $.fn.css;
$.fn.css = function (arg, val)
{
    // Find the correct browser specific property and setup the mapping using
    // $.props which is used internally by jQuery.attr() when setting CSS
    // properties via either the css(name, value) or css(properties) method.
    // The problem with doing this once outside of css() method is that you
    // need a DOM node to find the right CSS property, and there is some risk
    // that somebody would call the css() method before body has loaded or any
    // DOM-is-ready events have fired.
    if
    (
        typeof $.props['transform'] == 'undefined'
        &&
        (
            arg == 'transform'
            ||
            (
                typeof arg == 'object'
                && typeof arg['transform'] != 'undefined'
                )
            )
        )
        {
        $.props['transform'] = getTransformProperty(this.get(0));
    }

    // We force the property mapping here because jQuery.attr() does
    // property mapping with jQuery.props when setting a CSS property,
    // but curCSS() does *not* do property mapping when *getting* a
    // CSS property.  (It probably should since it manually does it
    // for 'float' now anyway... but that'd require more testing.)
    //
    // But, only do the forced mapping if the correct CSS property
    // is not 'transform' and is something else.
    if ($.props['transform'] != 'transform')
    {
        // Call in form of css('transform' ...)
        if (arg == 'transform')
        {
            arg = $.props['transform'];

            // User wants to GET the transform CSS, and in jQuery 1.4.3
            // calls to css() for transforms return a matrix rather than
            // the actual string specified by the user... avoid that
            // behavior and return the string by calling jQuery.style()
            // directly
            if (typeof val == 'undefined' && jQuery.style)
            {
                return jQuery.style(this.get(0), arg);
            }
        }

        // Call in form of css({'transform': ...})
        else if
        (
            typeof arg == 'object'
            && typeof arg['transform'] != 'undefined'
            )
            {
            arg[$.props['transform']] = arg['transform'];
            delete arg['transform'];
        }
    }

    return proxied.apply(this, arguments);
};
// Monkey patch jQuery 1.3.1+ to add support for setting or animating CSS
// scale and rotation independently.
// 2009-2010 Zachary Johnson www.zachstronaut.com
// Updated 2010.11.06
var rotateUnits = 'deg';

$.fn.rotate = function (val)
{
    var style = $(this).css('transform') || 'none';

    if(typeof style == 'undefined') return this;

    if (typeof val == 'undefined')
    {
        if (style)
        {
            var m = style.match(/rotate\(([^)]+)\)/);
            if (m && m[1])
            {
                return m[1];
            }
        }

        return 0;
    }

    var m = val.toString().match(/^(-?\d+(\.\d+)?)(.+)?$/);
    if (m)
    {
        if (m[3])
        {
            rotateUnits = m[3];
        }

        $(this).css(
            'transform',
            style.replace(/none|rotate\([^)]*\)/, '') + 'rotate(' + m[1] + rotateUnits + ')'
            );
    }

    return this;
}

// Note that scale is unitless.
$.fn.scale = function (val, duration, options)
{
    var style = $(this).css('transform');

    if(typeof style == 'undefined') return this;

    if (typeof val == 'undefined')
    {
        if (style)
        {
            var m = style.match(/scale\(([^)]+)\)/);
            if (m && m[1])
            {
                return m[1];
            }
        }

        return 1;
    }

    $(this).css(
        'transform',
        style.replace(/none|scale\([^)]*\)/, '') + 'scale(' + val + ')'
    );

    return this;
}

// fx.cur() must be monkey patched because otherwise it would always
// return 0 for current rotate and scale values
var curProxied = $.fx.prototype.cur;
$.fx.prototype.cur = function ()
{
    if (this.prop == 'rotate')
    {
        return parseFloat($(this.elem).rotate());
    }
    else if (this.prop == 'scale')
    {
        return parseFloat($(this.elem).scale());
    }

    return curProxied.apply(this, arguments);
}

$.fx.step.rotate = function (fx)
{
    $(fx.elem).rotate(fx.now + rotateUnits);
}

$.fx.step.scale = function (fx)
{
    $(fx.elem).scale(fx.now);
}

/*

Starting on line 3905 of jquery-1.3.2.js we have this code:

// We need to compute starting value
if ( unit != "px" ) {
    self.style[ name ] = (end || 1) + unit;
    start = ((end || 1) / e.cur(true)) * start;
    self.style[ name ] = start + unit;
}

This creates a problem where we cannot give units to our custom animation
because if we do then this code will execute and because self.style[name]
does not exist where name is our custom animation's name then e.cur(true)
will likely return zero and create a divide by zero bug which will set
start to NaN.

The following monkey patch for animate() gets around this by storing the
units used in the rotation definition and then stripping the units off.

*/

var animateProxied = $.fn.animate;
$.fn.animate = function (prop)
{
    if (typeof prop != 'undefined' && typeof prop['rotate'] != 'undefined')
    {
        var m = prop['rotate'].toString().match(/^(([+-]=)?(-?\d+(\.\d+)?))(.+)?$/);
        if (m && m[5])
        {
            rotateUnits = m[5];
        }

        prop['rotate'] = m[1];
    }

    return animateProxied.apply(this, arguments);
}
})(jQuery);
