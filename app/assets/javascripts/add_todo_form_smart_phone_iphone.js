KanbanList.namespace('addForm');
KanbanList.addForm = (function(){
  function initial(current_book){
    function addTodoWithPrefix( prefix, message ){
      if ( message == "" ){
        return;
      }

      var prefix_text = "";
      if ( prefix != "" ){
        prefix_text = "[" + prefix + "]";
      }

      addTodoAjax( prefix_text + " " + message );
    }

    function addTodoAjax(message) {
      $.ajax({
        type: "POST",
        cache: false,
        url: "tasks",
        data: {
          message: escapeInvalidChar(message)
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

    var is_added_task = false;
    function addTodoAction($content){
      addTodoWithPrefix($content.find('.prefix').val() , sanitize($content.find('.add_todo_form_message').val()));
      $content.find('.add_todo_form_message').val('');

      is_added_task = true;
    }

    $(".add_todo_form_message").maxlength({
      'feedback' : '.task-chars-left-add-form'
    });

    $(document).delegate('#show_add_todo_form', 'click',function(){
      setTimeout(function(){
        $('.add_todo_form_message').focus();
      },500);
    });

    $(document).delegate('.add_todo_button', 'click',function(){
      var $content = $(this).closest("[data-role='content']");
      addTodoAction($content);
    });

    $('.prefix').val(current_book.name);
    $('#return_book').click(function(){
      if ( is_added_task ){
        location.href="tasks?book_id=" + current_book.id;
      }else{
        history.back();
      }
    });
  }

  return {
    initial: initial
  }
}());

