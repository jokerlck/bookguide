$(document).ready(function(){
	var uploaded_file = [];
	// Set uploader parameter
	$("#uploader").fileinput({
		uploadUrl: 'upload.php',
		showUpload: false,
		uploadAsync: false,
		maxFileCount: 5
	});

	// Perform upload action
	$("#upload-btn").click(function(){
		$('#uploader').fileinput('upload');
	});

	// Submit the form when the file is uploaded successfully
	$('#uploader').on('filebatchuploadsuccess', function(event, data, previewId, index){
		$("#uploaded").val(data['response']['uploaded_file'].join());
		console.log($("#uploaded"));
		$('#upload-form').submit();
	});

	// Get suggested tag list 
	var engine = new Bloodhound({
		prefetch: 'tag_list.json.php',
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		datumTokenizer: Bloodhound.tokenizers.whitespace
	});

	engine.initialize();

	$('#hash_tag').tokenfield({
		typeahead: [null, { source: engine.ttAdapter() }]
	});
	
});