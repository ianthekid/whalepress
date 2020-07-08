jQuery(document).ready(function($) {

  $('.whalepress_action').on('click', function() {
    var script = $(this).data('script');
    var trigger = $(this).data('trigger');
    ajaxReq('whalepress_scripts', script, trigger, $(this));
    
    $(this).html('Loading...');
    $('#update_status').html('Loading...');
  });

  function ajaxReq(action, script, trigger, el) {
    $.ajax({
      url: ajaxurl,
      data: {
        'action': action,
        'script': script,
        'trigger': trigger
      },
      success:function(data) {
        console.log(data);
        var output = data.replace(/\n/g,"<br>");
        $('#update_status').html(output);
        el.html('Run Script');
      },
      error: function(errorThrown){ console.log(errorThrown) }
    });
  }

});