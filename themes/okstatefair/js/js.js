(function ($) {
  $(function () {
    initContent();
    init_uniform();
    init_scroll_pane();
    init_select();
    init_gallery();
    init_onFocusField();
    init_slider();
    init_accordion();
    init_sidebar();
    init_comments();
    init_countDown();
    initFlexslider();
    initHeaderOsDetect();

    if(ie_lessthan(10)) {
      init_watermark();
    }
  });

  $(window).on('load', function() {
    initFlexsliderGallery();
    initSidebarNav();
  });

  function initHeaderOsDetect(){
    var mac = navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i) ? true : false;
    var isWebkit = 'WebkitAppearance' in document.documentElement.style;

    if(isWebkit) {
      $('html').addClass('webkit');
    }

    if (mac) {
      $('html').addClass('macos');
    }
  }

  function initContent() {
    var $wrappers = $('.content-wrapper');

    if ($('.navigation-sidebar').length && $wrappers.length) {
      $wrappers.css('opacity', 0);
    }
  }

  function initSidebarNav() {
    var $menu = $('.navigation-sidebar');
    var $wrappers = $('.content-wrapper');

    if ($menu.length && $wrappers.length) {
      var sidebarHeight = $menu.innerHeight() + 30;
      var counter = 0;

      for (var i = 0; i < $wrappers.length; i++) {
        counter += $wrappers.eq(i).innerHeight();

        $wrappers.eq(i)
          .addClass('clearfix')
          .wrapInner('<div class="width-600-right" />')
          .css('opacity', 1);

        if ($wrappers.length == 1) {
          $wrappers.css('minHeight', sidebarHeight);
        }

        if(counter >= sidebarHeight) {
          $wrappers.css('opacity', 1);
          break;
        }
      }
    }
  }

  function initFlexslider() {
    $('.flexslider').not('.flexslider-gallery, .flexslider-carousel').flexslider({
      animation: 'slide',
      directionNav: false
    });
  }

  function initFlexsliderGallery() {
    $('.gallery-wrapper').each(function() {
      var $this = $(this),
        $carousel = $this.find('.flexslider-carousel'),
        $gallery = $this.find('.flexslider-gallery');

      $carousel.flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        itemWidth: 76,
        itemMargin: 7,
        keyboard: false,
        asNavFor: $gallery
      });

      $gallery.flexslider({
        animation: "fade",
        controlNav: false,
        directionNav: false,
        animationLoop: false,
        keyboard: false,
        sync: $carousel
      });
    });
  }

  function init_countDown() {
    var time;

    if (typeof Drupal == 'undefined') {
      time = (new Date()).getTime() + 10*24*60*60*1000;
    } else {
      time = Drupal.settings.okstatefair.fair_open; //'2016/03/12';
    }

    $('#countdown .countdown-inner').countdown(time, function(event) {
      $(this).html(event.strftime(
//        '<span class="countdown-hd-title">%w<span class="countdown-ft-title">weeks</span></span>' +
//      '<span class="countdown-hd-title">%w<span class="countdown-ft-title">weeks</span></span>' +
      '<span class="countdown-hd-title">%D<span class="countdown-ft-title">days</span></span>' +
      '<span class="countdown-hd-title">%H<span class="countdown-ft-title">hours</span></span>' +
      '<span class="countdown-hd-title">%M<span class="countdown-ft-title">MINUTES</span></span>' +
      '<span class="countdown-hd-title">%S<span class="countdown-ft-title">SECONDS</span></span>'));
    });
  }

  function ie_lessthan(v) {
    if (v == 8) {
      return typeof(window.localStorage) == 'undefined';
    }
    return jQuery.browser.msie && jQuery.browser.version.match(/^\d+/)[0] < v;
  }

  function ie_equal(v) {
    if (!jQuery.browser.msie) {
      return false;
    }
    var current = jQuery.browser.version.match(/^\d+/)[0];

    if (current == 7) {
      if (v == 8) {
        return typeof(window.localStorage) == 'object';
      }
      else if (v == 7) {
        return typeof(window.localStorage) == 'undefined';
      }
    }
    return jQuery.browser.version.match(/^\d+/)[0] == v;
  }

  function init_watermark() {
    $(".form-ticket-popup").find("input[type=text], textarea").not('.watermark-processed').watermark().addClass('watermark-processed');
  }

  function init_uniform() {
    $("input:checkbox, input:radio").uniform();
  };

  function init_scroll_pane() {
    $('.content-agenta, .bottom-filter .filter .widget').jScrollPane();
  };
  function init_select() {
    $('.select-wrapp .form-select, .form-select-food .form-select').combobox({
      btnWidth: 68,
      hoverEnabled: true,

      listMaxHeight: 420,
      forceScroll: true

    });


//    setTimeout(function () {
//
//      var $selects = $('.select-wrapp .form-select').not('.skip-js').each(function () {
//        var $select = $(this),
//          options = {
//            btnWidth: 68,
//            hoverEnabled: true,
//            listMaxHeight: 420,
//            forceScroll: true
//          };
//        $select.bind('combo_init',function () {
//          //do something here
//        }).combobox(options);
//      });
//    }, 50);
  };
  function init_gallery(){
    $(".gallery-list").PikaChoose({carousel:true});
  };

  function init_onFocusField() {
    $(".error-item").find("input").live("focusout", function() {
      $(this).parent().removeClass("error-item").find(".tooltip-error").hide();
    });
    $(".error-item").find("textarea").live("focusout", function() {
      $(this).parent().parent().removeClass("error-item").find(".tooltip-error").hide();
    });
  }

  var init_slider = function(){
    var slider = {
      init: function(){
        var $sl = $(".slider-wrapper-coupon .slider");
        if($sl.length > 0) {
          wrap = $sl;
          slider.width = 0;
          slider.active = 0;
          slider.count = 0;
          slider.addWrapper();
          slider.addClasses(); 
          wrap.sliderWrapper = wrap.find(".slider-wrapper");
          wrap.sliderList = wrap.find(".slider-list");
          wrap.sliderItem = wrap.find(".slider-item");
          slider.widthSlides();
          slider.addStyle();
          wrap.sliderList.positionLeft = wrap.sliderList.position().left;
          slider.addPager();
          slider.addPager2();
          slider.slideActive();
        }
      },
      addWrapper: function() {
        wrap.children().wrap("<div class='slider-wrapper' />");
      },
      addClasses: function() {
        wrap.find(".slider-wrapper").children().addClass("slider-list").children().addClass("slider-item");
      },
      widthSlides: function() {
        wrap.sliderItem.each(function() {
          var $this = $(this);
          slider.width += $this.width();
          slider.count += 1;
        });
        slider.count -= 1;
      },
      addStyle: function() {
        wrap.css({
          position: "relative",
          display: "block"
        });
        wrap.sliderWrapper.css({
          position: "relative"
        });
        wrap.sliderList.css({
          left: 0,
          top: 0,
          margin: 0,
          padding: 0,
          overflow: "hidden",
          position: "relative",
          width: slider.width
        });
        wrap.sliderItem.css({
          float: "left",
          listStyleType: "none"
        });
      },
      addPager: function() {
        wrap.append("<div class='pager-prev' />");
        wrap.append("<div class='pager-next' />");
        slider.pagerClick();
      },
      pagerClick: function() {
        wrap.find(".pager-prev").click(function() {
          if(slider.active !== 0) {
            slider.active--;
            slider.slideActive();
            var $thisW = wrap.sliderItem.eq(slider.active).width();
            wrap.sliderList.positionLeft += $thisW;
            slider.slideAnimateBack();
          }
        });
        wrap.find(".pager-next").click(function() {
          if(slider.active < slider.count) {
            slider.active++;
            slider.slideActive();
            var $thisW = wrap.sliderItem.eq(slider.active).width();
            wrap.sliderList.positionLeft -= $thisW;
            slider.slideAnimateForward();
          }
        });
      },
      addPager2: function() {
        wrap.parent().append("<div class='pager' />");
        wrap.parent().find(".pager").append("<div class='first'><a href='#'>First Page</a></div>");
        wrap.parent().find(".pager").append("<div class='last'><a href='#'>Last Page</a></div>");
        slider.pager2Click();
      },
      pager2Click: function() {
        wrap.parent().find(".pager .first a").click(function(e) {
          e.preventDefault();
          if(slider.active !== 0) {
            slider.active = 0;
            slider.slideActive();
            wrap.sliderList.positionLeft = 0;
            slider.slideAnimateBack();
          }
        });
        wrap.parent().find(".pager .last a").click(function(e) {
          e.preventDefault();
          if(slider.active < slider.count) {
            slider.active = slider.count;
            slider.slideActive();
            wrap.sliderList.positionLeft = wrap.sliderItem.eq(-1).width() - slider.width;
            slider.slideAnimateForward();
          }
        });
      },
      slideAnimateBack: function() {
        wrap.sliderList.animate({
          left: wrap.sliderList.positionLeft
        }, 500);
      },
      slideAnimateForward: function() {
        wrap.sliderList.animate({
          left: wrap.sliderList.positionLeft
        }, 500);
      },
      slideActive: function() {
        wrap.sliderItem.removeClass("active").eq(slider.active).addClass("active");
      }
    };

    slider.init();
  }

  var init_accordion = function() {
    var $wrapper = $('.item-list .dropdown');
    $wrapper.find('> li a').click(function () {
      var $this = $(this);
      if (!$this.hasClass('active')) {
        $this.addClass('active');
        $this.find('.close').addClass('open').removeClass('close');
        $this.parent().addClass('active');
      }
      else {
        $this.removeClass('active');
        $this.find('.open').addClass('close').removeClass('open');
        $this.parent().removeClass('active');
      }
    });
  }

  var init_sidebar = function() {
    var sidebar = {
      init: function(){
        wrapp = $('.view-content');
        if(wrapp.length > 0) {
          stateZoom = 0;
          leftFilter = wrapp.find('.left-filter');
          view = wrapp.find('.view');
          sidebar.initScrollPane();
          sidebar.addActiveItem();
          sidebar.bootstrapShowImg();
          sidebar.showImgBigOrSmall();
        }
      },
      initScrollPane: function() {
        leftFilter.find('> ul').jScrollPane();
      },
      addActiveItem: function() {
        leftFilter.find('li > a').click(function(e) {
          e.preventDefault();
          var $this = $(this),
              $src = 'images/tmp/_tmp_image-foodfinder.jpg';
          if(typeof(Drupal) != 'undefined') {
            $src = Drupal.settings.pathToTheme + '/' + $src;
          }
          if($this.parent().hasClass('active')) {
            $this.parent().removeClass('active');
            view.find('.title').show();
            view.find('.btn-zoom').hide();
            sidebar.initScrollPane();
            sidebar.showImg($src);
          }
          else {
            leftFilter.find('.active').removeClass('active');
            $this.parent().addClass('active');
            var $img = $this.parent().find('.img-narrow img');
            if($img.length > 0) {
              $src = $img.attr('src');
              view.find('.btn-zoom').show();
            }
            else {
              view.find('.btn-zoom').hide();
            }
            view.find('.title').hide();
            sidebar.initScrollPane();
            sidebar.showImg($src);
          }
        });
      },
      bootstrapShowImg: function() {
        leftFilter.find('li').each(function() {
          var $this = $(this);
          if($this.hasClass('active')) {
            var $src = $this.find('.images .img-narrow img').attr('src');
            view.find('img').attr('src', $src);
          }
        });
      },
      showImg: function(src) {
        view.find('img').attr('src', src);
      },
      showImgBigOrSmall: function() {
        view.find('.btn-zoom').click(function(e) {
          e.preventDefault();
          var $this = $(this);
          if(stateZoom == 0){
            stateZoom = 1;
            var $src = $this.parent().parent().parent().find('ul .active .images .img-large img').attr('src');
            sidebar.showImg($src);
            view.find('.btn-zoom').hide();
            view.find('.btn-close').show();
            sidebar.hideSidebar();
          }
        });
        view.find('.btn-close').click(function() {
          var $this = $(this);
          if(stateZoom == 1){
            stateZoom = 0;
            var $src = $this.parent().parent().parent().find('ul .active .images .img-narrow img').attr('src');
            sidebar.showImg($src);
            view.find('.btn-zoom').show();
            view.find('.btn-close').hide();
            sidebar.showSidebar();
          }
        });
      },
      hideSidebar: function() {
        leftFilter.parent().removeClass('with-sidebar');
      },
      showSidebar: function() {
        leftFilter.parent().addClass('with-sidebar');
      }
    }

    sidebar.init();
  }

  function init_comments(){
    if($('.page-type-blog .media_response .link-comments').length > 0) {
      var $wrap = $('.page-type-blog'),
          $btn = $wrap.find('.media_response .link-comments');
      $btn.click(function(e) {
        e.preventDefault();
        var $content = $(this).parent().parent().parent();
        if($content.find('.block-comments').hasClass('collapsed')) {
          $content.find('.block-comments').removeClass('collapsed');
        }
        else {
          $content.find('.block-comments').addClass('collapsed');
        }
      });
    }
  }

})(jQuery);