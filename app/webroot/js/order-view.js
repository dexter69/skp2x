$( document ).ready(function() {
	
	$('.dlajoli').change(function() {
		
		var id = $(this).attr('idlike');
		
		if( $( this ).prop( "checked" ) )
			$('#' + id ).val(1);
		else
			$('#' + id ).val(0);
	});
	
	$('.dlajoli').each(function() {
		var id = $(this).attr('idlike');
		
		if( $( this ).prop( "checked" ) )
			$('#' + id ).val(1);
		else
			$('#' + id ).val(0);
	});
});