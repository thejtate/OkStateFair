/**
 * jquery carousel plugin 1.0-beta
 * By Eugene Poltorakov (http://poltorakov.com)
 * Copyright (c) 2011 eugene poltorakov
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
 
 * @param Object options 
 *        getWrapper [function] - function for finding carousel wrapper; by default: return $wrapper.find('ul:first');
 *        getPager [function] - function for finding pager; by default: return $wrapper.find('.pager');
 *        callbackInit [function] - init callback function; arguments: carousel object; default is false;
 *        callbackScroll [function] - scroll callback; call after scrolling; arguments: carousel object, previous item index; default is false;
 *        callbackBeforeScroll [function] - callback calling before scrolling; aruments: carousel object, current index; default is false;
 *        generatePager [bool] - generate pager option; It will generate only base pager, with next/prev elements; default is false;
 *        generatePagerItems [bool] - if true script will generate pager items inside pager wrapper; default is false;
 *        firstItem [int] - define first item; default is 0;
 *        size [int] - number of items showing at once; default is 1;
 *        step [int] - define scrolling step;  default is 1;
 *        round [bool] - if true carousel will scrolling in cycle, without stopping on first/last items; default is false;
 *        auto [mixed] - false or int - number of ms between automatic scrolling; default is false;
 *        type [string] - absolute|margin - type of scrolling: absolute (using left) or margin (using negative margin-left); default is 'absolute';
 *        orientation [string] - horizontal|vertical - type of carousel orientation; default is 'horizontal';
 *        adjustHeight [bool] - adjust wrapper height up to current element height;  default is false;
 *        animateDuraction [mixed] - animate duration;  default is 'normal';
 *        animateEasing [string] - animate easing; default is 'swing';
 *        textPrev [string] - text for the pager previous item; default is 'Prev';
 *        textNext [string] - text for the pager next item; default is 'Next';
 *        ajaxUrl [string] - path for loading additional elements; request will accept current offset; should return fully prepared html elements; default is false;
 *        ajaxCallback [function] - successful ajax execution callback; arguments: carousel object; default is false;
 *        ajaxCallbackError [function] - similar to ajaxCallback but calls in ajax error case;
 *        loadingClass [string] - wrapper will have this css class while loading; default is 'loading';
 *        count [int] - number of items; usefull when using ajax (to generate correct number of pager elements); default is false (count will estimated while initialization);
 */

var carousels = [];

(function ($) {
  $.fn.carous = function (options) {
    if (this.length < 1) {
      return this;
    }
    var defaults = {
      getWrapper: function($wrapper) {//first list
        return $wrapper.find('ul:first');
      },
      getPager: function($wrapper) {
        return $wrapper.find('.pager');
      },
      generatePager: false,
      generatePagerItems: false,
      callbackInit: false,
      callbackScroll: false,
      callbackBeforeScroll: false, //It's accept scrollTo position and should return new position which will be used instead of old one;
      firstItem: 0,
      size: 1,
      step: 1,
      round: true,
      auto: false,
      type: 'absolute', //absolute | margin
      orientation: 'horizontal',
      adjustHeight: false,
      animateDuration: 'normal',
      animateEasing: 'swing',
      textPrev: 'Prev',
      textNext: 'Next',
      ajaxUrl: false,
      ajaxCallback: false,
      ajaxCallbackError: false,
      loadingClass: 'loading',
      count: false
    },
    opts = $.extend(defaults, options), i;
    
    this.each(function() {
      if (typeof(this._carousel) != 'undefined') {
        return false;
      }
      var $this = $(this);
      if (typeof(this._carousel) != 'undefined') {
        return false;
      }
      this._carousel = {};
      var c = this._carousel;
      
      c.options      = opts;
      c.blocked      = false;
      c.wrapper      = $this;
      c.itemsWrapper = opts.getWrapper($this);
      c.autoTimer    = null;
      c.autoStopped  = false;
      c.autoBlocked  = false;
      c.blocked      = false;
      
      var children = c.itemsWrapper.children();
      
      if (opts.ajaxUrl) {
        opts.round = false;
        c.ajaxLoaded = children.length;
      }
      
      c.count = !opts.count ? children.length : opts.count;
      
      if (opts.generatePager) {
        //generate pager wrapper
        c.pagerWrapper = $('<ul class="pager"><li class="first">' + opts.textPrev + '</li><li class="last">' + opts.textNext + '</li></ul>');
        c.wrapper.append(c.pagerWrapper);
      }
      else if (opts.getPager) {
        c.pagerWrapper = opts.getPager($this);
      }
      else {
        c.pagerWrapper = false;
      }
      
      //calculate first item
      if (c.options.size > 1) {
        if (c.options.size > c.count) {
          c.currentItem  = opts.firstItem;
        }
        else {
          c.currentItem  = opts.firstItem + c.options.size > c.count ? c.count - c.options.size : opts.firstItem;
        }
      }
      else {
        c.currentItem  = opts.firstItem;
      }

      if (c.count <= c.options.size) {
        if (c.pagerWrapper) {
          c.pagerWrapper.hide();
        }
        //execute init callback even if carousel not initialized
        if (typeof(c.options.callbackInit) == 'function') {
          c.options.callbackInit(c);
        }
        return;
      }

      if (c.options.orientation == 'vertical') {
        c.itemHeight = c.itemsWrapper.children(':first').outerHeight(true);
        c.itemsWrapper.height(c.count * c.itemHeight);
      }
      else {//horizontal orientation
        c.itemWidth = c.itemsWrapper.children(':first').outerWidth(true);
        c.itemsWrapper.width(c.count * c.itemWidth);
      }
      
      c.itemsWrapper.get(0)._carousel = c;
      
      //prepare 
      if (c.pagerWrapper) {
        if (opts.generatePagerItems) {
          var _$first = c.pagerWrapper.find('li.first');
          if (_$first.length == 0) {
            _$first = $('<li class="first">'+ opts.textPrev +'</li>');
            c.pagerWrapper.append(_$first);
          }
          for(i = c.count-1; i >= 0; i--) {
            _$first.after($('<li><a href="javascript:;"'+ (i == c.currentItem ? 'class ="active"' : '') +'>'+ (i+1) +'</a></li>'));
          }
          if (c.pagerWrapper.find('li.last').length == 0) {
            c.pagerWrapper.append($('<li class="last">'+ opts.textNext +'</li>'));
          }
        }
        else {
          c.pagerWrapper.find('a').eq(c.currentItem).addClass('active');
        }
        
        c.pagerHasFirst = c.pagerWrapper.find('li.first').length > 0;
        
        c.pagerWrapper.find('li').each(function(index) {
          var $this = $(this);
          this._carousel = c;
          if ($this.hasClass('first')) {
            $this.click(function() {
              if ($(this).hasClass('disabled')) {
                return false;
              }
              this._carousel.scrollPrev();
            });
          }
          else if ($this.hasClass('last')) {
            $this.click(function() {
              if ($(this).hasClass('disabled')) {
                return false;
              }
              this._carousel.scrollNext();
            });
          }
          else {
            $this.children('a:first').click(function() {
              var c = this.parentNode._carousel;
              c.scroll(index - (c.pagerHasFirst ? 1 : 0));
              return false;
            });
          }
        });
      }
      
      //assign methods
      c.scrollPrev = function() {
        if (this.blocked) {
          return;
        }
        var scrollTo = null;
        if (this.currentItem == 0) {
          scrollTo = this.count - this.options.step;
        }
        else if (this.currentItem > this.options.step) {
          scrollTo = this.currentItem - this.options.step;
        }
        else {
          scrollTo = 0;
        }
        this.scroll(scrollTo);
      };
      c.scrollNext = function() {
        if (this.blocked) {
          return;
        }
        var self = this,
            scrollTo = this.currentItem == (this.count - 1) ? 0 : this.currentItem + this.options.step;
            
        if (this.options.ajaxUrl && this.currentItem >= this.ajaxLoaded - 1) {
          self.blocked = true;
          self.itemsWrapper.addClass(self.options.loadingClass);
          $.ajax({
            url: self.options.ajaxUrl,
            data: {
              offset: self.ajaxLoaded
            },
            dataType: 'html',
            success: function(html) {
              self.itemsWrapper.append(html);
              self.ajaxLoaded = self.itemsWrapper.children().length;
              self.itemsWrapper.removeClass(self.options.loadingClass);
              self.blocked = false;
              self.scroll(scrollTo);
              if (typeof(self.options.ajaxCallback) == 'function') {
                self.options.ajaxCallback(self);
              }
            },
            error: function() {
              self.itemsWrapper.removeClass(self.options.loadingClass);
              self.blocked = false;
              if (typeof(self.options.ajaxCallbackError) == 'function') {
                self.options.ajaxCallbackError(self);
              }
            }
          });
        }
        else {
          this.scroll(scrollTo);
        }
      };
      c.scrollFirst = function() {
        this.scroll(0);
      };
      c.scrollLast = function() {
        this.scroll(this.count - 1);
      };
      c.scroll = function(i, speed) {
        if (this.blocked) {
          return;
        }
        var _previous = this.currentItem;
        
        speed = typeof(speed) == 'undefined' ? this.options.animateDuraction : parseInt(speed);
        
        if (typeof(this.options.callbackBeforeScroll) == 'function') {
          i = this.options.callbackBeforeScroll(this, i);
        }
        
        if (this.blocked) {
          return false;
        }
        if (this.count <= this.options.size) {
          return false;
        }
        
        if (i > (this.count - 1)) {
          i = 0;
        }
        if (i < 0) {
          i = this.count - 1 + i;
        }
        
        this.currentItem = i;
        
        if (this.options.size > 1 && this.options.size > this.count - i) {
          i = this.count - this.options.size;
        }
        
        this.blocked = true;//block carousel
        
        var animate_opts = {},
            animated_obj = this.itemsWrapper;
        
        if (this.options.orientation == 'vertical') {
          if (this.options.type == 'margin') {
            animate_opts.marginTop = -1 * (this.itemHeight * i);
          }
          else {//type = absolute
            animate_opts.top = -1 * (this.itemHeight * i);
          }
        }
        else {
          if (this.options.type == 'margin') {
            animate_opts.marginLeft = -1 * (this.itemWidth * i);
          }
          else {//type = absolute
            animate_opts.left = -1 * (this.itemWidth * i);
          }
        }
        
        //adjust height
        if (this.options.adjustHeight) {
          var $curElement = this.itemsWrapper.children().eq(i),
              height      = 0,
              eHeight     = $curElement.data('elementHeight');
          
          if (typeof(eHeight) == 'undefined') {
            height = $curElement.height();
            $curElement.data('elementHeight', height);
          }
          else {
            height = eHeight;
          }
          animate_opts.height = height;
        }
        
        animated_obj.animate(animate_opts, speed, this.options.animateEasing , function() {
          var c = this._carousel;
          
          c.blocked = false;//unblock carousel
          
          if (c.pagerWrapper) {
            var pagerLinks = c.pagerWrapper.find('a');
            
            pagerLinks.filter('.active').removeClass('active');
            pagerLinks.eq(i).addClass('active');
            
            //update pager
            if (!c.options.round) {
              var $first = c.pagerWrapper.find('.first'),
                  $last  = c.pagerWrapper.find('.last');
                  
              if (c.currentItem + c.options.size >= c.count) {
                $last.addClass('disabled');
              }
              else {
                $last.removeClass('disabled');
              }
              
              //if (c.currentItem < c.options.step) {
              if (c.currentItem == 0) {
                $first.addClass('disabled');
              }
              else {
                $first.removeClass('disabled');
              }
            }
          }
          if (typeof(c.options.callbackScroll) == 'function') {
            c.options.callbackScroll(c, _previous);
          }
        });
      };
      c.initAuto = function() {
        if (this.options.auto && this.options.round) {
          this.startAuto();
          
          var self = this,
              stopItems = this.itemsWrapper;
          
          if (this.pagerWrapper) {
            stopItems = stopItems.add(this.pagerWrapper);
          }
          stopItems.hover(function(){
            self.stopAuto();
          }, function(){
            self.startAuto();
          });
        }
      };
      c.startAuto = function() {
        var self = this;
        
        this.autoTimer = setInterval(function() {
          if (!self.autoBlocked) {
            self.scrollNext();
          }
        }, this.options.auto);
      };
      c.stopAuto = function() {
        clearInterval(this.autoTimer);
      };
      c.blockAuto = function() {
        this.autoBlocked = true;
        //this.stopAuto();
      };
      c.unblockAuto = function() {
        this.autoBlocked = false;
        //this.startAuto();
      };
      
      c.scroll(c.currentItem, 0);

      if (typeof(c.options.callbackInit) == 'function') {
        c.options.callbackInit(c);
      }
      
      if (c.options.auto && c.options.round) {
        c.initAuto();
      }
      
      carousels[carousels.length] = c;
    });
    
    return this;
  };
})(jQuery);
