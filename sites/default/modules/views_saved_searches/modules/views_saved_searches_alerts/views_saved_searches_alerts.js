// $Id

Drupal.behaviors.jobs_board_alerts = function() { 
  // bind to the checkboxes in the views rows'
  //changes to update if the user selects them
  $('.views-field-email-alerts input:checkbox').click(function() {
    var uid = $(this).parent().parent().parent().find('input[name=uid]').val();
    var sid = $(this).parent().parent().parent().find('input[name=sid]').val();
    if($(this).attr('checked')) {
      var action = "add";
    }
    else {
      var action = "remove";
    }
    $.get('/views-saved-searches/alerts/' + action + '/' + uid + '/' + sid);
  });
  
  //remove the non-js helper submit button
  $('.views-field-email-alerts input:submit').hide();
}