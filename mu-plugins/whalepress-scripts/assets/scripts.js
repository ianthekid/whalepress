jQuery(document).ready(function($) {

  $('.headless_action').on('click', function() {
    var script = $(this).data('script');
    ajaxReq('headless_scripts', script, $(this));
    
    $(this).html('Loading...');
    $('#update_status').html('Loading...');
  });

  function ajaxReq(action, script, el) {
    $.ajax({
      url: ajaxurl,
      data: {
        'action': action,
        'script': script
      },
      success:function(data) {
        console.log(data);
        var output = data.replace(/\n/g,"<br>");
        $('#update_status').html(output);
        el.html('Run Script')
      },
      error: function(errorThrown){ console.log(errorThrown) }
    });
  }

});