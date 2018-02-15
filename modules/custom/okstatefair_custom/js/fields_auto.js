(function($){
  Drupal.behaviors.sponsorhelper = function () {
    $("input[name='field_images[0][nid][nid]']")
    .blur(function() {
      nidRegEx = /\[nid:(\d+)\]/;
      SponsorHelper.fill($(this).attr('value').match(nidRegEx)[1]);
    })
  };

  SponsorHelper.fill = function(nid) {
    var url = Drupal.settings.basePath +
      'sponsorajaxhelper/' + nid;
    jQuery.getJSON(url, function (data, result) {
      if (result != 'success') {
        return;
      }
      $("input[name='field_admincontact[0][value]']").attr('value',data.nodes[0].node.field_admincontact_value);
      $("input[name='field_adminphone[0][value]']").attr('value',data.nodes[0].node.field_adminphone_value);
    }); 
  }
  })(jQuery);