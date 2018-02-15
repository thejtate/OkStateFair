(function ($) {

  $.fn.blockSliderFader = function (options) {
    options = $.extend({
      durationFade: 3000,
      durationVisibility: 6000
    }, options);

    return this.each(function () {
      var $this = $(this),
        $items = $this.find('li.logo'),
        numOfItems = null,
        cur = 0;

      if ($items.length <= 1) {
        return this;
      }

      numOfItems = $items.length;
      $items.hide();
      next();

      function next() {
        $items.eq(cur).fadeIn(options.durationFade, function () {
          setTimeout(function () {
            $items.eq(cur).fadeOut(options.durationFade, function () {
              cur = cur == (numOfItems - 1) ? 0 : cur + 1;
              next();
            });
          }, options.durationVisibility);
        });

      };

    });
  };
})(jQuery);