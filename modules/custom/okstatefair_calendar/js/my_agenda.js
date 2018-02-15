(function ($) {
  $(function(){
    $('.link-print').click(function (e) {
      googleAnaliticsPushPrint($('title').html());
    });
    $('.share-list .item-print a').click(function (e) {
      googleAnaliticsPushPrint($('title').html());
    });
  });
    var maxSizeErrorText = Drupal.t('Store has reached maximum size, please remove some items.');
    var storageDisabledErrorText = Drupal.t('Please enable cookies or localstorage in your browser for this feature.');
    var shareTitle = Drupal.t('My Oklahoma State Fair Agenda.');
    var shareBody = Drupal.t('Come Join Me!');
    var shareUrlLodingErrorText = Drupal.t('Error retrieving share url.');
    var shareErrorAgendaEmpty = Drupal.t('You must add at least 1 item to your agenda before you can share.');
    var printErrorAgendaEmpty = Drupal.t('You must add at least 1 item to your agenda before you can print.');
    var addToAgendaText = Drupal.t('ADD TO AGENDA');
    var addedToAgendaText = Drupal.t('ADDED');
    var updateLocalStorageInterval = 24*60*60*1000;//in milliseconds (24h)
    var localStorageKey = 'agenda-data';
    var storageIdsKey = 'agenda-ids';
    var updateFromServerTimeStorageKey = 'agenda-server-update2';
    var updateLocalTimeStorageKey = 'agenda-local-update2';

    myAgenda = new agendaModel();
    //var fbAppId = "318479148284681";//dev app
    var fbAppId = "287481101389104";//live app
    FB.init({appId: fbAppId, status: true, cookie: true});

    function checkIsStorageAvailable() {
        var isStorageAvailable = false;
        try {
            isStorageAvailable = $.jStorage.storageAvailable();
        } catch (e) {
            isStorageAvailable = false;
        }
        return isStorageAvailable;
    }

    $.jStorage.listenKeyChange(localStorageKey, function(key, action) {
        if(myAgenda.isModelOutdated()) {
            myAgenda.reInit();
            $('a.add-to-agenda').each(function () {
                var $link = $(this);
                var id = parseInt($link.data('id'));

                if (myAgenda.isInAgenda(id)) {
                    $link.agendaLinkSetAdded();
                } else {
                    $link.agendaLinkUnsetAdded();
                }
            });
            $(document).trigger('agendaDataChanged');
        }
    });

    function agendaModel() {
        var ids = [];//event`s ids
        var data = [];//event`s data
        var isStorageAvailable = false;
        var dataLoaded = false;
        var shareUrl = '';
        var dataUpdatedTime = 0;
        this.isContentRendered = false;

        //public functions

        this.removeItem = function (id) {
            ids.splice($.inArray(id, ids), 1);
            saveIdsToStorage();
            removeItemData(id);
            saveItemsDataToStorage();
            emptyShareUrl();//empty url, we need retrieve new url
        };

        this.setData = function (items) {
            data = items;
            dataLoaded = true;
            setStorageFullUpdateTime();
            saveItemsDataToStorage();
            emptyShareUrl();//empty url, we need retrieve new url
        };

        this.getData = function () {
            return data;
        };

        this.setShareUrl = function (url) {
            shareUrl = url;
        };

        this.getShareUrl = function () {
            return shareUrl;
        };

        this.isShareUrlExist = function () {
            return shareUrl != '';
        }

        this.addItemData = function (item) {
            //if this item id not already exist
            if ($.inArray(item.id, ids) == -1) {
                ids.push(item.id);
                emptyShareUrl();//empty url, we need retrieve new url
                if (!saveIdsToStorage()) {
                    //on error saving, remove
                    ids.splice($.inArray(id, ids), 1);
                } else {
                    var dataLength = data.length;
                    this.isContentRendered = false;//we should rebuild agenda content after adding element
                    if (dataLength < 1) {
                        data.push(item);
                        saveItemsDataToStorage();
                    } else {
                        for (var key in data) {
                            if (data[key].timestamp >= item.timestamp) {
                                data.splice(key, 0, item);
                                if(!saveItemsDataToStorage()) {
                                    //on error saving, remove
                                    removeItemData(data[key].id);
                                }
                                return;
                            } else if (key == dataLength - 1) {
                                //insert as last element
                                data.push(item);
                                if(!saveItemsDataToStorage()) {
                                    //on error saving, remove
                                    removeItemData(data[key].id);
                                }
                                return;
                            }
                        }
                    }
                }
            }
        };

        this.isInAgenda = function (id) {
            return ($.inArray(id, ids) != -1);
        };

        this.isDataLoaded = function () {
            return dataLoaded;
        };

        this.setDataLoaded = function (val) {
            dataLoaded = val;
        };

        this.getIds = function () {
            return ids;
        };

        this.isModelOutdated = function() {
            return (dataUpdatedTime != getStorageUpdateTime());
        }

        this.setIds = function (idsArray) {
            var newIds = [];
            for(var key in idsArray) {
                var parsedInt = parseInt(idsArray[key]);
                if(parsedInt) {
                    newIds.push(parsedInt);
                }
            }
            ids = newIds;
            saveIdsToStorage();
        };

        this.checkHtmlStorage = function () {
            return isStorageAvailable;
        };

        this.reInit = function () {
            init();
        }

        //private functions

        var saveIdsToStorage = function () {
            $.jStorage.set(storageIdsKey, ids);
            return true;
        }

        var getIdsFromStorage = function () {
            ids = $.jStorage.get(storageIdsKey);
            return ids != null ? ids : [];
        };

        var removeItemData = function(id) {
            for(var key in data) {
                if(data[key].id == id) {
                    data.splice(key, 1);
                    saveItemsDataToStorage();
                    break;
                }
            }
        };

        var emptyShareUrl = function() {
            shareUrl = '';
            $(document).trigger('agendaChangeShareUrl');
        }
        //if storage available, save
        var saveItemsDataToStorage = function () {
            if(isStorageAvailable) {
                try {
                    setUpdateTime();
                    $.jStorage.set(localStorageKey, data);
                } catch (e) {
                    alert(maxSizeErrorText);
                    return false;
                }
            }
            return true;
        };

        var getItemsDataFromStorage = function () {
            var result = [];
            var dataString = $.jStorage.get(localStorageKey);
            if(dataString) {
               result = dataString
            }
            return result;
        };

        var setStorageFullUpdateTime = function () {
            if(isStorageAvailable) {
               $.jStorage.set(updateFromServerTimeStorageKey, new Date().getTime());
            }
        };

        var getStorageFullUpdateTime = function () {
            var result = 0;
            var time = $.jStorage.get(updateFromServerTimeStorageKey);
            if(time) {
                result = time;
            }
            return result;
        };

        var setUpdateTime = function () {
            if(isStorageAvailable) {
                dataUpdatedTime = new Date().getTime();
                $.jStorage.set(updateLocalTimeStorageKey, dataUpdatedTime);

            }
        };

        var getStorageUpdateTime = function () {
            var result = -1;
            var time = $.jStorage.get(updateLocalTimeStorageKey);
            if(time) {
                result = time;
            }
            return result;
        };

        var init = function () {
            //check localStorage
            isStorageAvailable = checkIsStorageAvailable();
            ids = getIdsFromStorage();
            if(isStorageAvailable) {
                var lastFullUpdateTime = getStorageFullUpdateTime();
                dataUpdatedTime = getStorageUpdateTime();
                if(lastFullUpdateTime + updateLocalStorageInterval >= new Date().getTime()) {
                    data = getItemsDataFromStorage();
                    dataLoaded = true;
                } else {
                    //update all items in local storage from server required, on first agenda display
                    dataLoaded = false;
                }

            }
        };

        init();
    }

    Drupal.behaviors.okstate_agenda = {
        attach: function (content, settings) {

            $('a.add-to-agenda').once('agenda-btn', function () {
                var $link = $(this);
                var id = parseInt($link.data('id'));
                var $myAgendaOpener = $('.btn-my-agenda', '.content-agenda-wrapper');

                if (myAgenda.isInAgenda(id)) {
                    $link.agendaLinkSetAdded();
                }

                $(this).click(function (e) {
                    var $elem = $(this);
                    if ($elem.hasClass('active')) {
                        var elemId = parseInt($elem.data('id'));
                        myAgenda.removeItem(elemId);
                        myAgenda.isContentRendered = false;
                        $('a.add-to-agenda[data-id="' + elemId + '"]').agendaLinkUnsetAdded();
                    } else {
                        if(!checkIsStorageAvailable()) {
                            alert(storageDisabledErrorText);
                        } else {
                            var itemData = {};
                            itemData.id = parseInt($elem.data('id'));
                            itemData.date_formatted = $elem.data('date');
                            itemData.time_formatted = $elem.data('time');
                            itemData.event_url = $elem.data('url');
                            itemData.title = $elem.data('title');
                            itemData.timestamp = $elem.data('timestamp');
                            itemData.location = (typeof $elem.data('location') != 'undefined') ? $elem.data('location') : '';
                            googleAnaliticsPushEvent('Add to Agenda', itemData.title);
                            myAgenda.addItemData(itemData);
                            $('a.add-to-agenda[data-id="' +itemData.id + '"]').agendaLinkSetAdded();

                            $myAgendaOpener.addClass('hover').delay(500).queue(function(next){
                                $(this).removeClass('hover');
                                next();
                            });
                        }
                    }
                    e.preventDefault();
                });

            });
            //init desktop agenda
            $('.my-agenda').once('agenda-block', function () {
               $(this).agenda();
            });
            //init mobile agenda
            $('.agenta-wrapper.mobile').once('agenda-block', function () {
               $(this).agenda(
                   {
                       opener: '.btn-menu-agenta',//'.icon-agenta',
                       loader: '.ajax-loader',
                       share: '.btn-group .btn-left a.agenda-share',
                       print: '.btn-group .btn-right a.agenda-print',
                       deleteBtn: '.btn-delete',
                       content: '.menu-items-wrapper',//'.content-agenta',
                       itemWrap: '.content-agenta-item',//'.content-item-wrapp',
                       emptyAgenda: '.empty-agenda',
                       itemTitleClass: 'date-title',
                       agendaActiveClass: 'active-agenda',
                       agendaLoaderPath: 'agenda',
                       siteVersion: 'mobile'
                   }
               );
            });
        }
    };

    function googleAnaliticsPushEvent(type, label) {
        if(typeof _gaq == 'object') {
            _gaq.push(['_trackEvent', 'Okstate fair Event', type, label]);
        }
    }
    function googleAnaliticsPushPrint(label) {
        if(typeof _gaq == 'object') {
            _gaq.push(['_trackEvent', 'Okstate fair page', 'Print', label]);
        }
    }

    function renderAgendaContent(data) {
        var html = '';
        var length = data.length;
        var element = null;
        var previous_date = '';
        for (var i = 0; i < length; i++) {
            element = data[i];

            if (element.date_formatted != previous_date) {
                html += '<div class="content-item-wrapp title-wrap">';
                html += '<div class="title-item">' +
                    '<h3>' + element.date_formatted + '</h3>' +
                    '</div>';
                html += '</div>';
                previous_date = element.date_formatted;
            }
            html += '<div class="content-item-wrapp">';
            html += '<div class="content-item">' +
                '<ul class="list-agenda">' +
                '<li class="item-agenda">' +
                '<div class="item-wrapp">' +
                '<a href="#" class="btn-delete" data-id="' + element.id +'"><span class="icon-delete">delete</span></a>' +
                '<span class="date-agenda">' + element.time_formatted + '</span>' +
                '<a href="'+ element.event_url +'" class="btn-title" title="'+ element.title + '">' + element.title + '</a>' +
                '</div>' +
                '</li>' +
                '</ul>' +
                '</div>' +
                '</div>';

        }
        return html;
    }

    function renderMobileAgendaContent(data) {
        var html = '';
        var length = data.length;
        var element = null;
        var previous_date = '';
        for (var i = 0; i < length; i++) {
            element = data[i];

            if (element.date_formatted != previous_date) {
                html += '<div class="date-title">' +
                    '<h4>' + element.date_formatted + '</h4>' +
                    '</div>';
                html += '</div>';
                previous_date = element.date_formatted;
            }
            html += '<div class="content-agenta-item">' +
                '<ul class="agenta-list">' +
                '<li class="agenta-item-list">' +
                '<div class="agenta-item">' +
                '<a href="#" class="btn-delete" data-id="' + element.id +'"><span class="icon-delete">delete</span></a>' +
                '<span class="date-agenda">' + element.time_formatted + '</span>' +
                '<a href="'+ element.event_url +'" class="btn-title" title="'+ element.title + '">' + element.title + '</a>' +
                '</div>' +
                '</li>' +
                '</ul>' +
                '</div>';

        }
        return html;
    }


    function renderAgendaPrint(data) {
            var html = '<div class="logo">' +
                '<img src="' + Drupal.settings.okstatefair_calendar.print_logo_url +'" alt="logo_print_agenta"/>' +
                '</div>' +
                    '<div class="table-agenta">';
            var length = data.length;
            var element = null;
            var previous_date = '';
            for (var i = 0; i < length; i++) {
                element = data[i];
                var isNewBlock = (element.date_formatted != previous_date);
                if (isNewBlock && i != 0) {
                    //close previous table
                    html += '</tbody>' +
                        '</table>' +
                        '</div>';
                }
                if (isNewBlock) {
                    html += '<div class="table-event">'+
                        '<h3><span>' + $.datepicker.formatDate( "DD, MM d", new Date(element.timestamp * 1000)) + 'th</span><hr></h3>';
                    html += '<table>' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Time</th>' +
                        '<th>Event</th>' +
                        '<th>Location</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    previous_date = element.date_formatted;
                }
                html += '<tr>';
                html += '<td> ' + element.time_formatted + ' </td>' +
                    '<td> ' + element.title + ' </td>';
                var location = (typeof element.location != 'undefined') ? element.location : '';
                html +='<td> ' + location + ' </td>';
                html += '</tr>';
            }
        html += '</tbody>' +
            '</table>' +
            '</div>';
        html += '</div>';
            return html;
    }

    $.fn.agenda = function(options) {
        var options = jQuery.extend({},{
            opener: '.icon-agenta',
            loader: '.ajax-loader',
            share: '.btn-group .btn-left',
            print: '.btn-group .btn-right',
            deleteBtn: '.btn-delete',
            content: '.content-agenta',
            itemWrap: '.content-item-wrapp',
            emptyAgenda: '.empty-agenda',
            itemTitleClass: 'title-wrap',
            agendaActiveClass: 'active-agenda',
            agendaLoaderPath: 'agenda',
            siteVersion: 'desktop' //desktop or mobile
        },options);

        return this.each(function() {
            var isAjaxAgendaLoading = false;
            var $agenda = $(this);
            var openBtn = $agenda.find(options.opener);
            var loader = $agenda.find(options.loader);
            var shareBtn = $agenda.find(options.share);
            var printBtn = $agenda.find(options.print);
            var content = $agenda.find(options.content);
            var emptyContent = $agenda.find(options.emptyAgenda);
            var deleteBtns = [];
            var agendaIScroll = false;

            shareBtn.shareButtons();

            function clickOpener() {
                if (!$agenda.hasClass(options.agendaActiveClass)) {

                    var ids = myAgenda.getIds();
                    if (ids.length > 0 && !isAjaxAgendaLoading && !myAgenda.isDataLoaded()) {
                        isAjaxAgendaLoading = true;
                        loader.show();

                        $.ajax({
                            type: "POST",
                            url: Drupal.settings.basePath + options.agendaLoaderPath,
                            data: { ids: ids}
                        })
                            .done(function (res) {
                                loader.hide();
                                isAjaxAgendaLoading = false;
                                if (typeof res == 'object' && res.status == 'ok') {
                                    myAgenda.setData(res.values);
                                    if(ids.length != res.ids.length) {
                                       //some events was deleted on server, save new ids array
                                        myAgenda.setIds(res.ids);
                                    }
                                    contentRebuild();
                                }
                            })
                            .fail(function (jqXHR, textStatus) {
                                isAjaxAgendaLoading = false;
                                loader.hide();
                            });
                    } else if(!isAjaxAgendaLoading && !myAgenda.isContentRendered) {
                        contentRebuild();
                        loader.hide();
                    } else {
                        loader.hide();
                    }
                }
            }

            function initDeleteButtons() {
                deleteBtns = $agenda.find(options.deleteBtn);
                deleteBtns.once('delete-buttons', function() {
                    $(this).on('click', clickDelete);
                });
            }

            function clickDelete() {
                var $this = $(this);
                var $itemWrap = $this.parents(options.itemWrap);
                //check for titles without items and delete
                if($itemWrap.prev().hasClass(options.itemTitleClass)){
                    if( $itemWrap.next().length < 1
                        || $itemWrap.next().hasClass(options.itemTitleClass)) {
                        $itemWrap.prev().remove();
                    }
                }
                $itemWrap.remove();
                var id = parseInt($this.attr('data-id'));
                $('a.add-to-agenda[data-id=' + id + ']').agendaLinkUnsetAdded();
                myAgenda.removeItem(parseInt($this.attr('data-id')));
                if(myAgenda.getData().length < 1) {
                    contentRebuild();
                } else {
                    if(agendaIScroll) {
                        agendaIScroll.refresh();
                    }
                }
                return false;
            }

            function clickPrint() {
                if(myAgenda.getData().length > 0) {
                    var printHtml = Drupal.settings.okstatefair_calendar.print_css_link;
                    printHtml += renderAgendaPrint(myAgenda.getData());
                    window.frames["print_frame"].document.body.innerHTML = printHtml;
                    window.frames["print_frame"].window.focus();
                    window.frames["print_frame"].window.print();
                } else {
                    alert(printErrorAgendaEmpty);
                }
                return false;
            }


            function contentRebuild() {

                if(options.siteVersion == 'desktop') {
                    var jsPainApi = content.data('jsp');
                    var data = myAgenda.getData();
                    if (data.length > 0) {
                        jsPainApi.getContentPane().html(renderAgendaContent(myAgenda.getData()));
                    } else {
                        jsPainApi.getContentPane().html(emptyContent.clone());
                    }
                    //reinitialise jsPain scroll
                    setTimeout(function () {
                        jsPainApi.reinitialise();
                        myAgenda.isContentRendered = true;
                        initDeleteButtons();
                    }, 80);
                } else {
                    //mobile site version
                    var data = myAgenda.getData();
                    if (data.length > 0) {
                        content.html(renderMobileAgendaContent(myAgenda.getData()));
                    } else {
                        content.html(emptyContent.clone());
                    }
                    setTimeout(function () {
                        if(!agendaIScroll) {
                                agendaIScroll = new iScroll('mobile-menu-agenta', {scrollbarClass: 'scroll-agenta-vertical'});
                        } else {
                            agendaIScroll.refresh();
                        }
                    }, 90);
                    myAgenda.isContentRendered = true;
                    initDeleteButtons();
                }
            }

            function contentRebuildOnlyActive() {
                if($agenda.hasClass(options.agendaActiveClass)) {
                    contentRebuild();
                } else {
                    myAgenda.isContentRendered = false;
                }
            }

            function init() {
                openBtn.on('click.agenda', clickOpener);
                printBtn.on('click.agenda', clickPrint);
                $(document).on('agendaDataChanged.agenda', contentRebuildOnlyActive);
            }

            init();
        });
    };

    $.fn.agendaLinkSetAdded = function () {
        return this.each(function () {
            var $this = $(this);
            $this.addClass('active');
            $this.html(addedToAgendaText);
        });
    };

    $.fn.agendaLinkUnsetAdded = function () {
        return this.each(function() {
            var $this = $(this);
            $this.removeClass('active');
            $this.html(addToAgendaText);
        });
    };

    $.fn.shareButtons = function(options) {
        options = $.extend({
            socialButtonsWrap: '.wrapper-share-wrapper',
            activeClass: 'active',
            twitterBtn: '.item-twitter a',
            facebookBtn: '.item-facebook a',
            mailBtn: '.item-mail a',
            loader: '.share-ajax-loader',
            urlLoadingAjaxPath: 'agenda/share/url'
        }, options);

        var isShareUrlAjaxLoading = false;

        return this.each(function() {
            var $share = $(this);
            var $socialButtonsWrap = $share.parent().find(options.socialButtonsWrap);
            var $twitBtn = $socialButtonsWrap.find(options.twitterBtn);
            var $facebookBtn = $socialButtonsWrap.find(options.facebookBtn);
            var $mailBtn = $socialButtonsWrap.find(options.mailBtn);
            var $loader = $share.parent().find(options.loader);

            function init() {
                $share.on('click.shareButtons', onShareClick);
                $facebookBtn.on('click.shareButtons', onClickFacebook);
                $(document).on('click.shareButtons', onClickOutside);
                $(document).on('agendaDataChanged.agenda', agendaDataChangedHandler);
                $(document).on('agendaChangeShareUrl.agenda', agendaDataChangedHandler);
            }

            function onShareClick(e) {
                e.preventDefault();
                e.stopPropagation();
                if (!isShareUrlAjaxLoading) {
                    if (!$socialButtonsWrap.hasClass(options.activeClass)) {
                        if (!myAgenda.isShareUrlExist()) {
                            getShareUrlAjax(function (url) {
                                $mailBtn.attr('href', 'mailto:?subject=' + encodeURIComponent(shareTitle) + '&body=' + encodeURIComponent(shareBody + ' ' + url));
                                $twitBtn.attr('href', 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(shareTitle) + ' ' +  encodeURIComponent(shareBody));
                                myAgenda.setShareUrl(url);
                                $socialButtonsWrap.addClass(options.activeClass);
                            });
                        } else {
                            $socialButtonsWrap.addClass(options.activeClass);
                        }
                    } else {
                        $socialButtonsWrap.removeClass(options.activeClass);
                    }
                }
            }

            function onClickOutside() {
                $socialButtonsWrap.removeClass(options.activeClass);
            }

            function onClickFacebook() {
                var publish = {
                    method: 'feed',
                    name: shareTitle,
                    caption: shareBody,
                    link: myAgenda.getShareUrl(),
                    picture: Drupal.settings.okstatefair_calendar.logo_url
                };

                FB.ui(publish, function(){});
            }

            function getShareUrlAjax(successHandler) {
                if(myAgenda.getIds().length < 1) {
                    alert(shareErrorAgendaEmpty);
                    return;
                }
                isShareUrlAjaxLoading = true;
                $loader.show();
                $.ajax({
                    type: "POST",
                    url: Drupal.settings.basePath + options.urlLoadingAjaxPath,
                    data: { ids: myAgenda.getIds()}
                })
                .done(function(res){
                        isShareUrlAjaxLoading = false;
                        if (typeof res == 'object' && res.status == 'ok') {
                            successHandler(res.url);
                        } else {
                            alert(shareUrlLodingErrorText)
                        }
                        $loader.hide();
                    })
                .fail(function(){
                        isShareUrlAjaxLoading = false;
                        alert(shareUrlLodingErrorText)
                        $loader.hide();
                    });
            }

            function agendaDataChangedHandler () {
                $socialButtonsWrap.removeClass(options.activeClass);
                myAgenda.setShareUrl('');
            }

            init();
        });
    };

})(jQuery);
