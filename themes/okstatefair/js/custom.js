(function ($) {

  if (window.location.search == "?device=mobile") {
    window.location.reload(true);
  }

  currentUrl = window.location.href;
  //  if (currentUrl == "http://okstatefairpark.com/") {
  //    window.location.href = "http://okstatefairpark.com/#state-fair-park";
  //  }
  //  if (currentUrl == "http://okstatefair.com/") {
  //    window.location.href = "http://okstatefair.com/#oklahoma-state-fair";
  //  }
  if (currentUrl == "http://fairslice.net/") {
    window.location.href = "http://fairslice.net/blog";
    //    window.location.reload(true);
  }


  $(function () {
    if ($('.golden-ticket-img').length > 0) {
      setInterval(function () {
        $('.golden-ticket-img .show-off').addClass('animated rotateIn').css('display', 'block');
        setTimeout(function () {
          $('.golden-ticket-img .show-off').removeClass('animated').removeClass('rotateIn').fadeOut("slow", function () {
          });
        }, 900);
      }, 5000);
    }
    if ($('.show-off.menu-sparkle').length > 0) {
      setInterval(function () {
        $('.show-off.menu-sparkle').addClass('animated rotateIn').css('display', 'block');
        setTimeout(function () {
          $('.show-off.menu-sparkle').removeClass('animated').removeClass('rotateIn').fadeOut("slow", function () {
          });
        }, 900);
      }, 3000);
    }
    if ($('.golden-header .show-off').length > 0) {
      setInterval(function () {
        $('.golden-header .show-off').addClass('animated rotateIn').css('display', 'block');
        setTimeout(function () {
          $('.golden-header .show-off').removeClass('animated').removeClass('rotateIn').fadeOut("slow", function () {
          });
        }, 900);
      }, 3000);
    }
    if ($.cookie('mt_device') == 'desktop') {
      $('.mobile-version').removeClass('hideme');
    }
    $('.audio-player').change_audio();
    if ($.fn.navMenu()) {
      $('.navigation-sidebar .menu-block-wrapper > ul .dropdown').navMenu({
        className: 'active'
      });
    }
    ;
    $('.navigation-sidebar div ul:first-child').addClass('menu');
    /* food finder disabling */
    //    $('.top-buttons .btn-food-finder a').click(function(e) {
    //      e.preventDefault();
    //      return false;
    //    });

    if ($('.page-type-foodfinder').length > 0) {
      $('.view-content').find('.food-image-small').each(function () {
        if ($(this).parent().find('.img-narrow').length == 0) {
          $(this).parent().find('.images').append('<div class="img-narrow"><img src="' + $.trim($(this).parent().find('.food-image-small').html()) + '"></div>');
          $(this).parent().find('.images').append('<div class="img-large"><img src="' + $.trim($(this).parent().find('.food-image-large').html()) + '"></div>');
        }
      });
    }
    if ($('.node-type-equine').length > 0) {
      $('.node-type-equine').flash_text('.node-equine .content-wrapper .content-text span.flash');
    }


  });

  $.fn.change_audio = function (options) {
    var options = jQuery.extend({
      wrapper: 'audio-player',
      bigslide: 'play-list-header',
      slides: 'play-list',
      play_img: 'id3_images',
      play_author: 'audio-autor',
      play_title: 'audio-name'

    }, options);

    var wrapper = $('.' + options.wrapper);
    var bigslide = wrapper.find('.' + options.bigslide);
    var play_img = bigslide.find('.' + options.play_img);
    var play_title = bigslide.find('.' + options.play_author + ' p');
    //    var play_author = bigslide.find('.'+options.play_title);
    var slides = wrapper.find('.play-item');
    return this.each(function () {
      slides.bind('click', function () {
        slides.removeClass('current');
        $(this).addClass('current');
        play_img.html(wrapper.find('.current .hideme.img').html());
        //        play_author.html($('.node > h2').html());
        play_title.html(wrapper.find('.current .hideme.author').html());
      });
    });
  };
  $.fn.flash_text = function (options) {
    var options = jQuery.extend({
      selector: '.flash',
      duration: 1300
    }, options);

    var $el = $(options.selector);
    next();

    function next() {
      $el.fadeIn(options.duration, function () {
        $el.fadeOut(options.duration, function () {
          next();
        });
      });
    }
  };
  Drupal.behaviors.popupMapLink = {
    'attach': function (contextual, settings) {
      // href with link to image
      $(".field-location-map-popup").click(function () {
        $.fancybox({
          'href': $(this)[0].href,
          'type': 'image',
          'padding': 0,
          'showCloseButton': true
        });
        return false;
      });
    }
  }
  Drupal.behaviors.instagram_large = {
    'attach': function (contextual, settings) {
      if (typeof $.fancybox == 'function') {
        jQuery(".photos-top-bd a, .photos-top-hd a").fancybox({
          'href': $(this)[0].href,
          'type': 'image',
          'padding': 0,
          'showCloseButton': true,
          'onStart': function (currentArray, currentIndex) {
            var obj = currentArray[currentIndex];
            this.title = $(obj).attr("alt");
          }
        });
      }
    }
  }
  Drupal.behaviors.dropdownCalendarMonthSelector = {
    'attach': function (contextual, settings) {
      $('.spiner-calendar').once('calendar-dropdown-selector', function () {
        $(this).toggle(function () {
          $(this).parent().find('.month-menu').css('display', 'block');
          return false;
        }, function () {
          $(this).parent().find('.month-menu').css('display', 'none');
          return false;
        });
      });
    }
  }
  Drupal.behaviors.dropdownCalendarCategoriesSelector = {
    'attach': function (contextual, settings) {
      //dropdown select categories
      $('.categories-selector').once('categories-dropdown-selector', function () {
        $(this).click(function (e) {
          e.stopPropagation();
          $(this).toggleClass('opened');
        });
        $('.categories-list .list li').each(function () {
          $(this).removeClass('selected');
        });
      });
      //build list of categories
      $('#edit-sfp-category').once('categories-dropdown-emulated-selector', function () {
        var list = $('.categories-selector').find('.categories-list ul.list');
        //clear empty list
        list.html('');
        //add items to list from select
        $('option', $(this)).each(function () {
          list.append('<li>' + $(this).html() + '</li>');
        });

        //click on list items, and submot finctoin
        $('.categories-list .list li').once('categories-dropdown-selector', function () {
          $(this).click(function (e) {
            e.preventDefault();
            $(this).addClass('selected');
            var $selector = $('#edit-sfp-category');
            $selector.find('option').removeAttr("selected");
            $selector.find(":nth-child(" + ($(this).index() + 1) + ")").attr("selected", "selected");
            //initialize ajax auto submit
            //$selector.parents('.ctools-auto-submit-full-form').submit();
            $selector.change();
          });
        });

      });

    }
  }
  Drupal.behaviors.form_validate = {
    attach: function (context, settings) {
      var messages = {
        'submitted[name]': 'INVALID NAME ENTRY',
        'submitted[e_mail]': 'INVALID EMAIL ADDRESS',
        'submitted[enter_question_or_comment_here]': 'FORM IS BLANK'
      }
      if ($(context).is('form') && $(context).hasClass('webform-client-form')) {
        $('.contact-form-wrapper').find('.messages.error').hide();
        $('.contact-form-wrapper').find('input.error, textarea.error').each(function () {
          var name = $(this).attr('name');
          if (name == 'submitted[enter_question_or_comment_here]')  $(this).parent().parent().addClass('error-item');
          else   $(this).parent().addClass('error-item');
          var text = messages[name];
          var label = '<div class="tooltip-error"><span class="icon"></span>' + text + '<span class="icon-error"></span></div>';
          $(this).closest('.form-item.webform-component').append(label);
        })
        $(".tooltip-error").centering();
      }
      //        $('.block-leave-comment').find('.messages.error').hide();
      //        $('.block-leave-comment').find('input.error, textarea.error').each(function() {
      //          var name = $(this).attr('name');
      //          if (name == 'submitted[enter_question_or_comment_here]')  $(this).parent().parent().addClass('error-item');
      //          else   $(this).parent().addClass('error-item');
      //          var text = messages2[name];
      //          var label = '<div class="tooltip-error"><span class="icon"></span>'+text+'<span class="icon-error"></span></div>';
      //          $(this).closest('.form-item').append(label);
      //        })
      //        $(".tooltip-error").centering();
    }
  }

  Drupal.behaviors.comment_form = {
    attach: function (context, settings) {
      $('#comment-form').validate({
        rules: {
          'name': {
            required: true
          },
          'field_comment_mail[und][0][email]': {
            required: true,
            email: true
          },
          'comment_body[und][0][value]': {
            required: true
          },
          'field_comment_website[und][0][value]': {
            required: true
          }
        },
        messages: {
          'name': {
            required: 'Required'
          },
          'comment_body[und][0][value]': {
            required: 'Comment is required.'
          },
          'field_comment_website[und][0][value]': {
            required: 'Required'
          },
          'field_comment_mail[und][0][email]': {
            required: 'Required',
            email: 'Not valid.'
          }
        }
      });
    }
  };
  function sortByName(a, b) {
    return a[0].toLowerCase() > b[0].toLowerCase() ? 1 : -1;
  };

  function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  }

  $(window).load(function () {
    if ($('.page-food-finder a.food-title').length == 1) {
      $('.page-food-finder a.food-title').click();
    }
  });

  $(document).ready(function () {

    /*    $('.page-type-foodfinder .bg-header').after('\n\
     <div class="form form-select-food"> \n\
     <div class="form-item">\n\
     <label>label</label>\n\
     <select class="form-select" name="name">\n\
     <option value="">Select a food that fits your mood</option>\n\
     </select>\n\
     <div class="icon-select"></div>\n\
     </div>\n\
     </div>//');
     */

//    var food_finde = [];
//    $('.page-type-foodfinder .form-type-bef-link a').each( function (){
//      if ($(this).html() != "- Any -") {
//        food_finde.push([$(this).html(),$(this)]);
//      }
//    });
//
//    food_finde.sort(sortByName);
//    for (var i = 1; i < food_finde.length; i++) {
//      item = food_finde[i];
//      if (i > 0 && food_finde[i][0] != food_finde[(i-1)][0]) {
//        item[1].attr('href', item[1].attr('href') + "&othe=1")
//        if (window.location.href == item[1].attr('href')){
//          $('.page-type-foodfinder select.form-select').append(new Option(item[0], item[1].attr('href'), 'selected', 'selected'));
//        } else {
//          $('.page-type-foodfinder select.form-select').append(new Option(item[0], item[1].attr('href')));
//        }
//      }
//    }

    $('.select-wrapp .form-select, .form-select-food .form-select').combobox({
      btnWidth: 68,
      hoverEnabled: true,
      listMaxHeight: 420,
      forceScroll: true
    });

//    $('.page-type-foodfinder .form-select-food select').live('change', function () {
//      window.location.href = $(this).val();
//    });

    $('.food-title').bind('click', function () {
//      if ($(this).parent().find('.img-narrow').length == 0 ) {
//        $(this).parent().find('.images').append('<div class="img-narrow"><img src="' + $.trim($(this).parent().find('.food-image-small').html()) + '"></div>');
//        $(this).parent().find('.images').append('<div class="img-large"><img src="' + $.trim($(this).parent().find('.food-image-large').html()) + '"></div>');
//        $('.page-type-foodfinder .view-content .view img').attr('src', $.trim($(this).parent().find('.food-image-small').html()));
//        var $src = $(this).parent().find('.images .img-narrow img').attr('src');
//        if ($src) {
//          $('.view').find('.btn-zoom').show();
//          $('.view').find('.btn-zoom a').text('Just a little bigger, please.');
//          $('.view').find('.btn-zoom a').removeClass('big-img');
//        }
//      }
    });

//    $('.page-food-finder .btn-zoom').click(function() {
//      if ($(this).find('a').hasClass('big-img')) {
//        $(this).find('a').text('Just a little bigger, please.');
//        $(this).find('a').removeClass('big-img');
//      } else {
//        $(this).find('a').text('Just a little smaller, please.');
//        $(this).find('a').addClass('big-img');
//      }
//    });

    $('.custom-combo .form-select').combobox({
      btnWidth: 68,
      hoverEnabled: true,

      listMaxHeight: 220,
      forceScroll: true

    });

    // if ($('.navigation-sidebar').length) {
    //   menu = $('.navigation-sidebar');
    //   //      second_div = $('.content-wrapper.even.clear-box', '#node-2192, #node-2296, #node-2248, #node-2198, #node-1974').first();
    //   //      second_div = $('.content-wrapper.even.clear-box','.node:not(#node-2246)').first();
    //   second_div = $('.content-wrapper.even.clear-box').first();
    //   if (second_div.length) {
    //     menu_bottom = Math.round(menu.offset().top + menu.height());
    //     second_div_top = Math.round(second_div.offset().top);
    //     second_div_bottom = Math.round(second_div.offset().top + second_div.height());
    //     if ((menu_bottom > second_div_top) & ((menu_bottom - second_div_top) > 20 )) {
    //       if (!(second_div.find('.width-600, .width-600-right').length)) {
    //         flow_around = '<div class="width-600-right"></div>';
    //         second_div.wrapInner(flow_around);
    //       }
    //
    //       second_div_next = second_div.next();
    //       if (second_div_next.length) {
    //         second_div_next_top = Math.round(second_div_next.offset().top);
    //         second_div_next_bottom = Math.round(second_div_next.offset().top + second_div.height());
    //         if ((menu_bottom > second_div_next_top) & ((menu_bottom - second_div_next_top) > 20 )) {
    //           flow_around = '<div class="width-600-right"></div>';
    //           second_div_next.addClass('clearfix');
    //           second_div_next.wrapInner(flow_around);
    //         }
    //       }
    //       //          if (menu_bottom > second_div_top) {
    //       //            flow_around = '<div class="flow-around" style="width: 295px; height: ' + (second_div_bottom-second_div_top) + 'px; float: left;">!</div>';
    //       //            second_div.prepend(flow_around);
    //       //            second_div_top = Math.round(second_div.offset().top);
    //       //            second_div_bottom = Math.round(second_div.offset().top + second_div.height());
    //       //            if (menu_bottom > second_div_bottom) {
    //       //              second_div.find('.flow-around').css({"height" : (second_div_bottom-second_div_top) + "px"});
    //       //            }
    //       //          } else {
    //       //            if ((menu_bottom - second_div_top) > 10 ) {
    //       //              flow_around = '<div style="width: 295px; height: ' + (menu_bottom-second_div_top) + 'px; float: left;"></div>';
    //       //              second_div.prepend(flow_around);
    //       //            }
    //       //
    //       //          }
    //     }
    //   }
    // }
    $('.page-calendar-sfp .categories-selector').click(function () {
      real_height_list = $('.page-calendar-sfp .categories-list .list').height();
      height_list = $('.page-calendar-sfp .categories-list .list').height() - ($('.page-calendar-sfp .categories-list .list').offset().top + $('.page-calendar-sfp .categories-list .list').height() - $('.footer-type-2').offset().top) - 10;
      if (real_height_list > height_list) {
        $('.categories-list').css('overflow-x', 'auto');
        $('.categories-list').css('height', height_list + 'px');
      }
    });
  });

  Drupal.behaviors.popupConstructionUpdatesLink = {
    'attach': function (contextual, settings) {
      if (typeof $.fancybox == 'function') {
        $("a.construction_updates_gallery-popup").fancybox({
          'transitionIn': 'none',
          'transitionOut': 'none',
          'titlePosition': 'over',
          'padding': 0,
          'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">' + (title.length ? ' &nbsp; ' + title : '') + '</span>';
          }
        });
      }
    }
  }

})(jQuery);

