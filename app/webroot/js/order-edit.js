$( document ).ready(function() {
	
	function setItUp( selektor ) {
		$(selektor+':not(#AdresDostawyKod)').attr('required','required');
        $(selektor).removeAttr('disabled');
	}
	
	function setItDown( selektor ) {
		$(selektor).attr('disabled','disabled');
        $(selektor).removeAttr('required');
	}

	$('#OrderSposobDostawy').change(function() {
		
		var adr;
		
		switch( $(this).val() ) {
			case od[0]:
        		adr = adres;
        		$('div.extadd').removeClass('required');
				setItDown('div.extadd input');
        		break;
        	case od[1]:
        		adr = wysylka;
        		$('div.extadd:not(#kod_div)').addClass('required');
				setItUp('div.extadd input');
				//alert('2_');
        		break;
        	default:
        		adr = null;
        		$('div.extadd').removeClass('required');
				setItDown('div.extadd input');
				//alert($(this).val());
				break;
		}
		
		if( adr != null ) {
			$('#AdresDostawyName').val(adr.name);
			$('#AdresDostawyUlica').val(adr.ulica);
			$('#AdresDostawyNrBudynku').val(adr.nr_budynku);
			$('#AdresDostawyKod').val(adr.kod);
			$('#AdresDostawyMiasto').val(adr.miasto);
			$('#AdresDostawyKraj').val(adr.kraj);
		} else
			$('div.extadd input').val(null);
	
	});
	
	
	
	
	$('#OrderFormaZaliczki').change(function() {

		if( $(this).val() != pay[0] && $(this).val() != pay[1] ) // tzn. nie potrzebne, by wpisać procent
			setItDown('#OrderProcentZaliczki');
		
		else 
			setItUp('#OrderProcentZaliczki');
		
	});
	
	$('#OrderFormaPlatnosci').change(function() {
		if( $(this).val() != pay[0] && $(this).val() != pay[1] ) {// czyli bez płatności
			setItDown('#OrderTerminPlatnosci');
		} 	else {
				setItUp('#OrderTerminPlatnosci');
			}
	});
	
	$( 'td [type=checkbox]' ).change(function() {
		
		var payelem = '#OrderFormaZaliczki, #OrderProcentZaliczki, #OrderFormaPlatnosci, #OrderTerminPlatnosci';
		var konelem = '#OrderOsobaKontaktowa, #OrderTel';
		var dostawa = '#OrderSposobDostawy';
		var allthe = payelem + ',' + konelem + ',' + dostawa;
		
		theRow = $(this).attr('row');
		if( $(this).is(':checked') ) {
			setItUp('td[row=' + theRow + '] input');
		}
		else {
			setItDown('td[row=' + theRow + '] input');
		}
		
		switch( $( 'td input:checked' ).length ) {
    		case 0:
        		setItDown(allthe + ', div.extadd input');
        		break;
    		case 1:
        		setItUp(allthe);
        		$('#OrderSposobDostawy').change();
        		$('#OrderFormaZaliczki, #OrderFormaPlatnosci').change();
        		break;    		
		} 
	
	});
	
	//wymusza sprawdzenie powyższych po np. odświerzeniu strony
	$( 'td [type=checkbox]' ).change();
	//$('#OrderSposobDostawy').change();
	$('#OrderFormaPlatnosci').change();
	$('#OrderFormaZaliczki').change();
		
	$('#ekspresorder').click(function() {
		$(this).toggleClass( 'ekspres' );
		if( $( this ).hasClass( 'ekspres' ) ) 
			$('#OrderIsekspres').val(1);
		else
			$('#OrderIsekspres').val(0);
	});


	if( $('#OrderIsekspres').val() == '1' ) 
		$('#ekspresorder').addClass( 'ekspres' );
	else 
		$('#ekspresorder').removeClass( 'ekspres' );
	
	
	$( '#datepicker' ).datepicker({
		altField: '#OrderHdate',
		dateFormat: 'yy-mm-dd'
		//defaultDate: + czas_realiz
	});
	
	$( '#datepicker' ).datepicker( 'setDate', stop_day );
});


	

	
