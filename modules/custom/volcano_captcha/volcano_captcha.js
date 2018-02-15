(function ($) {

    Drupal.behaviors.captchaVolcano = {
        attach: function (context) {
            $.ajax({
                url: '/getcaptchavalue',
                success: function(data) {
                    eval('salt    = "m t!p76Y/1+350k";');
                    eval('salt2   = "9X|!5)]m#|,1/cb";');
                    eval('$(\'[name="hidden_item"]\').val($.md5(data.data+salt));');
                    eval('$(\'[name="human_token"]\').val($.md5(document.location.hostname+salt2));');
                }
            });
        }
    };

})(jQuery);