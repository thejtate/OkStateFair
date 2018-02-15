(function ($) {
    $(function () {
        $('.newsletter').not('golden-ticket').on( "click", function() {
            $('body').removeClass('openned-golden').addClass('openned-newsletter');
            if ($('.openned-newsletter #modalContent')){
                $('#modalContent > div > div').removeClass('golden-ticket-box').removeClass('box-golden-ticket').removeClass('popups-container').addClass('popup-newsletter');
                $("input:radio").uniform();
                $('#modalContent .form-item > .form-item').removeClass('form-item');
                $('.btn-close').click(function(e) {
                    Drupal.CTools.Modal.dismiss();
                    return false;
                });
                $('.popups-close').click(function(e) {
                    Drupal.CTools.Modal.dismiss();
                });
            }
        });
        $('.golden-ticket').on( "click", function() {
            $('body').addClass('openned-golden').removeClass('openned-newsletter');
            $('#modal-title').hide();
            $('.openned-golden #modalContent > div > div').removeClass('popup-newsletter').removeClass('popups-container').addClass('box-golden-ticket').addClass('golden-ticket-box');
        });
//        $('.golden-ticket.newsletter').on( "click", function() {
//            $('body').addClass('openned-golden').removeClass('openned-newsletter');
//            $('#modal-title').hide();
//            $('.openned-golden #modalContent > div > div').removeClass('popup-newsletter').removeClass('popups-container').addClass('box-golden-ticket').addClass('box-sorry');
//
//        });
        $('div.tabledrag-toggle-weight-wrapper').hide();

        if ($('.page-node-1540 #edit-field-sf-event-dates tbody tr').length == 2) {
            $('.page-node-1540 .field-add-more-submit').hide();
        }
        setInterval(tick, 1000);
        $('.wrapper-map .btn-print').click(function () {
            print_specific_div_content('.map');
            return false;
        });
        $('.page-type-promo .btn-print').live("click", function () {
            printDiv('printing', 'headerhead');
            return false;
        });
        $('.link-print, .btn-print-small').click(function () {
            if($(this).data('print') != 'not-default') {
                window.print();
                return false;
            }
        });
        $('.link-print-inline').click(function () {
            window.print();
            return false;
        });
        $('.btn-print-small').live("click", function () {
            // printDiv($(this).parents('.content-info-wrapper').attr("id"));
            printDiv('printing-page');
            return false;
        });
    });
    function tick() {
        if ($('.page-node-1540 #edit-field-sf-event-dates tbody tr').length == 2) {
            $('.page-node-1540 .field-add-more-submit').hide();
        }
    }

    function print_specific_div_content($class) {
        //alert("Hello world");
        var content = "";
        content += Drupal.settings.okstatefair_custom.print_css_link_map;
        content += "<div class='map-wrap' style='text-align: center;'  ><img style='height:800px;   margin: 0 auto;' src='" + Drupal.settings.okstatefair_custom.img_url + "'/></div>";
        window.frames["print_frame_map"].document.body.innerHTML = content;
        window.frames["print_frame_map"].window.focus();
        window.frames["print_frame_map"].window.print();
        return false;
    }

    function printDiv(divName, headName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContentshead = document.head.innerHTML;
        if (typeof(headName) === "undefined") {
            window.frames["print_frame"].document.head.innerHTML = originalContentshead;
        }
        window.frames["print_frame"].document.body.innerHTML = printContents;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }

    //set latest value in current just added input;
    function set_previously_value_to_next_field(selector) {
        var last_value = '';
        $(selector).each(function () {
            if ($(this).attr('value').length > 0) {
                last_value = $(this).attr('value');
            } else {
                $(this).attr('value', last_value);
            }
        });
    }

    function set_start_value_to_end_field(selector) {
        $(selector).click(function () {
            time = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sfp_event_dates_date][und][0][value][time]"]');
            date = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sfp_event_dates_date][und][0][value][date]"]');
            time2 = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sfp_event_dates_date][und][0][value2][time]"]');
            date2 = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sfp_event_dates_date][und][0][value2][date]"]');
            if (time2.length > 0 && time2.attr('value') == 0) {
                time2.attr('value', time.attr('value'));
            }
            if (date2.length > 0 && date2.attr('value') == 0) {
                date2.attr('value', date.attr('value'));
            }
        });
    }

    function set_start_value_to_end_sf_field(selector) {
        $(selector).click(function () {
            time = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sf_event_dates_date][und][0][value][time]"]');
            date = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sf_event_dates_date][und][0][value][date]"]');
            time2 = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sf_event_dates_date][und][0][value2][time]"]');
            date2 = $(this).parents('.fieldset-wrapper').find('input[name*="[field_sf_event_dates_date][und][0][value2][date]"]');
            if (time2.length > 0 && time2.attr('value') == 0) {
                time2.attr('value', time.attr('value'));
            }
            if (date2.length > 0 && date2.attr('value') == 0) {
                date2.attr('value', date.attr('value'));
            }
        });

    }

    function set_start_value_to_end_onchange(selector) {
        $(selector).each(function(){
            //console.log($(this));
            date = $(this).find('input[name*="[field_sf_event_dates_date][und][0][value][date]"]');
            date.change(function () {
                date2 = $(this).parents('.field-type-datetime').find('input[name*="[field_sf_event_dates_date][und][0][value2][date]"]');
                console.log('change');
                if (date2.length > 0) {
                    date2.attr('value', $(this).attr('value'));
                }
            });
        });
    }


    Drupal.behaviors.stateFairParkEventAddNewDataDefaultValue = {
        'attach': function () {
            set_previously_value_to_next_field('.field-name-field-sfp-event-dates input[name*="[field_sfp_event_dates_date][und][0][value][time]"]');
            set_previously_value_to_next_field('.field-name-field-sfp-event-dates input[name*="[field_sfp_event_dates_date][und][0][value][date]"]');
            set_start_value_to_end_sf_field('.field-name-field-sf-event-dates input[name*="[field_sf_event_dates_date][und][0][show_todate]"]');
            set_start_value_to_end_field('.field-name-field-sfp-event-dates input[name*="[field_sfp_event_dates_date][und][0][show_todate]"]');
            set_start_value_to_end_onchange('.field-name-field-sf-event-dates .field-type-datetime');
        }
    }
})(jQuery);

