<li><a id="pomo_navi" href="#" rel="tooltip" title="Pomodoro Timer">
  {{ image_tag('tomato.gif', ['class' => 'icon-pomo']) }}
</a></li>
<li><a href="{{ route('tasks.donelist', [Auth::user()->id]) }}" rel="tooltip", title="Go to DoneList"><i class="icon-list"></i></a></li>
@if (!Config::get('kanbanlist.user.signup_force_confirm'))
<li><a id="send_mail" href="#" rel="tooltip" title="Send list by mail"><i class="icon-envelope"></i></a></li>
@endif
<li><a id="set_bg_image" href="#" rel="tooltip" title="Set background image"><i class="icon-picture"></i></a></li>
<li class="dropdown" style="white-space: nowrap;">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" rel="tooltip" title="Auto loading">
    <i class="icon-refresh"></i>
    <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
    <li><a id="auto_loading" href="#"></a></li>
  </ul>
</li>
@if (!is_sample_user())
  <li><a href="{{ route('user.edit', [Auth::user()->id]) }}" rel="tooltip", title="Edit user info"><i class="icon-user"></i></a></li>
@endif
