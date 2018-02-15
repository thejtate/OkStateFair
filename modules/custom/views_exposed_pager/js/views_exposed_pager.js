(function ($) {
    Drupal.behaviors.views_exposed_pager = {
        attach: function (context, settings) {
            $('select.views-exposed-pager').once('views-exposed-pager', function() {
                $elem = $(this);
                $elem.change(function(){
                    var $this = $(this),
                        val = $this.val(),
                        form_class = $this.data('form-class');

                    $form = $('form[data-form-class="' + form_class + '"]');
                    $exp_pager = $form.find('[name="items_per_page"]');
                    $exp_pager.val(val);
                    $form.find('.exposed-form-submit-button').click();
                })
            });
        }
    }
}(jQuery));