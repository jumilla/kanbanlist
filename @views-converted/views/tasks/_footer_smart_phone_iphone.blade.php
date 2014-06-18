<div data-role="footer" data-position="fixed" data-theme="a">
    <div data-role="navbar">
      <ul>
        <?php switch (state ): ?>
        <?php case 'todo' : ?>
          <li><a href="#todo_nav" class="ui-btn-active ui-state-persist">Todo</a></li>
          <li><a href="#doing_nav">Doing</a></li>
          <li><a href="#done_nav">Done</a></li>
        <?php case 'doing' : ?>
          <li><a href="#todo_nav">Todo</a></li>
          <li><a href="#doing_nav" class="ui-btn-active ui-state-persist">Doing</a></li>
          <li><a href="#done_nav">Done</a></li>
        <?php case 'done' : ?>
          <li><a href="#todo_nav">Todo</a></li>
          <li><a href="#doing_nav">Doing</a></li>
          <li><a href="#done_nav" class="ui-btn-active ui-state-persist">Done</a></li>
        @end
      </ul>
    </div>
</div>
