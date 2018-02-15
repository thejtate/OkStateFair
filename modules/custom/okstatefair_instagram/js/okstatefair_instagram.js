(function ($) {

    $(function(){
        var
            insta_container = $(".instagram")
            , insta_next_url
            , moreBtn = $('.instagram-more')
            , text = moreBtn.text()

        moreBtn.text('Loading…')
        insta_container.instagram({
            hash: 'okstatefair'
            , clientId : Drupal.settings.okstatefair_instagram.client_id
            , show : 24
            , onComplete : function (photos, data) {
                insta_next_url = data.pagination.next_url
                moreBtn.text(text)
            }
        })

        moreBtn.on('click', function() {
            var
                button = $(this)

            if (button.text() != 'Loading…'){
                button.text('Loading…')
                insta_container.instagram({
                    next_url : insta_next_url
                    , show : 24
                    , onComplete : function(photos, data) {
                        insta_next_url = data.pagination.next_url
                        button.text(text)
                    }
                })
            }
            return false;
        })
    });

})(jQuery);
