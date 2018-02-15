/**
 * Created with JetBrains PhpStorm.
 * User: alexandrilivanov
 * Date: 27.05.13
 * Time: 09:33
 * To change this template use File | Settings | File Templates.
 */
(function($) {

    /**
     * Attach the ajax behavior to each link.
     */
    Drupal.views.ajaxView.prototype.attachPagerAjax = function() {
        //add ajax to custom link on calendar
        this.$view.find('ul.pager > li > a, th.views-field a, .attachment .views-summary a, .view-state-fair-park-calendar a.btn-prev, .view-state-fair-park-calendar a.btn-next')
            .each(jQuery.proxy(this.attachPagerLinkAjax, this));
    };


})(jQuery);