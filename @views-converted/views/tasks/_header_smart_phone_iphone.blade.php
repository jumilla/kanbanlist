  <div data-role="header" data-position="fixed">
    <?php switch (state ): ?>
    <?php case 'todo','doing','done': ?>
      <a href="#add_todo_page" id="show_add_todo_form" data-icon="plus" class="ui-btn-left">Add</a>
    <?php case 'book': ?>
      <a href="#todo_nav" class="ui-btn-left">Todo</a>
        <?php endswitch;?>

    <h3>かんばんりすと</h3>
    <?php switch (state ): ?>
    <?php case 'todo','doing','done': ?>
      <a href="#book_list_page" class="ui-btn-right">Book</a>
    <?php endswitch;?>
  </div>
