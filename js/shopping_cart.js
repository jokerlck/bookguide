$(document).ready(function() {
  $(".clickable-row").click(function() {
    window.location = $(this).data("href");
  });
});

$(document).ready(function() {
  $(".trade").click(function(){
    var bookid= $(this).data('id');
    var action= $(this).data('action');
    var buttonObject = $(this);
    $.getJSON('trade.php', {action: action, id: bookid}, function(data){
          console.log(data);
          // If success then disable the button
          if (data['success'])
            buttonObject.attr('disabled', true);
          
            // Determine style to be changed
            switch(action){
              case 'approve_buyer':
                buttonObject.parent().find('.btn-danger').attr('style', 'display:none');
                buttonObject.html('Approved');
              break;
              case 'decline_buyer':
              buttonObject.parent().find('.btn-primary').attr('style', 'display:none');
                buttonObject.html('Declined');
              break;
              case 'delete':
                buttonObject.html('Deleted');
              break;
              case 'retreat':
                buttonObject.html('Retreated');
              break;
            }
            
        }
      );
  });

  // jump to specific book on load
  var url = window.location.href;
  var hash = "book"+url.substring(url.indexOf("#")+1);
  console.log("anchor: "+hash);
  $('body').animate(function(){
        $(this).scrollTo(hash);
    }, 1000);
})
