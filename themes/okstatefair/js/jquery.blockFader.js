(function($) {
  var $window = $(window);

  $.fn.blockFader = function(options) {
    options = $.extend({
      timeout: 2000,
      duration: 2100,
      opacity: 0.4
    }, options);

    return this.each(function() {
      var $this = $(this),
        $items = $this.find('li'),
        numOfItems = $items.length,
        dir = 1,
        cur = 0;

      function init() {
        if($items.length == 0) {
          return;
        }

        $items.css(getPrefix() + 'transition', 'opacity ' + options.duration + 'ms');
        $items.css('opacity', options.opacity);

        setInterval(function(self) {
          $items.css('opacity', options.opacity);
          $items.eq(cur).css('opacity', 1);

          if(cur == 0) {
            dir = 1;
          } else if (cur == (numOfItems - 1)) {
            dir = -1;
          }

          cur+=dir;
        }, options.timeout, this)

      };

      init();
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