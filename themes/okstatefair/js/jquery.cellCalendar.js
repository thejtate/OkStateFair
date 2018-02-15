(function($) {
  var $window = $(window);

  $.fn.cellCalendar = function(options) {
    options = $.extend({

    }, options);

    return this.each(function() {

      var $this = $(this),
        $btnMonthMenu = $this.find('.btn-month-menu'),
        $monthMenu = $this.find('.month-menu'),
        $btnCategSelector = $this.find('.categories-selector'),
        $categList = $this.find('.categories-list'),
        $categItems = $this.find('.categories-list .list li');
        $categSelect = $this.find('.categories-select');

      function init() {
        $btnMonthMenu.on('click.cellCalendar', onBtnMonthMenuClick);
        $monthMenu.on('click.cellCalendar', onBtnMonthMenuClick);
        $btnCategSelector.on('click.cellCalendar', onBtnCategSelectorClick);
        $categItems.on('click.cellCalendar', onCategItemClick);
      };

      function onBtnMonthMenuClick(e) {
        e.stopPropagation();
        $btnMonthMenu.toggleClass('opened');
      };

      function onBtnCategSelectorClick(e) {
        e.stopPropagation();
        $btnCategSelector.toggleClass('opened');
      };

      function onCategItemClick(e) {
        e.preventDefault();
        $categItems.removeClass('selected');
        $(this).addClass('selected');
        $categSelect.find('option').removeAttr("selected");
        $this.find(".categories-select :nth-child("+ ($(this).index() +1) +")").attr("selected", "selected");
      };

      init();
    });
  };
})(jQuery);