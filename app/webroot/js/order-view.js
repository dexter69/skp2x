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

	$('th.clickable').click(function() {		
		//$( this ).toggleClass( "on" );
		toggleStatusEditablePossibility( this );
	});

});

function toggleStatusEditablePossibility( obj ) {
	$( obj ).toggleClass( "on" );
}