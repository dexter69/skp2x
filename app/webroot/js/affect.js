$( document ).ready(function() {
	
	$( '#EventViewForm' ).submit(function( event ) {
		//alert( "Handler for .submit() called." );
		//event.preventDefault();
	});
	
	$( '[type=submit]' ).click( function() {
		$('#EventCo').val($(this).attr('co'));
		if( $(this).attr('req') )
			$('#EventPost').attr('required','required');
		else
			$('#EventPost').removeAttr('required');
	});
	
	$('#EventPost').removeAttr('required');
	
});