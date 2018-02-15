(function($) {
  var $window = $(window);

  $.fn.topButtons = function(options) {
    options = $.extend({

    }, options);

    return this.each(function() {

      var $this = $(this),
        $btnSearch = $this.find('.btn-search .btn');

      function init() {
        $this.on('click', onWrapperClick);
        $btnSearch.on('click', onBtnSearchClick);
        $(document).on('click', onClickOutside);
      };

      function onWrapperClick(e) {
        e.stopPropagation();
      };

      function onBtnSearchClick(e) {
        $this.toggleClass('search-visible');
      };

      function onClickOutside(e) {
        $this.removeClass('search-visible');
      };

      init();
    });
  };
})(jQuery);