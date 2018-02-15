(function($){

  Drupal.behaviors.okstatefair_custom_newsletter = {
    attach: function(context, settings) {
      if ($('#modalContent')){
          $('.popups-close').on( "click", function() {
              window.location.reload(true);
          });
      }
    }
  }

})(jQuery);
