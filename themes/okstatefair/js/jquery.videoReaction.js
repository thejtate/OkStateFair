(function($) {
  var $window = $(window);

  $.fn.videoReaction = function(options) {
    options = $.extend({
      playOnHoverNode: null
    }, options);

    return this.each(function() {

      var $this = $(this),
        $container = $this.find('.video-container'),
        $video = $container.find('video'),
        $poster = $container.find('.poster'),
        isVideo = false,
        factor;

      function init() {
        $video.hide();
        onResize();
        $window.on('resize.videoReaction', onResize);
        $video.on('canplay.videoReaction', videoOnCanplay);
      };

      function onResize() {
        if(isVideo) {
          resizeVideo();
        }
        resizePoster();
      };

      function resizeVideo() {
        var data = getSizeAndPos();

        $video[0].width = data.width;
        $video[0].height = data.height;
        $video.css({
          left : data.left,
          top  : data.top
        });
      };

      function resizePoster() {
        var data = getSizeAndPos();

        $poster.css({
          width  : data.width,
          height : data.height,
          left   : data.left,
          top    : data.top
        });
      };

      function getSizeAndPos() {
        var cw = $container.width(),
          ch = $container.height(),
          h = ch,
          w = h * factor,
          res;

        if(w < cw) {
          w = cw;
          h = cw / factor;
        }

        res = {
          width: w,
          height: h,
          left: (cw - w) / 2,
          top: (ch - h) / 2
        };

        return res;
      };

      function videoOnCanplay(e) {
        factor = $video[0].videoWidth / $video[0].videoHeight;
        play(false);
        isVideo = true;

        $this.on('mouseover.videoReaction', containerOnMouseOver);
        $this.on('mouseout.videoReaction', containerOnOnMouseOut);

        onResize();
        $video.show();
      };

      function containerOnMouseOver() {
        play(true);
      };

      function containerOnOnMouseOut() {
        play(false);
      };

      function play(is) {
        $video[0][is ? 'play' : 'pause']();
      };

      init();
    });
  };
})(jQuery);