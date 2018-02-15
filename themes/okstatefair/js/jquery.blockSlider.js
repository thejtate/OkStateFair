(function($) {
  var $window = $(window);

  $.fn.blockSlider = function(options) {
    options = $.extend({
      timeout: 5000,
      autoshow: true,
      pagerVisible: true,
      startSlide: 0
    }, options);

    return this.each(function() {
      var $wrapper = $(this),
        $slides = $wrapper.find('[data-role="block_slider_slides"] li'),
        $pagerItems = $wrapper.find('[data-role="block_slider_pager"] li'),
        curSlide = options.startSlide,
        numOfSlides = $slides.length,
        timerId = false;

      function init() {
        curSlide = options.startSlide;

        $('.block-slider-pager')[options.pagerVisible ? 'show' : 'hide']();

        showSlide(curSlide);

        if(options.autoshow) {
          autoshow(true);
        }

        $pagerItems.on('click.blockSlider', onPagerItemClick);
        $wrapper.on('mouseover.blockSlider', onMouseOver);
        $wrapper.on('mouseout.blockSlider', onMouseOut);
      };

      function showSlide(index) {
        if(index > numOfSlides - 1) {
          curSlide = 0;
        } else if(index < 0) {
          curSlide = numOfSlides - 1;
        } else {
          curSlide = index;
        }

        $pagerItems.removeClass('active');
        $pagerItems.eq(curSlide).addClass('active');

        $slides.fadeOut(700, function() {
          $(this).removeClass('active');
        });
        $slides.eq(curSlide).fadeIn(700, function() {
          $(this).addClass('active');
        });
      };

      function autoshow(is) {
        if(is) {
          timerId = setInterval(function() {
            showSlide(++curSlide);
          }, options.timeout);
        } else {
          clearInterval(timerId);
        }
      };

      function onPagerItemClick(e) {
        e.stopPropagation();
        var index = $(this).index();
        if(index == curSlide) {
          return;
        }
        showSlide(index);
      };

      function onMouseOver() {
        autoshow(false);
      };

      function onMouseOut() {
        if(timerId != false) {
          autoshow(true);
        }
      };

      init();
    });
  };
})(jQuery);