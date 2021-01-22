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

	/*
	$('th.clickable').click(function() {				
		toggleStatusEditablePossibility( this );
	});
    */
   $( "span.cyferka" ).hover(    
    function() {        
      $("p.ekstra-msgs .no-" + $(this).text()).addClass( "visible" );
    }, function() {
      $("p.ekstra-msgs .no-" + $(this).text()).removeClass( "visible" );
    }
  );

});

function toggleStatusEditablePossibility( obj ) {
	$( obj ).toggleClass( "on" );
}