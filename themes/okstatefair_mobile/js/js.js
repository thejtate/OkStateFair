(function ($) {
  $(function () {
    init_navigation();
    //init_agenta();
    init_slider();
    init_nav_dropdown_top();
    init_nav_dropdown_bottom();
    //initFlexslider();
  });

  $(window).load(function() {
    initStructsBtnWrap();
    initFlexslider();
  });

  function init_navigation() {
    var $menu = $('.menu'),
      $menulink = $('.btn-menu-heading');

    $menulink.click(function () {
      $menulink.toggleClass('active');
      $menu.toggleClass('active');
      return false;
    });
  };

  function initStructsBtnWrap() {
    var $wrapper = $('.structs-btn-wrapper');

    if(!$wrapper.length) return false;

    var $wrapperH = $wrapper.height(),
      $headerH = $('.header').height(),
      $footerH = $('.footer').height(),
      $prevItem = $wrapper.prev(),
      $height = $(window).height() - $headerH - $footerH,
      $checkedHeight = $wrapperH + $headerH + $footerH,
      $children = $wrapper.children(),
      $childH = $children.first().height();

    if($prevItem.length) {
      var $prevItemHeight = $prevItem.outerHeight();

      $height -= $prevItemHeight;
      $checkedHeight += $prevItemHeight;
    }

    setHeight();
    $(window).on('resize', setHeight);

    function setHeight() {
      if($checkedHeight <= $(window).height()) {
        $wrapper.height($height);
        if($children.first().hasClass('btn-item-min')) {
          $children.height(200/$children.length + '%');
        } else {
          $children.height(100/$children.length + '%');
        }
      } else {
        $wrapper.height('auto');
        $children.height($childH);
      }
    }
  }

  function initFlexslider() {
    $('.flexslider').flexslider({
      animation: 'slide',
      directionNav: false
    });
  }

  function init_agenta() {
    var $menu = $('.content-agenta'),
      $menulink = $('.btn-menu-agenta');

    $menulink.click(function () {
      $menulink.toggleClass('active');
      $menu.toggleClass('active');
      init_scroll();
      return false;
    });
  };
  function init_nav_dropdown_top() {
    var $menu = $('.nav-top .nav-dropdown-inner'),
      $menulink = $('.nav-top .btn-dropdown');

    $menulink.click(function () {
      $menulink.toggleClass('active');
      $menu.toggleClass('active');
      return false;
    });
  };
  function init_nav_dropdown_bottom() {
    var $menu = $('.nav-bottom .nav-dropdown-inner'),
      $menulink = $('.nav-bottom .btn-dropdown');

    $menulink.click(function () {
      $menulink.toggleClass('active');
      $menu.toggleClass('active');
      return false;
    });
  };
  function init_slider() {
    $(window).load(function () {
      $('.flexslider').not('.carousel-processed').flexslider({
        animation: "slide",
        start: function (slider) {
          $('body').removeClass('loading');
        }
      }).addClass('carousel-processed');
    });
  };
  function init_scroll() {
    $('.menu-agenta').jScroll({
      scrollbarClass: 'scroll-agenta-vertical'
    });
  };
})(jQuery);
