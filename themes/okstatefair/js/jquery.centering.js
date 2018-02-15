(function ($) {

  jQuery.fn.centering = function(options){

    var options = jQuery.extend({
      el: this
    }, options);

    return this.each(function() {
      var $elW = options.el.outerWidth();
      options.el.css({
        left: "50%",
        marginLeft: "-" + $elW/2 + "px"
      });
    });
  }

})(jQuery);