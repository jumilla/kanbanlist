KanbanList.namespace('taskAction');
KanbanList.taskAction = (function(){
  var draggableTask = KanbanList.draggableTask;
  var autoLoadingTimer = KanbanList.autoLoadingTimer;
  var utility = KanbanList.utility;
  var pomodoroTimer = KanbanList.pomodoroTimer;
  var MIN_HEIGHT = 100;
  var edit_before_message = {};

  function display_filter(text){
    return $.decora.to_html(text);
  }

  function moveToDone(move_id) {
    var to_status = "done";
    var id = move_id.slice(4);
    var message = $("#ms_" + id + "_edit" ).val();
    $("#fixed_message_" + id ).html(display_filter(message));

    $("#edit_link_ms_" + id ).css("display","none");
    $("#edit_form_ms_" + id ).css("display","none");
    $("#fixed_" + id ).css("display","block");
    $("#id_" + id ).find(".task-tool").css("display","none");

    $(move_id).fadeOut("normal",function(){
      $(move_id).prependTo($("#" + to_status));
    });
    $(move_id).fadeIn("normal");

    $('#viewSortlist').html("moveToDone " + move_id);

    //TODO: グローバルのメソッドを呼んでいるので修正する
    sendCurrentTodo(id, to_status, message);
    pomodoroTimer.addDone();
  }

  function returnToTodo(ret_id){
    var to_status = "todo_m";
    var id = ret_id.slice(4);

    $("#edit_link_ms_" + id ).css("display","block");
    $("#edit_form_ms_" + id ).css("display","none");
    $("#fixed_" + id ).css("display","none");
    $("#id_" + id ).find(".task-tool").css("display","none");

    $(ret_id).fadeOut("normal",function(){ $(ret_id).prependTo($("#" + to_status)); });
    $(ret_id).fadeIn("normal");

    $('#viewSortlist').html("returnToTodo " + ret_id);

    var message = $("#ms_" + id + "_edit" ).val();
    //TODO: グローバルのメソッドを呼んでいるので修正する
    sendCurrentTodo(id, to_status, message);
  }

  function deleteTodo( delete_id ) {
    var message_id = '#message_' + delete_id.slice(4);
    $('#delete_task_string').html($(message_id).html());
    $('#delete_task_in').modal('show');

    $('#delete_task_ok_button').click(function(){
      var id = delete_id.slice(4);
      $.ajax({
        type: "DELETE",
        cache: false,
        url: "tasks/" + id,
        dataType: "jsonp"
      });

      $('#delete_task_in').modal('hide')
      $(delete_id).fadeOut("normal",function(){ $(delete_id).remove(); });
      $('#delete_task_ok_button').unbind("click");
      $('#delete_task_cancel_button').unbind("click");
    });

    $('#delete_task_cancel_button').click(function(){
      $('#delete_task_in').modal('hide')
      $('#delete_task_ok_button').unbind("click");
      $('#delete_task_cancel_button').unbind("click");
    });
  }

  function updateToDoMsg(id) {
    var $from = $('#ms_' + id + '_edit')
       ,$to = $('#message_' + id );
    var message = sanitize($from.val());
    message = message.replace(/'/g,"\"");

    $from.val(message);
    $to.html(display_filter(message));

    var status = $("#id_" + id).parent().get(0).id;
    //TODO: グローバルのメソッドを呼んでいるので修正する
    sendCurrentTodo(id, status, message);
    edit_before_message[id] = $('#ms_' + id + '_edit').val();
  }

  function isChangedMsg(id){
    return $('#ms_' + id + '_edit').val() != edit_before_message[id];
  }

  function realize_task(id, message_array){
    var message = message_array.join('\n');

    $(".task-tool-active-area").hover(
      function(){
        $(this).find(".task-tool").css("display","block");
      },
      function(){
        $(this).find(".task-tool").css("display","none");
      }
    );

    $('#ms_' + id + '_edit').val(message);
    $('#message_' + id ).html(display_filter(message));
    $('#fixed_message_' + id ).html(display_filter(message));

    $('#ms_' + id + '_edit').maxlength({
      'feedback' : '.task-chars-left'
    });

    $('#check_done_' + id).iCheck({
      checkboxClass: 'icheckbox_minimal-grey'
    });

    $('#check_done_' + id).on('ifClicked', function(){
      moveToDone('#id_' + id);
      $('#check_return_' + id).iCheck('check');
      return false;
    });

    $('#check_return_' + id).iCheck({
      checkboxClass: 'icheckbox_minimal-grey'
    });

    $('#check_return_' + id).on('ifClicked', function(){
      returnToTodo('#id_' + id);
      $('#check_done_' + id).iCheck('uncheck');
      return false;
    });

    $('#delete_button_' + id ).click(function(){
      deleteTodo('#id_' + id );
      return false;
    });

    $('#fixed_delete_button_' + id ).click(function(){
      deleteTodo('#id_' + id );
      return false;
    });

    $('#ms_' + id + '_edit').autofit({min_height: MIN_HEIGHT});

    function goToEditMode(id){
      autoLoadingTimer.stop();
      draggableTask.stopByElem($('#id_' + id ).parent());

      edit_before_message[id] = $('#ms_' + id + '_edit').val();

      utility.toggleDisplay('edit_link_ms_' + id ,'edit_form_ms_' + id );
      $('#ms_' + id + '_edit').get(0).focus();
      $('#edit_apply_' + id).addClass('disabled');
      $('#ms_' + id + '_edit').keyup(); //call autofit

      return false;
    }

    $('#edit_button_' + id ).click(function(){
      return goToEditMode(id);
    });

    $('#id_' + id ).dblclick( function(){
      return goToEditMode(id);
    });

    $('#id_' + id ).find('.taskBody').decora({
      checkbox_callback: function(that, updateCheckboxStatus){
        $('#ms_' + id + '_edit').val(updateCheckboxStatus($('#ms_' + id + '_edit').val()));
        updateToDoMsg(id);
      }
    });

    $('#edit_form_' + id ).on('keydown', function(event){
      if( event.ctrlKey === true && event.which === 13 ){
        $(this).submit();
        return false;
      }
      return true;
    });

    $('#edit_form_' + id ).on('keyup', function(event){
      if (isChangedMsg(id)){
        $('#edit_apply_' + id).removeClass('disabled');
      }
      return true;
    });

    $('#edit_form_' + id ).submit(function(){
      autoLoadingTimer.start();
      draggableTask.startByElem($('#id_' + id ).parent());
      updateToDoMsg(id);
      utility.toggleDisplay('edit_form_ms_' + id ,'edit_link_ms_' + id );
      return false;
    });

    $('#edit_apply_' + id ).click(function(){
      updateToDoMsg(id);
      $(this).addClass('disabled');
      return false;
    });

    $('#edit_form_' + id ).on('keydown', function(event){
      if( event.which === 27 ){
        $('#edit_cancel_' + id ).click();
        return false;
      }
      return true;
    });

    $('#edit_cancel_' + id ).click(function(){
      autoLoadingTimer.start();
      draggableTask.startByElem($('#id_' + id ).parent());

      $('#ms_' + id + '_edit').val(edit_before_message[id]);
      utility.toggleDisplay('edit_form_ms_' + id ,'edit_link_ms_' + id );
      return false;
    });
  }

  return {
    realize: realize_task,
    display_filter: display_filter
  }
}());
