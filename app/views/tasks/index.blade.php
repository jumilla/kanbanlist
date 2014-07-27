@extends('layouts.application')

@section('top-left-menu')
  @parent
  @include('tasks._list_dropdown')

          <div class="pull-left">
            <form id="filter_form" method="post" class="navbar-search pull-left">
              <input type="text" id="filter_str" class="search-query span2" value="" placeholder="Filter"/>
            </form>
          </div>
          <div class="pull-left">
@include('layouts/task_count_table')
          </div>
@stop

@section('top-right-menu')
  @include('layouts/trial_feature_dropdown_li')
  @parent
@stop

@section('content')
<div class="container-fluid">
  <div id="sending_mail" class="alert alert-info" style="display:none"></div>
  <div id="send_mail_result" class="alert alert-success" style="display:none"></div>

  <div class="row-fluid">
    <div class="span8">
      <form method="post" id="add_todo_form" class="form-inline">
        <span class="label">Book: <span id="book_name_label"></span></span> <span class="task-chars-left-add-form"></span>

        <div class="btn-toolbar" style="margin: 0;">
          <input type="text" id="prefix" class="span2" name="prefix" value="" placeholder="Book Name" maxlength="50"/>
          <input type="text" id="add_todo_form_message" class="span6" value="" placeholder="Task Name" maxlength="200"/>

          <div class="btn-group" id="add_todo_btn_group" style="margin-bottom: 0;">
            <button class="btn" id="add_todo_button" data-state="todo_m"><i class="icon-plus"></i> <span id="add_todo_label">Middle</span></button>
            <button class="btn dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a data-state="todo_h">High</a></li>
              <li><a data-state="todo_m">Middle</a></li>
              <li><a data-state="todo_l">Low</a></li>
            </ul>
          </div>
        </div>
      </form>
    </div>

    <div class="span4">
      <div id="p_timer_body" style="display:none">
        <center>
          <span id="p_timer_clock">
            <span id="p_min">00</span><span id="p_delim">.</span><span id="p_sec">00</span>
          </span>
          <button id="p_start" class="btn btn-mini btn-info">Start</button>
          <button id="p_pause" class="btn btn-mini btn-info">Pause</button>
          <button id="p_clear" class="btn btn-mini btn-info">Reset</button>
        </center>
      </div>
    </div>
  </div>

  <div id="loader" class="well" style="display:none">
    <center>{{ image_tag('loader.gif') }}</center>
    <center><p id="loading_message_area">Tips: <span id="loading_message"></span></p></center>
  </div>

  <div id="task_list">
    <!-- タスクリストは動的に表示する -->
  </div>

  <div id="download_link">
    Download:
    {{-- link_to "CSV", tasks_path(format: "csv") --}} |
    {{-- link_to "Excel", tasks_path(format: "xls") --}}
  </div>
</div>
{{ javascript_include_tag('tasks') }}
{{ javascript_include_tag('add_todo_form') }}
@stop

