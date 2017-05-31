function BookList(container, query){
	var self = this;
	this.container = container;
	this.query = query;
	self.from = 0;
	self.size = 2;
	this.getBookList = function(){
		var main_list = $("<tbody>");
		var count = 0;
		this.from = Math.min(0, this.from);
		var length = this.results.length;
		if (this.from == 0)
			this.container.find('.previous').attr('style', 'display:none');
		if (this.from+this.size >= length)
			this.container.find('.next').attr('style', 'display:none');

		$.each(this.results, function(index, result){
			if (self.from <= index && index < self.from+self.size){
				var cover = result['filename'].split(",")[0];
				var entry = $("<tr>", {'data-href': ('item.php?id='+result['Bid'])});
				entry.append($("<td>").html(result['Bname']));
				entry.append($("<td>").append($("<img>", {src: ('data/upload/'+cover), class:'book-thumbnail'})));
				entry.append($("<td>").html('$'+result['Price']));
				entry.append($("<td>").html(result['Nickname']));
				main_list.append(entry);
			}
		});
		return main_list;
	};

	

	$.getJSON('getBookList.php', query, function(data){
		self.results = data['results'];
		var buttons = $("<ul>", {class: 'pager'});
		var prevPage = $("<li>", {class: 'previous'});
		prevPage.append($("<button>", {id: 'prev_btn'}));
		prevPage.children("button").html("Previous");
		buttons.append(prevPage);

		var nextPage = $("<li>", {class: 'next'});
		nextPage.append($("<button>", {id: 'next_btn'}));
		nextPage.children("button").html("Next");
		buttons.append(nextPage);

		self.container.append(buttons);

		var table = $("<table>", {class: 'table table-hover'});
		var tableheader = $("<thead>");
		tableheader.append("<th>Name</th><th>Image</th><th>Price</th><th>Seller</th>")
		table.append(tableheader);

		main_list = self.getBookList();
		table.append(main_list);
		self.container.append(table);
	});

	self.container.find('tr').on("click", function() {
		console.log("4564");
		document.location = $(self).data('href');
	});

	self.container.find('#prev_btn').click(function(event){
		self.from-=self.size;
		console.log($(event.target));
		$(event.target).parent().parent().find('tbody').replaceWith(self.getBookList());
	});

	

	console.log(this.container);
	self.container.find('#next_btn').click(function(event){
		self.from+=self.size;
		console.log($(event.target));
		$(event.target).parent().parent().find('tbody').replaceWith(self.getBookList());
	});
}