
// dependent modules
var autoLoadingTimer = KanbanList.autoLoadingTimer;
var utility = KanbanList.utility;
var ajaxLoader = KanbanList.ajaxLoader;
var touchEvent = KanbanList.touchEvent;
var backgroundImage = KanbanList.backgroundImage;
var bookNavi = KanbanList.bookNavi;
var sendMail = KanbanList.sendMail;
var todayMarker = KanbanList.todayMarker;
var draggableTask = KanbanList.draggableTask;
var filterNavi = KanbanList.filterNavi;
var pomodoroTimer = KanbanList.pomodoroTimer;
var taskTheme = KanbanList.taskTheme;

$(document).ready(function(){
  // initialize menus
  bookNavi.init();
  sendMail.init();
  autoLoadingTimer.init();
  backgroundImage.init();
  filterNavi.init({submit: filterTask});
  pomodoroTimer.init();
  taskTheme.init();

  // initialize modules
  draggableTask.setHandlers({receive: sendCurrentTodo,
                             update_order: sendTaskOrder
                            });

  $('a[rel=tooltip]').tooltip({ placement:"bottom"});
  return;
});
