$(document).ready(function() {
	$('.rating').barrating({
		theme: 'bootstrap-stars',
		allowEmpty: true,
		onSelect: function(value, text, event){
			if (event !== null){
				var args = text.split(",");
				var book_id = args[0];
				var toUser = args[1];
				console.log(book_id, toUser);
				$.get("grading.php", {to:toUser, itemid:book_id, grade:value});
			}
		}
	});
	$('.rating').each(function( index, element ) {
		var initRate = $(element).data('current-rating');
		console.log(initRate);
		if (initRate !== undefined)
			$(element).barrating('set', $(element).data('current-rating'));
		
	});
 });