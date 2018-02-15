(function($) {
  var $window = $(window);

  $.fn.pageSlider = function(options) {
    options = $.extend({
      transition: 500
    }, options);

    return this.each(function() {
      var $wrapper = $(this),
        $slidesContainer = $wrapper.find('.slides'),
        $slides = $slidesContainer.find('.slide'),
        slides = {},
        winSize = {
          width  : null,
          height : null
        },
        numOfSlides = null;

      function init() {
        slides = collectSlides($slides);
        numOfSlides = $slides.length;

        $('[data-goto]').on('click.pageSlider', onBtnClick);

        $window.on('resize.pageSlider', onResize);
        onResize();

        $window.on('hashchange.pageSlider', onHashChange);

        if (!goToSlide(slides[location.hash.replace('#', '')], false)) {
          goToSlide(slides['home']);
        }
      };

      function collectSlides($elems) {
        var res = {}, buf, $el;

        $elems.each(function(index, item) {
          $el = $(item);
          buf = {};

          buf.node = $el;
          buf.nodePage = $el.find('.page');
          buf.id = $el.data('slide-id');
          buf.left = null;

          res[buf.id] = buf;
        });

        return res;
      };

      function onBtnClick(e) {
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).data('goto');
        if(!slides[id]) {
          return;
        }

        goToSlide(slides[id], true);

        location.hash = id;
      };

      function recalculate() {
        winSize.width = $window.width();
        winSize.height = $window.height();

        var i = 0;
        $.each(slides, function(index, item) {
          item.left = (-i * 100) + '%';
          i++;
        });
      };

      function onResize() {
        recalculate();

        $slidesContainer.width(winSize.width * numOfSlides + 20);
        $wrapper.css({
          width: winSize.width,
          height: winSize.height
        });

        $.each(slides, function(index, item) {
          item.node.css({
            width: winSize.width,
            height: winSize.height
          });
        });
      };

      function onHashChange() {
        var hash = location.hash.replace('#', '');

        if(slides[hash]) {
          goToSlide(slides[hash], true);
        }
      };

      function goToSlide(slide, animation) {
        if(!slide || typeof(slide) != 'object') {
          return false;
        }

        if(animation === true) {
          $slidesContainer.animate({
            left: slide.left
          }, options.transition);
        } else {
          $slidesContainer.css('left', slide.left);
        }

        $.each(slides, function(i, sld) {
          sld.node.addClass('hidden').removeClass('visible');
        });
        slide.node.addClass('visible').removeClass('hidden');

        return true;
      };

      init();
    });
  };
})(jQuery);