$( document ).ready(function() {

	// do pomiaru szerokości
	function checkSize() {
		
		var bodyw;
		var oknow;
		var wynik;
		
		bodyw = $( 'body' ).width();
		oknow = $(window).width();
		wynik = (oknow - bodyw)/2 +2;
		$( 'div#gener.actions' ).css( "left", wynik );
		
	}	
        
        function fireSearch() {
            
           if( $( '#szukanie' ).hasClass( 'hid' ) ) {
			$( '#szukanie' ).removeClass('hid');
			$( '#szukanie' ).addClass( 'vis');	
			$('#CardSirczname').click(function() {	
				$(this).val('');
			});
                        $('#CardSirczname').focus();
		} else {
			$( '#szukanie' ).removeClass('vis');
			$( '#szukanie' ).addClass( 'hid');	
		} 
                
        }
	
	$( '.klose-mark' ).click(function() {
		fireSearch();
	});
        
        $(document).keypress(function(e) {
            if ( e.which === 102 && !$(e.target).is('input, textarea') ) {
                fireSearch();
            } 
        });

});