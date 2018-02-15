(function($) {
  $(document).ready(function() {

    if ($.fn.pageSlider) {
      $('.page-slider').pageSlider();
    };

    if ($.fn.blockSlider) {
      $('.block-slider[data-control="block_slider"]').blockSlider({
        timeout: 4000
      });

      $('.block-buttons-full *[data-control="block_slider"]').blockSlider({
        timeout: 3500
      });
    };

    if ($.fn.videoReaction) {
      $('.interactive-video-container').videoReaction();
    };

    if ($.fn.cellCalendar) {
      $('.calendar-cell').cellCalendar();
    };

    if ($.fn.topButtons) {
      $('.top-buttons').topButtons();
    };

    if ($.fn.blockSliderMover) {
      $('[data-control="block_slider_mover"]').blockSliderMover();
    };

    if ($.fn.blockSliderFader) {
      $('[data-control="block_slider_fader"]').blockSliderFader();
    };

    if ($.fn.opener) {
      $('.my-agenda').opener({
        className: 'active-agenda',
        btns: '.my-agenda .icon-agenta'
      });
    };

    if ($.fn.navMenu) {
      $('.navigation-sidebar .menu .dropdown').navMenu({
        className: 'active'
      });
    };

    if ($.fn.headerMenu) {
      $('.header .navigation .menu').headerMenu({});
    };

    if ($.fn.blockFader && $('.footer-type-1 .icons').length > 0) {
      $('.footer-type-1 .icons').blockFader({
        timeout : 2000,
        duration: 2100,
        opacity : 0.4
      });
    };

    if($('[data-role="full-page"]').length > 0) {
      var $full = $('[data-role="full-page"]');
      $full.height($(window).height());
      //$full.css('min-height', $(window).height());
      $(window).on('resize', function() {
        $full.height($(window).height());
        //$full.css('min-height', $(window).height());
      });
    };
  });
})(jQuery);