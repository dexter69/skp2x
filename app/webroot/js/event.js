$( document ).ready(function() {
	
	$( 'input.eventsub' ).click( function() {
		$('#EventCo').val($(this).attr('co'));
		if( $(this).attr('plik') == 1 )
			$('#UploadFiles').attr('required','required');
		else
			$('#UploadFiles').removeAttr('required');
		if( $(this).attr('req') == 1 )
			$('#EventPost').attr('required','required');
		else
			$('#EventPost').removeAttr('required');
	});
	
	$('#EventPost').removeAttr('required');
	
});

