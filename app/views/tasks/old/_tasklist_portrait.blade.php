<div class="row-fluid">
  <div class="span12">
    <div class="memitem">
      <div class="memproto">
        <div class="memname_doing"><center>Doing</center></div>
      </div>
      <div class="memdoc_doing">
        <ul id="doing" class="droptrue">
        <% @tasks[:doing_tasks].each do |task| %>
          <%= render "tasks/task", {:task => task, :display => "block" } %>
        <% end %>
        </ul>
      </div>
    </div>

    <div class="memitem">
      <div class="memproto">
        <div class="memname_todo"><center>Todo</center></div>
      </div>
      <div class="memproto_todo">
        <div class="memname_todo_sub"><center>High</center></div>
      </div>
      <div class="memdoc_todo">
        <ul id="todo_h" class="droptrue">
        <% @tasks[:todo_high_tasks].each do |task| %>
          <%= render "tasks/task", {:task => task, :display => "block" } %>
        <% end %>
        </ul>
      </div>
      <div class="memproto_todo">
        <div class="memname_todo_sub"><center>Middle</center></div>
      </div>
      <div class="memdoc_todo">
        <ul id="todo_m" class="droptrue">
        <% @tasks[:todo_mid_tasks].each do |task| %>
          <%= render "tasks/task", {:task => task, :display => "block" } %>
        <% end %>
        </ul>
      </div>
      <div class="memproto_todo">
        <div class="memname_todo_sub"><center>Low</center></div>
      </div>
      <div class="memdoc_todo_bottom">
        <ul id="todo_l" class="droptrue">
        <% @tasks[:todo_low_tasks].each do |task| %>
          <%= render "tasks/task", {:task => task, :display => "block" } %>
        <% end %>
        </ul>
      </div>
    </div>

    <div class="memitem">
      <div class="memproto">
        <div class="memname_waiting"><center>Waiting</center></div>
      </div>
      <div class="memdoc_waiting">
        <ul id="waiting" class="droptrue">
        <% @tasks[:waiting_tasks].each do |task| %>
          <%= render "tasks/task", {:task => task, :display => "block" } %>
        <% end %>
        </ul>
      </div>
    </div>

    <div class="memitem">
      <div class="memproto">
        <div class="memname_done"><center>Done - Recent <%= @recent_done_num %> - </center></div>
      </div>
      <div class="memdoc_done">
        <ul id="done" class="droptrue">
        <% @tasks[:done_tasks].each do |task| %>
          <%= render "tasks/task", {:task => task, :display => "block", :done => true } %>
        <% end %>
        </ul>
      </div>
    </div>
  </div>
</div>
