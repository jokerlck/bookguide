var textContainer, textareaSize, input;
var autoSize = function () {
  // also can use textContent or innerText
  textareaSize.innerHTML = input.value + '\n';
};

$('.trade').click(function(event){
	var btn = $(event.target)
	var id = $(event.target).data('id');
	var action = $(event.target).data('action');
	console.log(action);
	$.getJSON("trade.php", {action: action, id: id}, function(data){
		console.log(data);
		if (data['success']){
			btn.attr('disabled', true);
			switch (action){
				case 'buy':
					btn.html('Bought');
				break;
				case 'approve_buyer':
					btn.html('Approved');
				break;
				case 'decline_buyer':
					btn.html('Declined');
				break;
				case 'complete':
					btn.html('Transaction Completed');
				break;
				case 'retreat':
					btn.html('Retreated');
				break;
				case 'delete':
					btn.html('Deleted');
				break;
			}
		}
	});
});

$('#submit_cm').click(function(event) {
	$.getJSON("item.php", {action:action, id:id})
})

document.addEventListener('DOMContentLoaded', function() {
  textContainer = document.querySelector('.textarea-container');
  textareaSize = textContainer.querySelector('.textarea-size');
  input = textContainer.querySelector('textarea');

  autoSize();
  input.addEventListener('input', autoSize);
});

$(".fancybox").fancybox({
	"type": "image"
});