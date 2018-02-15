(function($) {
  var $window = $(window);

  $.fn.opener = function(options) {
    options = $.extend({
      className: 'open',
      btns: null,
      isAdded: false,
      isOutsideClick: true
    }, options);

    return this.each(function() {
      var $this = $(this);

      function init() {
        $this[options.isAdded ? 'addClass' : 'removeClass'](options.className);
        options.btns = $(options.btns);

        if(options.btns.length == 0) {
          options.btns = $this;
        }

        options.btns.on('click.opener', onBtnClick);

        if(options.isOutsideClick) {
          $(document).on('click.opener', onClickOutside)
        }

        $this.on('click.opener', onBlockClick);
      };

      function onBtnClick(e) {
        e.preventDefault();
        $this.toggleClass(options.className);
      };

        function onClickOutside(e) {
            var target = e.target || e.srcElement;
            if($(target).data('opener') != 'allow-propagation') {
                $this.removeClass(options.className);
            }
        };

        function onBlockClick(e) {
            var target = e.target || e.srcElement;
            if($(target).data('opener') != 'allow-propagation') {
                e.stopPropagation();
            }

        };

      init();
    });
  };
})(jQuery);