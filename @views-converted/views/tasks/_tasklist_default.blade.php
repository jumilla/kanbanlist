<div class="row-fluid">
  <div class="span4">
    <div class="memitem">
      <div class="memproto">
        <div class="memname_todo"><center>Todo</center></div>
      </div>
      <div class="memproto_todo">
        <div class="memname_todo_sub"><center>High</center></div>
      </div>
      <div class="memdoc_todo">
        <ul id="todo_h" class="droptrue">
        @foreach (@tasks[:todo_high_tasks] as task)
          {{ render "tasks/task", {:task => task, :display => "block" } }}
        @end
        </ul>
      </div>
      <div class="memproto_todo">
        <div class="memname_todo_sub"><center>Middle</center></div>
      </div>
      <div class="memdoc_todo">
        <ul id="todo_m" class="droptrue">
        @foreach (@tasks[:todo_mid_tasks] as task)
          {{ render "tasks/task", {:task => task, :display => "block" } }}
        @end
        </ul>
      </div>
      <div class="memproto_todo">
        <div class="memname_todo_sub"><center>Low</center></div>
      </div>
      <div class="memdoc_todo_bottom">
        <ul id="todo_l" class="droptrue">
        @foreach (@tasks[:todo_low_tasks] as task)
          {{ render "tasks/task", {:task => task, :display => "block" } }}
        @end
        </ul>
      </div>
    </div>
  </div>

  <div class="span4">
    <div class="memitem">
      <div class="memproto">
        <div class="memname_doing"><center>Doing</center></div>
      </div>
      <div class="memdoc_doing">
        <ul id="doing" class="droptrue">
        @foreach (@tasks[:doing_tasks] as task)
          {{ render "tasks/task", {:task => task, :display => "block" } }}
        @end
        </ul>
      </div>
    </div>

    <div class="memitem">
      <div class="memproto">
        <div class="memname_waiting"><center>Waiting</center></div>
      </div>
      <div class="memdoc_waiting">
        <ul id="waiting" class="droptrue">
        @foreach (@tasks[:waiting_tasks] as task)
          {{ render "tasks/task", {:task => task, :display => "block" } }}
        @end
        </ul>
      </div>
    </div>
  </div>

  <div class="span4">
    <div class="memitem">
      <div class="memproto">
        <div class="memname_done"><center>Done - Recent {{ @recent_done_num }} - </center></div>
      </div>
      <div class="memdoc_done">
        <ul id="done" class="droptrue">
        @foreach (@tasks[:done_tasks] as task)
          {{ render "tasks/task", {:task => task, :display => "block", :done => true } }}
        @end
        </ul>
      </div>
    </div>
  </div>
</div>
