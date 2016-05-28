/**
 * Easy Widgets jQuery plugin 1.4
 * 
 * David Esperalta - http://www.davidesperalta.com/
 *
 * Please, use the included documentation and examples for information about
 * how use this plugin. Thanks very much! This plugin as been tested in last
 * version of Firefox, Opera, IExplorer, Safari and Konqueror.
 *
 * I base my work on a tutorial writen by James Padolsey
 * http://nettuts.com/tutorials/javascript-ajax/inettuts/
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Easy Widgets. If not, see <http://www.gnu.org/licenses/>.
 */

(function($){

  /**
   * This is the main method of the plugin. Is called when Widgets HTML
   * markup, to execute the appropiate Javascript over it.
   *
   * The method receive the settings argument with some options. If no
   * argument is receive the method use the default plugin settins.
   *
   * See the default settings for this method bello, in this same script.
   *
   * @access public
   * @param settings Array with the plugin options
   * @return Boolean True in every case
   */
  $.fn.EasyWidgets = function(settings){

    /**
     * Recursively extend settings with default plugin settings
     * Put the settings in a short variable for we convenience
     */
    var s = $.extend(true, $.fn.EasyWidgets.defaults, settings);
    /**
     * By default the Widgets editbox are hidden.
     */
    $(s.selectors.editbox).hide();
    /**
     * Prepare the Widget header menu links container
     */
    var widgetMenu = '<span class="' + s.selectors
     .widgetMenu.replace(/\./, '') + '"></span>';
    $(widgetMenu).appendTo(s.selectors.header, this);

    var widgetsIds = new Array();
    /**
     * Iterate the Widgets found in the document, in other words
     * execute some actions for every Widget found in the document
     */
    $(s.selectors.widget).each(function(widgetCount){
      /**
       * Initialize some other variables for we convenience in this
       * workspace. Is more easy (we think) use thisWidget variable
       * insted the $(this) instruction, specially whe use to much.
       */
      var cookieValue = '';
      var thisWidget = $(this);
      var thisWidgetId = thisWidget.attr('id');
      var thisWidgetMenu = thisWidget.find(s.selectors.widgetMenu);
      var thisWidgetContent = thisWidget.find(s.selectors.content);
      var useCookies = (thisWidgetId && s.behaviour.useCookies && $.cookie);

      if(thisWidgetId){
        // Store the Widget ID, if anyone found
        widgetsIds[widgetCount] = thisWidgetId;
      }

      /**
       * In this case we can find if the Widget must
       * be closed (hidden) or not.
       */
      if(useCookies && $.cookie(s.cookies.closeName)){
        cookieValue = $.cookie(s.cookies.closeName);
        if(cookieValue.indexOf(thisWidgetId) != -1){
          thisWidget.hide();
        }
      }

      /**
       * We prepare now the collapse Widget link. This link
       * can be used to collapse and extend the Widget.
       */
      var collapseLink = '';
      /**
       * However, the collapse link only appear if user want
       * with the appropiate class in the Widget HTML markup
       */
      if(thisWidget.hasClass(s.options.collapsable)){

        /**
         * Take a look: we find if the user want to collapse
         * this Widget from the begin, using another CSS class
         *
         * We continue with the link creation, but, the text
         * link and the link behaviour change: can be use to
         * expand the Widget, not to collapse
         */
        if(thisWidget.hasClass(s.options.collapse)){
          collapseLink = WidgetMenuLink(
            s.i18n.extendText,
            s.i18n.extendTitle,
            s.selectors.collapseLink
          );
          thisWidgetContent.hide();
        }else{
          collapseLink = WidgetMenuLink(
            s.i18n.collapseText, 
            s.i18n.collapseTitle,
            s.selectors.collapseLink
          );
        }
        /**
         * Note how the use of cookies can overwrite this link behaviour
         * In other words, the Widget HTML markup can determine that the
         * Widget is collapse or not, but if use cookies the cookie value
         * can change this link behaviour
         */
        if(useCookies){
          cookieValue = $.cookie(s.cookies.collapseName);
          if(cookieValue){
            if(cookieValue.indexOf(thisWidgetId) != -1){
              collapseLink = WidgetMenuLink(
                s.i18n.extendText,
                s.i18n.extendTitle,
                s.selectors.collapseLink
              );
              thisWidgetContent.hide();
            }
          }
        }
        /**
         * Above we prepare the link text, title and CSS class (determine
         * the link behaviour). Here we prepare the execution of this link,
         * in other words, handle the "onmousedown" and "onclick" link events.
         */
        $(collapseLink).mousedown(function(e){
          
          e.stopPropagation();

        }).click(function(){
          /**
           * Some variables for we convenience in this workspace
           */
          var thisLink = $(this);
          var canbeExtend = true;
          var canbeCollapse = true;
          var thisWidget = thisLink.parents(s.selectors.widget);
          var thisWidgetId = thisWidget.attr('id');
          var thisWidgetContent = thisWidget.find(s.selectors.content);
          var contentVisible = thisWidgetContent.css('display') != 'none';
          var useCookie = thisWidgetId && s.behaviour.useCookies && $.cookie;
          thisLink.blur();
          /**
           * Remember the workspace, here we handle the "onclick" event
           * of this link. So, the user use the link and expect something
           */
          if(contentVisible){
            // If Widget content is visible, user want to collapse the Widget
            if($.isFunction(s.callbacks.onCollapseQuery)){
              // Call the appropiate plugin callback for this action
              canbeCollapse = s.callbacks.onCollapseQuery(thisLink, thisWidget);
            }
            // By default the Widget can be collapse, but the plugin callback
            // can change the behaviour using the collapse variable
            if(canbeCollapse){
              // If true, finally the Widget must be collapse
              ApplyEffect(
                thisWidgetContent,
                s.effects.widgetCollapse,
                s.effects.effectDuration,
                false
              );
              thisLink.html(s.i18n.extendText);
              thisLink.attr('title', s.i18n.extendTitle);
              if(useCookie){
                // And prepare the collapse cookies if is use
                var cookieValue = $.cookie(s.cookies.collapseName);
                if(!cookieValue){
                  cookieValue = thisWidgetId;
                }else if(cookieValue.indexOf(thisWidgetId) == -1){
                  cookieValue = cookieValue+','+thisWidgetId;
                }
                $.cookie(s.cookies.collapseName, cookieValue, {
                  path: s.cookies.path,
                  secure: s.cookies.secure,
                  domain: s.cookies.domain,
                  expires: s.cookies.expires
                });
              }
              if($.isFunction(s.callbacks.onCollapse)){
                s.callbacks.onCollapse(thisLink, thisWidget);
              }
            }
          /**
           * The Widget content is not visible, in other words, the user
           * want to expand the Widget
           */
          }else{
            if($.isFunction(s.callbacks.onExtendQuery)){
              // Call the appropiate plugin callback
              canbeExtend = s.callbacks.onExtendQuery(thisLink, thisWidget);
            }
            // If finally the Widget can be extended, show it
            if(canbeExtend){
              thisLink.html(s.i18n.collapseText);
              thisLink.attr('title', s.i18n.collapseTitle);
              ApplyEffect(
                thisWidgetContent,
                s.effects.widgetExtend,
                s.effects.effectDuration,
                true
              );
              if(useCookie){
                // And update the collapse cookie value, removing this Widget
                cookieValue = $.cookie(s.cookies.collapseName);
                if(cookieValue.indexOf(thisWidgetId) != -1){
                  cookieValue = cookieValue.replace(','+thisWidgetId, '');
                  cookieValue = cookieValue.replace(thisWidgetId+',', '');
                  cookieValue = cookieValue.replace(thisWidgetId, '');
                }
                $.cookie(s.cookies.collapseName, cookieValue, {
                  path: s.cookies.path,
                  secure: s.cookies.secure,
                  domain: s.cookies.domain,
                  expires: s.cookies.expires
                });
              }
              if($.isFunction(s.callbacks.onExtend)){
                s.callbacks.onExtend(thisLink, thisWidget);
              }
            }
          }
          // Ever return false to evit default link behaviour
          return false;
        }).appendTo($(thisWidgetMenu, this));
      }
      
      /**
       * We prepare now the edit Widget link. This link
       * can be used to show the Widget editbox.
       */
      var editLink = '';
      /**
       * However, the edit link only appear if user want
       * with the appropiate class in the Widget HTML markup
       */
      if(thisWidget.hasClass(s.options.editable)){
        /**
         * Text, title and behaviour for this link
         */
        editLink = WidgetMenuLink(
          s.i18n.editText, 
          s.i18n.editTitle,
          s.selectors.editLink
        );
        /**
         * Another plugin options are the use of close edit CSS
         * class into the Widget editbox container. If the class
         * exists, attach a method for handle their "onclick" event
         */
        thisWidget.find(s.selectors.closeEdit).click(function(e){
          var thisLink = $(this);
          var thisWidget = thisLink.parents(s.selectors.widget);
          var thisEditLink = thisWidget.find(s.selectors.editLink);
          var thisEditbox = thisWidget.find(s.selectors.editbox);
          thisLink.blur();
          ApplyEffect(
            thisEditbox,
            s.effects.widgetCloseEdit,
            s.effects.effectDuration,
            false
          );
          thisEditLink.html(s.i18n.editText);
          thisEditLink.attr('title', s.i18n.editTitle);
          // Ever return false to evit default link behaviour
          return false;
        });
        /**
         * Above we prepare the link text, title and CSS class (determine
         * the link behaviour). Here we prepare the execution of this link,
         * in other words, handle the "onmousedown" and "onclick" link events.
         */
        $(editLink).mousedown(function(e){

          e.stopPropagation();
          
        }).click(function(){
          /**
           * Again initialize some variables for this workspace
           */
          var canbeShow = true;
          var canbeHide = true;
          var thisLink = $(this);
          var thisWidget = thisLink.parents(s.selectors.widget);
          var thisEditbox = thisWidget.find(s.selectors.editbox);
          var thisEditboxVisible = thisEditbox.css('display') != 'none';
          thisLink.blur();
          /**
           * Remember the workspace, we handle here the "onclick" event
           * of the Widget, so, if the Widget editbox is visible, the user
           * want to hide (close) the Widget editbox.
           */
          if(thisEditboxVisible){
            if($.isFunction(s.callbacks.onCancelEditQuery)){
              canbeHide = s.callbacks.onCancelEditQuery(thisLink, thisWidget);
            }
            if(canbeHide){
              ApplyEffect(
                thisEditbox,
                s.effects.widgetCancelEdit,
                s.effects.effectDuration,
                false
              );
              thisLink.html(s.i18n.editText);
              thisLink.attr('title', s.i18n.editTitle);
              if($.isFunction(s.callbacks.onCancelEdit)){
                s.callbacks.onCancelEdit(thisLink, thisWidget);
              }
            }
          /**
           * If the Widget editbox is not visible, the user want to view
           */
          }else{
            if($.isFunction(s.callbacks.onEditQuery)){
              // A plugin callback have the opportunity of handle this
              canbeShow = s.callbacks.onEditQuery(thisLink, thisWidget);
            }
            if(canbeShow){
              // Ok, finally show the Widget edit box
              thisLink.html(s.i18n.cancelEditText);
              thisLink.attr('title', s.i18n.cancelEditTitle);
              ApplyEffect(
                thisEditbox,
                s.effects.widgetOpenEdit,
                s.effects.effectDuration,
                true
              );
              if($.isFunction(s.callbacks.onEdit)){
                s.callbacks.onEdit(thisLink, thisWidget);
              }
            }
          }
          // Ever return false to evit default link behaviour
          return false;
        }).appendTo($(thisWidgetMenu, this));
      }

      /**
       * Now is the turn of the remove Widget link. This link can be
       * use to close (hide) the Widget. Note that no link to show the
       * Widget is provided: when a Widget is hidden, is hidden.
       */
      var removeLink = '';
      /**
       * However, the remove link only appear if user want
       * with the appropiate class in the Widget HTML markup
       */
      if(thisWidget.hasClass(s.options.removable)){
        /**
         * Text, title and behaviour for this link
         */
        removeLink = WidgetMenuLink(
          s.i18n.closeText, 
          s.i18n.closeTitle,
          s.selectors.closeLink
        );
        /**
         * After the text, title and behaviour for this link, is turn
         * for handle the "onmousedown" and "onclick" events
         */
        $(removeLink).mousedown(function(e){

          e.stopPropagation();

        }).click(function(){
          /**
           * Variables for we convenience in this workspace
           */
          var canbeRemove = true;
          var thisLink = $(this);
          var thisWidget = thisLink.parents(s.selectors.widget);
          var thisWidgetId = thisWidget.attr('id');
          var useCookie = (thisWidgetId && s.behaviour.useCookies && $.cookie);
          thisLink.blur();
          
          if($.isFunction(s.callbacks.onCloseQuery)){
            // An opportunity to not close the Widget
            canbeRemove = s.callbacks.onCloseQuery(thisLink, thisWidget);
          }
          if(canbeRemove){
            /**
             * Another options of this plugin can be use to show a confirm
             * dialog to the user before close the Widget. So, take a look
             * at the bellow condition: if the Widget have the CSS class
             * that we expect, we use the confirm dialog. In other case
             * the confirm dialog not it show.
             */
            if(!thisWidget.hasClass(s.options.closeConfirm)
             || confirm(s.i18n.confirmMsg)){
               if(useCookie){
                 // Store this Widget ID in the Widget closes cookie
                 var cookieValue = $.cookie(s.cookies.closeName);
                 if(!cookieValue){
                   cookieValue = thisWidgetId;
                 }else if(cookieValue.indexOf(thisWidgetId) == -1){
                   cookieValue = cookieValue+','+thisWidgetId;
                 }
                 $.cookie(s.cookies.closeName, cookieValue, {
                   path: s.cookies.path,
                   secure: s.cookies.secure,
                   domain: s.cookies.domain,
                   expires: s.cookies.expires
                 });
               }
               ApplyEffect(
                 thisWidget,
                 s.effects.widgetClose,
                 s.effects.effectDuration,
                 false
               );
               if($.isFunction(s.callbacks.onClose)){
                 s.callbacks.onClose(thisLink, thisWidget);
               }
            }
          }
          // Ever return false to evit default link behaviour
          return false;
        }).appendTo($(thisWidgetMenu, this));
      }
    });

    /**
     * Repositioned the Widgets
     */
    var i, j = 0;
    var widgetsPositions = ''; 
    var useCookies = s.behaviour.useCookies && $.cookie;
    /**
     * The user can send to the plugin the appropiate serialized
     * string, returned by the plugin in the "onUpdatePotisions"
     * callback, see bellow.
     *
     * So, if the user send to the plugin the Widgets positions
     * using the "onRefreshPositions" callback. See the code:
     * if the user provided a serialized string, the plugin use it.
     *
     * And another possibility is that the plugin retrieve the
     * Widgets positions from the appropiate cookie. So, if the
     * user not provide the positions with "onRefreshPositions"
     * we find if must be use the cookie.
     */
    if($.isFunction(s.callbacks.onRefreshPositions)){
      widgetsPositions = s.callbacks.onRefreshPositions();
    }else if(useCookies && $.cookie(s.cookies.positionName)){
      widgetsPositions = $.cookie(s.cookies.positionName)
    }
    if($.trim(widgetsPositions) != ''){
      i = j = 0;
      var columns = widgetsPositions.split('|');
      var totalColumns = columns.length;
      for(i = 0; i < totalColumns; i++){
        var column = columns[i].split('=');
        var columnSel = '#'+column[0];
        if($(columnSel)){
          var widgets = column[1].split(',');
          var totalWidgets = widgets.length;
          for(j = 0; j < totalWidgets; j++){
            if($.trim(widgets[j]) != ''){
              var widgetSel = '#'+widgets[j];
              $(widgetSel).appendTo(columnSel);
            }
          }
        }
      }
    }

   /**
    * Prepare the Widget and columns to be sortables
    */
    var sortableItems = null;
    /**
     * Finf all the Widgets that we turn bellow in sortable items
     */
    sortableItems = (function(){
      var fixedWidgets = '';
      /**
       * Iterate for all Widgets
       */
      $(s.selectors.widget).each(function(count){
        /**
         * And find for movables or fixed Widgets
         */
        if(!$(this).hasClass(s.options.movable)){
          if(!this.id){
            // Unique ID for the Widget in any case
            this.id = 'widget-without-id-' + count;
          }
          fixedWidgets += '#'+this.id+',';
        }
      });
      /**
       * Finally return movable Widgets and Widgets columns as sortable items
       * Take a look at the container option: determine the Widget container
       * and can be "div", "li" or another. By default is a "div", that is,
       * the Widget is stored in a "div" container.
       */
      return $('> '+s.selectors.container+':not(' + fixedWidgets + ')',
       s.selectors.columns);
    })();
 
    /**
     * Prepare the Widget headers of movable Widgets found. Set their
     * cursor and handle their "onmosedown" and "onmouseup" events.
     */
    sortableItems.find(s.selectors.header).css({
      cursor: 'move'
    }).mousedown(function(e){
      var thisHeader = $(this);
      sortableItems.css({width:''});
      thisHeader.parent().css({
        width: thisHeader.parent().width() + 'px'
      });
   }).mouseup(function(){
      var thisHeader = $(this);
      if(!thisHeader.parent().hasClass('dragging')){
        thisHeader.parent().css({width:''});
      }else{
        $(s.selectors.columns).sortable('disable');
      }
    });

    /**
     * Now we are prepared to call the sortable jQuery function
     * over the Widgets columns found in the document. More information
     * about this function can be found in the jQuery Wiki website.
     */
    $(s.selectors.columns).sortable({
      items: sortableItems,
      containment: 'document',
      forcePlaceholderSize: true,
      handle: s.selectors.header,
      delay: s.behaviour.dragDelay,
      revert: s.behaviour.dragRevert,
      opacity: s.behaviour.dragOpacity,
      connectWith: $(s.selectors.columns),
      placeholder: s.selectors.placeHolder,
      start : function(e, ui){
        $(ui.helper).addClass('dragging');
      },
      stop : function(e, ui){
        $(ui.item).css({width : ''}).removeClass('dragging');
        $(s.selectors.columns).sortable('enable');
        /**
         * Some variables for we convenience in this workspace
         */
        var currentPositions = '';
        var widgetId = ui.item[0].id;
        var useCookies = widgetId && s.behaviour.useCookies && $.cookie;
        /**
         * Get the current positions of the Widgets
         */
        $(s.selectors.columns).each(function(i){
          var thisColumn = this;
          var widgetsValue = '';
          var columnValue = thisColumn.id + '=';
          $(thisColumn).children(s.selectors.widget).each(function(j){
            var thisWidget = this;
            if(widgetsValue == ''){
              widgetsValue += thisWidget.id;
            }else{
              widgetsValue += ','+thisWidget.id;
            }
          });
          columnValue += widgetsValue;
          if(currentPositions == ''){
            currentPositions += columnValue;
          }else{
            currentPositions += '|' + columnValue;
          }
        });
        // Tell the user, maybe save the positions
        if($.isFunction(s.callbacks.onChangePositions)){
          s.callbacks.onChangePositions(currentPositions);
        // Or maybe the user want to use cookies directly
        }else if(useCookies){
          if($.cookie(s.cookies.positionName) != currentPositions){
            $.cookie(s.cookies.positionName, currentPositions, {
              path: s.cookies.path,
              secure: s.cookies.secure,
              domain: s.cookies.domain,
              expires: s.cookies.expires
            });
          }
        }
        if($.isFunction(s.callbacks.onDragStop)){
          s.callbacks.onDragStop(e, ui);
        }
        return true;
      }
    });

    /**
     * Looking now for Widgets that maybe dont exists in the HTML
     * markup, so, no have sense that this Widgets still stored in
     * the related cookies.
     *
     * This task is for "closed" and "collapsed" cookies, see above
     * how we deal with the "positioned" cookie. And take a look at
     * the "random" clean cookies.
     *
     * We clean the cookies only in "random" request, not in everyone.
     * So, even if the clean cookies dont consume much resources, we
     * consume less if clean the cookies only in "random" request.
     *
     * Math.ceil(Math.random() * 3) can be 1, 2 or 3. We clean the
     * cookies only when the result is 1, as you can see bellow.
     */
    
    var cleanCookies = useCookies
     && (widgetsIds.length > 0)
      && (Math.ceil(Math.random() * 3) == 1);

    if(cleanCookies){
      i = j = 0;
      var cookies = new Array(
        s.cookies.closeName,
        s.cookies.collapseName
      );
      var cookiesLen = cookies.length;
      for(i = 0; i < cookiesLen; i++){
        if($.cookie(cookies[i])){
          var widgetId = '';
          var cookieValue = '';
          var currents = $.cookie(cookies[i]).split(',');
          var optionsLen = currents.length;
          for(j = 0; j < optionsLen; j++){
            widgetId = $.trim(currents[j]);
            if($.inArray(widgetId, widgetsIds) != -1){
              if($.trim(cookieValue) == ''){
                 cookieValue += widgetId;
              }else{
                 cookieValue += ','+widgetId;
              }
            }
          }
          $.cookie(cookies[i],  cookieValue,{
            path: s.cookies.path,
            secure: s.cookies.secure,
            domain: s.cookies.domain,
            expires: s.cookies.expires
          });
        }
      }
    }    
  };
  // End of the main plugin function

  /**
   * This method can be use to disable the Widgets sortable feature.
   *
   * @access public
   * @param settings Array with the plugin options
   * @return Boolean True if Widgets can be disable, False if not
   */
  $.fn.DisableEasyWidgets = function(settings){
    var disable = true;
    var s = $.extend(true, $.fn.EasyWidgets.defaults, settings);
    if($.isFunction(s.callbacks.onDisableQuery)){
      disable = s.callbacks.onDisableQuery();
    }
    if(disable){
      $(s.selectors.columns).sortable('disable');
      $(s.selectors.widget).each(function(){
        var thisWidget = $(this);
        if(thisWidget.hasClass(s.options.movable)){
          // Because if not is movable this cursor not have sense
          thisWidget.find(s.selectors.header).css('cursor', 'default');
        }
      });
      if($.isFunction(s.callbacks.onDisable)){
        s.callbacks.onDisable();
      }
      return true;
    }else{
      return false;
    }
  };

  /**
   * This method can be use to re-enable the Widgets sortable feature.
   *
   * @access public
   * @param settings Array with the plugin options
   * @return Boolean True if Widgets can be enable, False if not
   */
  $.fn.EnableEasyWidgets = function(settings){
    var enable = true;
    var s = $.extend(true, $.fn.EasyWidgets.defaults, settings);
    if($.isFunction(s.callbacks.onEnableQuery)){
      enable = s.callbacks.onEnableQuery();
    }
    if(enable){
      $(s.selectors.columns).sortable('enable');
      $(s.selectors.widget).each(function(){
        var thisWidget = $(this);
        if(thisWidget.hasClass(s.options.movable)){
          // Because if not is movable this cursor not have sense
          thisWidget.find(s.selectors.header).css('cursor', 'move');
        }
      });
      if($.isFunction(s.callbacks.onEnable)){
        s.callbacks.onEnable();
      }
      return true;
    }else{
      return false;
    }
  };

  /**
   * This method can be use to show an individual widget
   *
   * @access public
   * @param id String Widget identifier to be show
   * @param settings Plugin settings to be use
   * @return Boolean True in every case
   */
  $.fn.ShowEasyWidget = function(id, settings){
    var widgetId = '#'+id;
    var thisWidget = $(widgetId);
    var s = $.extend(true, $.fn.EasyWidgets.defaults, settings);
    ApplyEffect(
      thisWidget,
      s.effects.widgetShow,
      s.effects.effectDuration,
      true
    );
    if(s.behaviour.useCookies){
      var cookieName = s.cookies.closeName;
      var cookieValue = $.cookie(cookieName);
      if(cookieValue != ''){
        cookieValue = cookieValue.replace(','+id, '');
        cookieValue = cookieValue.replace(id+',', '');
        cookieValue = cookieValue.replace(id, '');
      }
      $.cookie(cookieName, cookieValue, {
        path : s.cookies.path,
        expires : s.cookies.expires
      });
    }
    return true;
  };

  /**
   * This method can be use to hide an individual widget
   *
   * @access public
   * @param id String Widget identifier to be hide
   * @param settings Plugin settings to be use
   * @return Boolean True in every case
   */
  $.fn.HideEasyWidget = function(id, settings){
    var widgetId = '#'+id;
    var thisWidget = $(widgetId);
    var s = $.extend(true, $.fn.EasyWidgets.defaults, settings);
    ApplyEffect(
      thisWidget,
      s.effects.widgetHide,
      s.effects.effectDuration,
      false
    );
    if(s.behaviour.useCookies){
      var cookieName = s.cookies.closeName;
      var cookieValue = $.cookie(cookieName);
      if(!cookieValue){
        cookieValue = id;
      }else if(cookieValue.indexOf(id) == -1){
        cookieValue = cookieValue+','+id;
      }
      $.cookie(cookieName, cookieValue, {
        path : s.cookies.path,
        expires : s.cookies.expires
      });
    }
    return true;
  };
  
  /**
   * Fill the plugin default settings
   */
  $.fn.EasyWidgets.defaults = {
    // Behaviour of the plugin
    behaviour : {
      // Miliseconds delay between mousedown and drag start
      dragDelay : 100,
      // Miliseconds delay between mouseup and drag stop
      dragRevert : 100,
      // Determinme the opacity of Widget when start drag
      dragOpacity : 0.8,
      // Cookies (require Cookie plugin) to store positions and states
      useCookies : false
    },
    // Some effects that can be apply sometimes
    effects : {
      // Miliseconds for effects duration
      effectDuration : 500,
      // Can be none, slide or fade
      widgetShow : 'none',
      widgetHide : 'none',
      widgetClose : 'none',
      widgetExtend : 'none',
      widgetCollapse : 'none',
      widgetOpenEdit : 'none',
      widgetCloseEdit : 'none',
      widgetCancelEdit : 'none'
    },
    // Only for the optional cookie feature
    cookies : {
      // Cookie path
      path : '',
      // Cookie domain
      domain : '',
      // Cookie expiration time in days
      expires : 90,
      // Store a secure cookie?
      secure : false,
      // Cookie name for close Widgets
      closeName : 'easywidgets-close',
      // Cookie name for positined Widgets
      positionName : 'easywidgets-position',
      // Cookie name for collapsed Widgets
      collapseName : 'easywidgets-collapse'
    },
    // Options name to use in the HTML markup
    options : {
      // To recognize a movable Widget
      movable : 'movable',
      // To recognize a editable Widget
      editable : 'editable',
      // To recognize a collapse Widget
      collapse : 'collapse',
      // To recognize a removable Widget
      removable : 'removable',
      // To recognize a collapsable Widget
      collapsable : 'collapsable',
      // To recognize Widget that require confirmation when remove
      closeConfirm : 'closeconfirm'
    },
    // Callbacks functions
    callbacks : {
      // When a editbox is closed, send the link and the widget objects
      onEdit : null,
      // When a Widget is closed, send the link and the widget objects
      onClose : null,
      // When Widgets are enabled using the appropiate public method
      onEnable : null,
      // When a Widget is extend, send the link and the widget objects
      onExtend : null,
      // When Widgets are disabled using the appropiate public method
      onDisable : null,
      // When a editbox is closed, send a ui object, see jQuery::sortable()
      onDragStop : null,
      // When a Widget is collapse, send the link and the widget objects
      onCollapse : null,
      // When a editbox is try to close, send the link and the widget objects
      onEditQuery : null,
      // When a Widget is try to close, send the link and the widget objects
      onCloseQuery : null,
      // When a editbox is cancel (close), send the link and the widget objects
      onCancelEdit : null,
      // When Widgets are enabled using the appropiate public method
      onEnableQuery : null,
      // When a Widget is try to expand, send the link and the widget objects
      onExtendQuery : null,
      // When Widgets are disabled using the appropiate public method
      onDisableQuery : null,
      // When a Widget is try to expand, send the link and the widget objects
      onCollapseQuery : null,
      // When a editbox is try to cancel, send the link and the widget objects
      onCancelEditQuery : null,
      // When one Widget is repositioned, send the positions serialization
      onChangePositions : null,
      // When Widgets need repositioned, get the serialization positions
      onRefreshPositions : null
    },
    // Selectors in HTML markup. All can be change by you, but not all is
    // used in the HTML markup. For example, the "editLink" or "closeLink"
    // is prepared by the plugin for every Widget.
    selectors : {
      // Container of a Widget (into another element that use as column)
      // The container can be "div" or "li", for example. In the first case
      // use another "div" as column, and a "ul" in the case of "li".
      container : 'div',
      // Class identifier for a Widget
      widget : '.widget',
      // Class identifier for a Widget header (handle)
      header : '.widget-header',
      // Class for the Widget header menu
      widgetMenu : '.widget-menu',
      // Class identifier for a Widget column (parents of Widgets)
      columns : '.widget-column',
      // Class identifier for Widget editboxes
      editbox : '.widget-editbox',
      // Class identifier for Widget content
      content : '.widget-content',
      // Class identifier for editbox close link or button, for example
      closeEdit : '.widget-close-editbox',
      // Class identifier for a Widget edit link
      editLink : '.widget-editlink',
      // Class identifier for a Widget close link
      closeLink : '.widget-closelink',
      // Class identifier for Widgets placehoders
      placeHolder : 'widget-placeholder',
      // Class identifier for a Widget collapse link
      collapseLink : '.widget-collapselink'
    },
    // To be translate the plugin into another languages
    // But this variables can be used to show images instead
    // links text, if you preffer. In this case set the HTML
    // of the IMG elements.
    i18n : {
      // Widget edit link text
      editText : 'Edit',
      // Widget close link text
      closeText : 'Close',
      // Widget extend link text
      extendText : 'Extend',
      // Widget collapse link text
      collapseText : 'Collapse',
      // Widget cancel edit link text
      cancelEditText : 'Cancel',
      // Widget edition link title
      editTitle : 'Edit this widget',
      // Widget close link title
      closeTitle : 'Close this widget',
      // Widget confirmation dialog message
      confirmMsg : 'Remove this widget?',
      // Widget cancel edit link title
      cancelEditTitle : 'Cancel edition',
      // Widget extend link title
      extendTitle : 'Extend this widget',
      // Widget collapse link title
      collapseTitle : 'Collapse this widget'
    }
  };

  /**
   * Private members of the plugin
   */

  /**
   * Auxiliar function to prepare Widgets header menu links.
   *
   * @access private
   * @param text Link text
   * @param title Link title
   * @param aClass CSS class (behaviour) of link
   * @return String HTML of the link
   */
  function WidgetMenuLink(text, title, aClass){
    var link = '<a href="#" title="TITLE" class="CLASS">TEXT</a>';
    link = link.replace(/TEXT/g, text);
    link = link.replace(/TITLE/g, title);
    link = link.replace(/CLASS/g, aClass.replace(/\./, ''));
    return link;
  }

  /**
   * Auxiliar function to show, hide and apply effects.
   *
   * @access private
   * @param jqObj jQuery object to apply the effect and show or hide
   * @param effect String that identifier what effect must be applied
   * @param duration Miliseconds to the effect duration
   * @param show Boolean True if want to show the object, False to be hide
   * @return Boolean True in every case
   */
  function ApplyEffect(jqObj, effect, duration, show){
    var n = 'none', f = 'fade', s = 'slide';
    if(!show){
      if(effect == n){
        jqObj.hide();
      }else if(effect == f){
        jqObj.fadeOut(duration);
      }else if(effect == s){
        jqObj.slideUp(duration);
      }
    }else{
      if(effect == n){
        jqObj.show();
      }else if(effect == f){
        jqObj.fadeIn(duration);
      }else if(effect == s){
        jqObj.slideDown(duration);
      }
    }
    return true;
  }

})(jQuery);
