/*  *************************************************************
 *
 *  CONTROLLER FOR noti.php
 *
 *  Input parameters:
 *  -   In "delete noti" module:
 *      -   id: ID of the deleted notification (marked in attribute)
 *      -   row: Row of the deleted notification
 *  -   In "config time display" module:
 *      -   item: Item of the time display text 
 *    
 *  External modules called:
 *  -   notification.php (to delete noti)
 *  
 *  Areas affected:
 *  -   row: Row of the deleted notification
 *  -   .time: Time display text
 *
 *  *************************************************************/

$(document).ready(function() {
  
  /*  *************************************************************
   *
   *  MODULE TO HANDLE NOTI DELETION
   *  
   *  Input parameters: id, row
   *
   *  Output: none
   *
   *  *************************************************************/
  $('.del').click(function() {
    id = $(this).attr('id');
    row = $(this).parent().parent()
    $(row).fadeOut();
    $.post('notification.php',{del:id});
  });

  /*  *************************************************************
   *
   *  MODULE TO CHANGE TIME DISPLAY
   *  
   *  Input parameters: item
   *
   *  Output: none
   *
   *  *************************************************************/
  $('.time').each(function(index,item) {
  	abstime = $(item).text();
  	reltime = moment(abstime, "YYYY-MM-DD HH:mm:ss").fromNow();
  	$(this).text(reltime);
  });
});