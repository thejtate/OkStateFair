(function($) {
  var $window = $(window);

  $.fn.navMenu = function(options) {
    options = $.extend({
      className: 'active'
    }, options);

    return this.each(function() {
      var $this = $(this), $btn = $this.children('.btn'), isOpened = $this.hasClass(options.className);

      function init() {
        $btn.on('click.navMenu', onClick);
      };

      function onClick(e) {
        e.preventDefault();

        if(isOpened) {
          $this.children('ul').slideUp(200, function() {
            $this.removeClass(options.className);
          });
        } else {
          $this.children('ul').slideDown(200, function() {
            $this.addClass(options.className);
          });
        }

        isOpened = !isOpened;
      };

      init();
    });
  };
})(jQuery);