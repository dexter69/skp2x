//we view możemy wygenerować dowolny frgment kodu i przekazać go do tej funkcji

function ufs(htmls, str) {
	
	// htmls - w tym podmieniamy, str to wzorzec do szukania
		
	var re = new RegExp(str, 'g');
	
	$('#UploadFiles').change(function() {

    	var $fileList = $("#fileList");
    	$fileList.empty();

   		for (var i = 0; i < this.files.length; i++) {
		
        	var file = this.files[i];
        	$fileList.append('<li>' + '<div>' + file.name + '</div>' + htmls.replace(re,i) + '</li>');
		
    	}
	});
	
}
