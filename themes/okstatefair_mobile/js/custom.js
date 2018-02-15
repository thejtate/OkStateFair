(function($){
    Drupal.behaviors.clickOnImageLoader = {
        'attach': function(context, settings){
            $('.share-wrapper a.link-where').click(function(){
                var link = $(this);
                if(link.find('.img-loader').length == 0){
                    link.append('<span class="img-loader">loading...</span>');
                }
                var img = $("<img />").attr('src', $(this).attr('href')).load(function() {
                    if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
                        //alert('broken image!');
                    } else {
                        link.find('.img-loader').remove();
                        if(link.find('.img-data').length == 0){
                            link.append('<span class="img-data"></span>');
                            link.find('.img-data').html(img);
                        }
                    }
                });
                return false;
            });
            $('.share-wrapper a.link-where').toggle(function(){
                $(this).find('.img-data').css('display', 'block');
            },function(){
                $(this).find('.img-data').css('display', 'none');
            });

        }
    }
    Drupal.behaviors.scrollToPositionSFCalendar = {
        'attach': function(context, settings){
            sameAsBigDay = new Date();
            var height_to_scroll = 99999;
            $('.view-id-mobile_state_fair_calendar .view-grouping .nav-date-title').each(function(){
                var id = $(this).attr('id');
                if(id === "undefined" &&  id.length > 0){
                    var $this = $(this)
                    var re = /\s*-\s*/
                    var time = id.split(re);
                    //find min heiht to scroll accordong time
                    if( parseInt(sameAsBigDay.getHours()) == parseInt(time[1])){
                        if( parseInt(sameAsBigDay.getMinutes()) <= parseInt(time[2])){
                            if(($this[0].offsetTop > 0) && ( height_to_scroll > $this[0].offsetTop )){
                                height_to_scroll = $this[0].offsetTop;
                            }
                            $this.addClass('event-target');
                        }
                    }
                    if( parseInt(sameAsBigDay.getHours()) < parseInt(time[1])){
                        if(($this[0].offsetTop > 0) && (height_to_scroll > $this[0].offsetTop )){
                            height_to_scroll = $this[0].offsetTop;
                        }
                        $this.addClass('event-target');
                    }
                }
            });
            setTimeout(function(){
                //$.scrollTo('.view-id-mobile_state_fair_calendar .event-target');
                if(height_to_scroll != 99999){
                    $.scrollTo(height_to_scroll);
                }
            }, 1000);
        }
    }
    Drupal.behaviors.scrollToPositionSFPCalendar = {
        'attach': function(context, settings){
            setTimeout(function(){
                $.scrollTo('.view-state-fair-park-calendar .event-target');
            }, 1000);
        }
    }

    //agenda opener
    var $window = $(window);
    $.fn.opener = function(options) {
        options = $.extend({
            className: 'open',
            content: '.content-agenta',
            btns: null,
            isAdded: false,
            isOutsideClick: true
        }, options);

        return this.each(function() {
            var $this = $(this);
            function init() {
                $this[options.isAdded ? 'addClass' : 'removeClass'](options.className);
                options.btns = $(options.btns);
                options.content = $(options.content);

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
                options.content.toggleClass(options.className);
                options.btns.toggleClass(options.className);
            };

            function onClickOutside(e) {
                var target = e.target || e.srcElement;
                if($(target).data('opener') != 'allow-propagation') {
                    options.content.removeClass(options.className);
                    options.btns.removeClass(options.className);
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

    $(document).ready(function() {
        $('.agenta-wrapper').opener({
            className: 'active',
            content: '.content-agenta',
            btns: '.agenta-wrapper .btn-menu-agenta'
        });
        
//        $('.page-food_finder .btn-item').live('click', function () {
//          $(this).parents('.structs-btn-wrapper').hide();
//          $('body').removeClass('page-food_finder');
//          $('.structs-nav-wrapper').find('.' + $(this).attr('id')).find('a').removeClass('active')
//          var $replace = $('.structs-nav-wrapper').find('.' + $(this).attr('id')).show().html();
//          $(this).parents('.structs-wrapper').html($replace);
//          
//        });
        
    });

})(jQuery);