@extends('layouts.application')

@section('content')
{{ javascript_include_tag('donelist') }}
<div class="container-fluid">
  <div class="donenote">
    <div class="row-fluid">
      <div class="span4">
        <ul class="nav nav-tabs nav-stacked">
          @foreach ($month_list as $l)
            <li><a href="{{ route('tasks.donelist', ['year' => $l['date']->year, 'month' => $l['date']->month]) }}">
            {{ $l['date']->format('Y-m') }} ({{ $l['count'] }}) <i class='icon-chevron-right'></i></a></li>
          @endforeach
        </ul>
        <div id="done_chart"></div>
      </div>

      <div class="span8">
        {{ $tasks->links() }}
        <table id="done_list_table" class="table table-striped table-bordered">
          <?php $latest_day = null ?>
          @foreach ($tasks as $task)
            <?php $current_day = $task->updated_at->format('Y-m-d') ?>
            <tr>
              @if ($latest_day == null || $latest_day != $current_day )
                <?php $latest_day = $current_day  ?>
                <td class="done-list-day"><span class="label label-info">{{ $current_day }}</span></td>
                <td class="done-list-time"><span class="label">{{ $task->updated_at->format('H:i') }}</span></td>
                <td id="done_{{ $task->id }}"></td>
              @else
                <td></td>
                <td><span class="label">{{ $task->updated_at->format('H:i') }}</span></td>
                <td id="done_{{ $task->id }}"></td>
              @endif
              <script>
                var message_array = {{ json_encode([$task->message], true) }};
                $("#done_{{ $task->id }}").html(taskAction.display_filter(message_array.join('\n')));
              </script>
            </tr>
          @endforeach
        </table>
        {{ $tasks->links() }}
      </div>
    </div>
  </div>
</div>

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
        @foreach ($month_done_list as $m)
          '{{ $m['date']->format('m') }}',
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
        @foreach ($month_done_list as $m)
          { name: 'done', y: {{ $m['count'] }} },
        @endforeach
        ],
      }]
    });
  });
</script>
@stop

