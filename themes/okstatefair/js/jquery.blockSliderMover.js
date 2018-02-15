(function($) {
  var $window = $(window);

  $.fn.blockSliderMover = function(options) {
    options = $.extend({
      duration: 6000
     }, options);

    return this.each(function() {
      var $wrapper = $(this),
        $tape = $wrapper.find('[data-role="block_slider_mover_slides"]'),
        $items = null,
        numOfItems = $tape.find('li').length,
        wrapperWidth = $wrapper.width(),
        tapeWidth = null,
        curItem = 0,
        d = options.duration * numOfItems;

      function init() {
        mixItems();

        $items = $wrapper.find('[data-role="block_slider_mover_slides"] li');

        if($items.length == 0) {
          return;
        }

        $items.each(function(i, el) {
          tapeWidth += $(el).outerWidth(true);
        });

        $tape.width(tapeWidth);

        $tape.css({
          left: wrapperWidth,
          position: 'absolute'
        });

        $tape.css('opacity', 1);

        move();
      };

      function move() {
        $tape.css('left', wrapperWidth);

        $tape.animate({
          left: - tapeWidth + 'px'
        }, {
          duration: options.duration * numOfItems,
          specialEasing: {
            left: 'linear'
          },
          complete: function() {
            move();
          }
        });
      };

      function mixItems() {
        var $el, m = [], i = 0;

        for(; i < numOfItems; i++) {
          $el = $tape.find('li').eq(Math.random() * (numOfItems - i));
          m.push($el);
          $el.remove();
        }

        $.each(m, function(i, el) {
          $tape.append(el);
        });
      };

      $(window).on('load', function() {
        init();
      });
    });
  };

  function getPrefix() {
    var ua = navigator.userAgent, name = '';

    if (ua.search(/MSIE/) >= 0) {
      name = '-ms-';
    } else if (ua.search(/Firefox/) >= 0) {
      name = '-moz-';
    } else if (ua.search(/Opera/) >= 0) {
      name = '-o-';
    } else if (ua.search(/Chrome/) >= 0) {
      name = '-webkit-';
    } else if (ua.search(/Safari/) >= 0) {
      name = '-webkit-';
    }

    return name;
  }
})(jQuery);