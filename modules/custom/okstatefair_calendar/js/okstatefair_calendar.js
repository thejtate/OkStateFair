(function($){

    var loadCalendarPrintErrorText = Drupal.t('Error loading pring page.');

    Drupal.behaviors.calendarActions = {
        attach: function(content, settings){
            var sortByCheckboxes = $('.sort-table input.sort-by');

            $('.calendar-items .num').once('calendar-dates', function(){
              $(this).click(function(e){
                  pageRedirect($(this).attr('data'));
                  return false;
              });
            });

            sortByCheckboxes.once('calendar-sorting', function(){
                $(this).click(function(e){
                    var $elem = $(this);
                    if($elem.attr('value') == 'all') {
                        if($elem.is(':checked')) {
                            sortByCheckboxes.not(this).filter(':checked').prop('checked', false);
                        }
                    } else {
                        if($elem.is(':checked')) {
                            sortByCheckboxes.filter('[value=all]').prop('checked', false);
                        }
                    }
                    $.uniform.update(sortByCheckboxes);
                    pageRedirect($('li.event-date.active .num').attr('data'));

                });
            });

            function pageRedirect(calendarDate) {
                var categoryTids = "";
                sortByCheckboxes.filter(':checked').each(function(i) {
                    if(categoryTids != "") {
                        categoryTids += ',';
                    } else {
                        categoryTids = "/";
                    }
                    categoryTids += $(this).attr('value');
                });

                window.location.href = Drupal.settings.basePath + 'state-fair-calendar/' + calendarDate + categoryTids;
            }

            $('a#sf-calendar-print-link').once('calendar-print', function() {
                $(this).click(function(e){
                    var $this = $(this);
                    var link = $this.attr('href');
                    if(!$this.hasClass('data-loading')) {
                        $this.addClass('data-loading');
                        $.ajax({
                            type: "GET",
                            url: Drupal.settings.basePath + link
                        })
                            .done(function(res){
                                $this.removeClass('data-loading');

                                var printHtml = Drupal.settings.okstatefair_calendar.print_css_link;
                                printHtml += res;
                                window.frames["calendar_print_frame"].document.body.innerHTML = printHtml;
                                window.frames["calendar_print_frame"].window.focus();
                                window.frames["calendar_print_frame"].window.print();
                            })
                            .fail(function(){
                                $this.removeClass('data-loading');
                                alert(loadCalendarPrintErrorText)
                            });
                    }

                    return false;
                });
            });
        }
    }
})(jQuery)