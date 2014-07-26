@extends('layouts.application')

@section('content')
<div class="container-fluid">
<div class="row-fluid">
  <div class="span4">
    <div id="task_status_chart"></div>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>最近追加されたタスク</th></tr>
@foreach($add_tasks as $add_task)
      <tr>
        <td>
          <span class="label" id="dash_time_{{ $add_task->id }}">{{{ $add_task->updated_at->format("m/d") }}}</span> 
          <a href="#" data-id="{{ $add_task->book_id }}">{{{ Str::limit($add_task->message,30) }}}</a>
        </td>
      </tr>
@endforeach
    </table>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>最近完了したタスク</th></tr>
@foreach($done_tasks as $done_task)
      <tr>
        <td>
          <span class="label" id="dash_time_{{ $done_task->id }}">{{{ $done_task->updated_at->format("m/d") }}}</span>
          <a href="#" data-id="{{ $done_task->book_id }}">{{{ Str::limit($done_task->message,30) }}}</a>
        </td>
      </tr>
@endforeach
    </table>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>古いタスク(忘れてない？)</th></tr>
@foreach($oldest_tasks as $oldest_task)
      <tr>
        <td>
          <span class="label" id="dash_time_{{ $oldest_task->id }}">{{{ $oldest_task->updated_at->format("m/d") }}}</span>
          <a href="#" data-id="{{ $oldest_task->book_id }}">{{{ Str::limit($oldest_task->message,30) }}}</a>
        </td>
      </tr>
@endforeach
    </table>
  </div>

  <div class="span4">
    <div id="done_chart"></div>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>実行中のタスク</th></tr>
@foreach($doing_tasks as $doing_task)
      <tr>
        <td>
          <span class="label" id="dash_time_{{ $doing_task->id }}">{{{ $doing_task->updated_at->format("m/d") }}}</span>
          <a href="#" data-id="{{ $doing_task->book_id }}">{{{ Str::limit($doing_task->message,30) }}}</a>
        </td>
      </tr>
@endforeach
    </table>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>本日変更したタスク</th></tr>
@foreach($today_tasks as $today_task)
      <tr>
        <td>
          <span class="label" id="dash_time_{{ $today_task->id }}">{{{ $today_task->updated_at->format("m/d") }}}</span>
          <a href="#" data-id="{{ $today_task->book_id }}">{{{ Str::limit($today_task->message,30) }}}</a>
        </td>
      </tr>
@endforeach
    </table>
  </div>

  <div class="span4">
    <div id="book_count_chart"></div>
    <table id="book_table" class="table table-bordered table-striped table-condensed">
      <tr><th colspan="7">Books</th></tr>
@foreach($books as $book)
      <tr>
        <td><a href="#" data-id="{{ $book->id }}">{{ $book->name }}</a></td>
        <td class="todo_h {{ ($book->todo_h == 0) ? 'zero' : '' }}">{{ $book->todo_h }}</td>
        <td class="todo_m {{ ($book->todo_m == 0) ? 'zero' : '' }}">{{ $book->todo_m }}</td>
        <td class="todo_l {{ ($book->todo_l == 0) ? 'zero' : '' }}">{{ $book->todo_l }}</td>
        <td class="doing {{ ($book->doing == 0) ? 'zero' : '' }}">{{ $book->doing }}</td>
        <td class="waiting {{ ($book->waiting == 0) ? 'zero' : '' }}">{{ $book->waiting }}</td>
        <td class="done {{ ($book->done == 0) ? 'zero' : '' }}">{{ $book->done }}</td>
      </tr>
@endforeach
    </table>
  </div>
</div>
</div>

{{ javascript_include_tag('dashboard') }}

<script>
$(document).ready(function() {
  // Radialize the colors
  Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
    return {
      radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
      stops: [
      [0, color],
      [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
      ]
    };
  });

  var chart_task = new Highcharts.Chart({
    chart: {
      renderTo: 'task_status_chart',
      type: 'pie'
    },
    title: {
      text: 'Task Status'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          color: '#000000',
          connectorColor: '#000000',
          formatter: function() {
            return '<b>'+ this.point.name +'</b>';
          }
        }
      }
    },
    series: [
    { name: 'tasks',
      data: [
      { name: 'high', y: {{ $task_counts['todo_h'] }} },
      { name: 'middle', y: {{ $task_counts['todo_m'] }} },
      { name: 'low', y: {{ $task_counts['todo_l'] }} },
      { name: 'doing', y: {{ $task_counts['doing'] }} },
      { name: 'waiting', y: {{ $task_counts['waiting'] }} },
      ],
    }]
  });

  var chart_done = new Highcharts.Chart({
    chart: {
      renderTo: 'done_chart',
      type: 'column'
    },
    title: {
      text: 'Done Tasks'
    },
    xAxis: {
      categories: [
@foreach($month_done_lists as $month_done_list)
        '{{ $month_done_list->date->format("m") }}',
@endforeach
      ]
    },
    yAxis: {
      title: {
        text: 'Done'
      }
    },
    series: [
    { name: 'Done',
      data: [
@foreach($month_done_lists as $month_done_list)
        { name: 'done', y: {{ $month_done_list->count }} },
@endforeach
      ],
    }]
  });

  var chart_books = new Highcharts.Chart({
    chart: {
      renderTo: 'book_count_chart',
      type: 'pie'
    },
    title: {
      text: 'Active Book tasks'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          color: '#000000',
          connectorColor: '#000000',
          formatter: function() {
            return '<b>'+ this.point.name +'</b>';
          }
        }
      }
    },
    series: [
    { name: 'tasks',
      data: [
@foreach($books as $book)
        { name: '{{ $book->name }}', y: {{ $book->active_task }} },
@endforeach
      ],
    }]
  });

  $('#book_table').delegate('a', 'click',function(){
    var book_id = $(this).data('id');
    location.href = "/tasks?book_id=" + book_id
    return false;
  });
  $('.task-table').delegate('a', 'click',function(){
    var book_id = $(this).data('id');
    location.href = "/tasks?book_id=" + book_id
    return false;
  });
});
</script>

@stop
