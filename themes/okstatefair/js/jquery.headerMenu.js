(function($) {
  var $window = $(window);

  $.fn.headerMenu = function(options) {
    options = $.extend({
      className: 'opened',
      delay: 500
    }, options);

    return this.each(function() {

      var $this = $(this),
        $items = $this.children('li'),
        $DDItems = $items.find('> .drop-down-menu ul > li'),
        timeoutID = null;

      function init() {
        if($items.length == 0) {
          return;
        }

        $items.on('mouseover', onItemOver);
        $DDItems.on('mouseover', onDDItemOver);
        $(document).on('mouseover', onDocOver);
        $this.on('mouseover', function(e) {
          e.stopPropagation();
          clearTimeout(timeoutID);
          timeoutID = null;
        });
      };

      function onItemOver(e) {
        $items.removeClass(options.className);
        $(this).addClass(options.className);
      };

      function onDDItemOver(e) {
        $DDItems.removeClass(options.className);
        $(this).addClass(options.className);
      };

      function onDocOver(e) {
        if(timeoutID == null){
          timeoutID = setTimeout(function() {
            $items.removeClass(options.className);
            $DDItems.removeClass(options.className);
          }, options.delay);
        }
      };

      init();
    });
  };
})(jQuery);