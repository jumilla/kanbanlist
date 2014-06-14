@extends('layouts.default')

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
          <span class="label" id="dash_time_{{ t.id }}">{{{ t.updated_at.strftime("%m/%d") }}}</span> 
          <a href="#" data-id="{{ t.book_id }}">{{{ truncate(t.msg) }}}</a>
        </td>
      </tr>
@endforeach
    </table>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>最近完了したタスク</th></tr>
      <% @done_tasks.each do |t| %>
      <tr>
        <td>
          <span class="label" id="dash_time_<%= t.id %>"><%= t.updated_at.strftime("%m/%d") %></span>
          <a href="#" data-id="<%= t.book_id %>"><%= truncate(t.msg) %></a>
        </td>
      </tr>
      <% end %>
    </table>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>古いタスク(忘れてない？)</th></tr>
      <% @oldest_tasks.each do |t| %>
      <tr>
        <td>
          <span class="label" id="dash_time_<%= t.id %>"><%= t.updated_at.strftime("%m/%d") %></span>
          <a href="#" data-id="<%= t.book_id %>"><%= truncate(t.msg) %></a>
        </td>
      </tr>
      <% end %>
    </table>
  </div>

  <div class="span4">
    <div id="done_chart"></div>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>実行中のタスク</th></tr>
      <% @doing_tasks.each do |t| %>
      <tr>
        <td>
          <span class="label" id="dash_time_<%= t.id %>"><%= t.updated_at.strftime("%m/%d") %></span>
          <a href="#" data-id="<%= t.book_id %>"><%= truncate(t.msg) %></a>
        </td>
      </tr>
      <% end %>
    </table>

    <table class="task-table table table-bordered table-striped table-condensed">
      <tr><th>本日変更したタスク</th></tr>
      <% @today_tasks.each do |t| %>
      <tr>
        <td>
          <span class="label" id="dash_time_<%= t.id %>"><%= t.updated_at.strftime("%m/%d") %></span>
          <a href="#" data-id="<%= t.book_id %>"><%= truncate(t.msg) %></a>
        </td>
      </tr>
      <% end %>
    </table>
  </div>

  <div class="span4">
    <div id="book_count_chart"></div>
    <table id="book_table" class="table table-bordered table-striped table-condensed">
      <tr><th colspan="7">Books</th></tr>
      <% @books.each do |b| %>
      <tr>
        <td><a href="#" data-id="<%= b['id'] %>"><%= b['name'] %></a></td>
        <td class="todo_h <%= b[:todo_h] == 0 ? 'zero' : '' %>"><%= b[:todo_h] %></td>
        <td class="todo_m <%= b[:todo_m] == 0 ? 'zero' : '' %>"><%= b[:todo_m] %></td>
        <td class="todo_l <%= b[:todo_l] == 0 ? 'zero' : '' %>"><%= b[:todo_l] %></td>
        <td class="doing <%= b[:doing] == 0 ? 'zero' : '' %>"><%= b[:doing] %></td>
        <td class="waiting <%= b[:waiting] == 0 ? 'zero' : '' %>"><%= b[:waiting] %></td>
        <td class="done <%= b[:done] == 0 ? 'zero' : '' %>"><%= b[:done] %></td>
      </tr>
      <% end %>
    </table>
  </div>
</div>
</div>

<%= javascript_include_tag 'dashboard' %>

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
      { name: 'high', y: <%= @task_counts[:todo_h] %> },
      { name: 'middle', y: <%= @task_counts[:todo_m] %> },
      { name: 'low', y: <%= @task_counts[:todo_l] %> },
      { name: 'doing', y: <%= @task_counts[:doing] %> },
      { name: 'waiting', y: <%= @task_counts[:waiting] %> },
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
      <% @month_done_list.each do |m| %>
        '<%= m[:date].strftime("%m") %>',
      <% end %>
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
      <% @month_done_list.each do |m| %>
        { name: 'done', y: <%= m[:count] %> },
      <% end %>
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
      <% @books.each do |b| %>
        { name: '<%= b['name'] %>', y: <%= b['active_task'] %> },
      <% end %>
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
