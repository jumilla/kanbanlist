$(document).ready(function(){
  var COOKIE_EXPIRES = 365;
  var COOKIE_PRIORITY = 'kanbanlist_priority';

  function addTodoWithPrefix( prefix, message, priority ){
    if ( message == "" ){
      return;
    }

    var prefix_text = "";
    if ( prefix != "" ){
      prefix_text = "[" + prefix + "]";
    }

    addTodoAjax( prefix_text + " " + message, priority );
  }

  function addTodoAjax(message, priority) {
    priority = priority == null ? "todo_m" : priority;
    $.ajax({
      type: "POST",
      cache: false,
      url: "tasks",
      data: {
        message: escapeInvalidChar(message),
        priority: priority
      },
      dataType: "jsonp"
   });
  }

  function escapeInvalidChar(message){
    var escaped_message = message.replace(/&/g,"");
    escaped_message = escaped_message.replace(/'/g,"\"");
    escaped_message = escaped_message.replace(/!/g,"|");
    return escaped_message;
  }

  function addTodoAction(){
    addTodoWithPrefix(
      $('#prefix').val() , sanitize($('#add_todo_form_message').val()),
      $('#add_todo_button').data('state')
    );

    $('#add_todo_form_message').val('');
    $('#add_todo_form_message').focus();

    $("#add_todo_form_message").maxlength({
      'feedback' : '.task-chars-left-add-form'
    });
  }

  $("#add_todo_form_message").maxlength({
    'feedback' : '.task-chars-left-add-form'
  });

  $("#add_todo_form").submit(function(){
    addTodoAction();
    return false;
  });

  $("#add_todo_button").click(function(){
    addTodoAction();
  });

  $('#add_todo_btn_group').delegate('a', 'click',function(){
    var priority = $(this).data('state');
    $('#add_todo_button').data('state', priority);
    $('#add_todo_label').html($(this).html());
    $.cookie(COOKIE_PRIORITY,priority,{ expires: COOKIE_EXPIRES });
  });

  var priority = $.cookie(COOKIE_PRIORITY);
  $("a[data-state='" + priority + "']").click();

  filterTask("");
});
