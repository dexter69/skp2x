$( document ).ready(function() {

		
	function setFormaPlatnosci() {
		
		if( klino ) {
			$('#OrderFormaPlatnosci').removeAttr('disabled');
			$('#OrderFormaPlatnosci').attr('required','required');
			if( $('#OrderFormaPlatnosci').val() == pay[0] || $('#OrderFormaPlatnosci').val() == pay[1] ) {
				if( $('#OrderTerminPlatnosci').is(':disabled') ) {
					//alert('PIEC');
					if( $('#OrderTrm').val() == '' )
						//setProcentZaliczki(false, platnosci[klino].procent_zaliczki);	
						disableTerminPlatnosci(false, platnosci[klino].termin_platnosci);
						// pokaz i wpisz default					
					else
						//setProcentZaliczki(false, $('#OrderPrc').val());
						disableTerminPlatnosci(false, $('#OrderTrm').val());
						//pokaz i wpisz z pola
				} else {
					//setProcentZaliczki(false, $('#OrderProcentZaliczki').val());
					disableTerminPlatnosci(false, $('#OrderTerminPlatnosci').val());
					// pokaz i pozostaw wartosc bez zmian
				}				
			} else {
				if( !$('#OrderTerminPlatnosci').is(':disabled') ) {
					//alert('SESC');
					$('#OrderTrm').val($('#OrderTerminPlatnosci').val());
					disableTerminPlatnosci(true, null);					
					//termin null
				}
			}
		} else {
			$('#OrderFormaPlatnosci').val(null);
			$('#OrderFormaPlatnosci').attr('disabled','disabled');
			disableTerminPlatnosci(true, null);
		}
		
	}
	
	function setFormaZaliczki() {
		
		var difolt = null;
		
		if( klino ) {
			$('#OrderFormaZaliczki').removeAttr('disabled');
			$('#OrderFormaZaliczki').attr('required','required');
			//alert('JEDEN');
			
			if( $('#OrderFormaZaliczki').val() == pay[0] || $('#OrderFormaZaliczki').val() == pay[1] ) {
				//alert('TRZY');
				if( $('#OrderProcentZaliczki').is(':disabled') ) {
					//alert('PIEC');
					if( $('#OrderPrc').val() == '' )
						setProcentZaliczki(false, platnosci[klino].procent_zaliczki);
						
					else
						setProcentZaliczki(false, $('#OrderPrc').val());
						
				} else {
					setProcentZaliczki(false, $('#OrderProcentZaliczki').val());
				}
				
			} else { // tzn. nie potrzebne, by wpisać procent
				//alert('CZTERY');
				if( !$('#OrderProcentZaliczki').is(':disabled') ) {
					//alert('SESC');
					$('#OrderPrc').val($('#OrderProcentZaliczki').val());
					setProcentZaliczki(true, null);
					
				}
			}
			
		} else {
			//alert('DWA');			
			$('#OrderFormaZaliczki').val(null);
			$('#OrderFormaZaliczki').attr('disabled','disabled');
			setProcentZaliczki(true, null);			
		}
		
		
	}	
	
	function setProcentZaliczki( hide, wartosc ) {
	// hide = true => ukryj ploe procentu, w przeciwnym wypadku pokaż
	// wartosc - wartosc, którą należy przypisać polu procent
	
		
		//if( wartosc )
		if( hide )	{
			$('#OrderProcentZaliczki').val(null);
			$('#OrderProcentZaliczki').removeAttr('required');
			$('#OrderProcentZaliczki').attr('disabled','disabled');
		} else {
			$('#OrderProcentZaliczki').removeAttr('disabled');
			$('#OrderProcentZaliczki').attr('required','required');
			if( wartosc == null || wartosc == 0 )
				$('#OrderProcentZaliczki').val(defproc);
			else
				$('#OrderProcentZaliczki').val(wartosc);
		}
	}
	
	function disableTerminPlatnosci( hide, wartosc ) {
	// hide = true => ukryj pole terminu, w przeciwnym wypadku pokaż
	// wartosc - wartosc, którą należy przypisać polu procent
	
		
		//if( wartosc )
		if( hide )	{
			$('#OrderTerminPlatnosci').val(null);
			$('#OrderTerminPlatnosci').removeAttr('required');
			$('#OrderTerminPlatnosci').attr('disabled','disabled');
		} else {
			$('#OrderTerminPlatnosci').removeAttr('disabled');
			$('#OrderTerminPlatnosci').attr('required','required');
			$('#OrderTerminPlatnosci').val(wartosc);
		}
	}
	
	function wakeKontakt( wake ) {
	// if wake to odisabluj i wpisz defaultowe wartosci, wprzeciwnym wypadku zdisabluj
	
		if( wake ) {
			$('#OrderOsobaKontaktowa, #OrderTel').removeAttr('disabled');
			$('#OrderOsobaKontaktowa, #OrderTel').attr('required','required');
			$('#OrderOsobaKontaktowa').val(platnosci[klino].osoba_kontaktowa);
			$('#OrderTel').val(platnosci[klino].tel);
		} else {
			$('#OrderOsobaKontaktowa, #OrderTel').val(null);
			$('#OrderOsobaKontaktowa, #OrderTel').removeAttr('required');
			$('#OrderOsobaKontaktowa, #OrderTel').attr('disabled','disabled');
		}
	}

	function checkCheckboxes() {
		
		klino = nr_klienta();
		
		switch( l_c_k() ) {
    		case 0:
    			$('#OrderSposobDostawy').attr('disabled','disabled');
    			setExtraAddr(); updateaddr();
        		if( ile_checked == 1 ) {
					wakeKontakt(false);
				}
        		break;
    		case 1:
        		if( ile_checked == 0 ) {
					$('#OrderFormaZaliczki').val(platnosci[klino].forma_zaliczki);
					$('#OrderFormaPlatnosci').val(platnosci[klino].forma_platnosci);
					$('#OrderSposobDostawy').val(0);
					wakeKontakt(true);
					$('#OrderSposobDostawy').removeAttr('disabled');
					setExtraAddr(); updateaddr();
				}
        		break;   			 
		} 
		
		ile_checked = l_c_k();
		//updatepay(klino);
		setFormaZaliczki();
		setFormaPlatnosci();
		
		updateaddr();
		
		$( 'td [type=checkbox]' ).each( function() {
			
			var theRowIn = 'td[row=' + $(this).attr('row')+ '] input';
			
			if( $(this).is(':checked') ) {
				$('#OrderCustomerId').val(klino);
				$('#OrderSiedzibaId').val(adresy[klino]['id']);
				$(theRowIn).attr('required','required');
				$(theRowIn).removeAttr('disabled');
				
			} else {
				$(theRowIn).removeAttr('required');
				$(theRowIn).attr('disabled','disabled');
				if( klino && $(this).attr('customer_id') != klino )
					$(this).attr('disabled','disabled');
				else
					$(this).removeAttr('disabled');
			}
		});
		
		
	}

	

	function l_c_k() { // ilość wybranych kart
		return $( 'td input:checked' ).length;
	}
	
	function nr_klienta() {
		if( l_c_k() )
			return $( 'td input:checked' ).attr('customer_id');
		else
			return 0;
	}
	
	
	
	function updateaddr() {
		
		if( klino && $('#OrderSposobDostawy').val() == 0 ) {
			$('#AdresDostawyName').val(adresy[klino].name);
			$('#AdresDostawyUlica').val(adresy[klino].ulica);
			$('#AdresDostawyNrBudynku').val(adresy[klino].nr_budynku);
			$('#AdresDostawyKod').val(adresy[klino].kod);
			$('#AdresDostawyMiasto').val(adresy[klino].miasto);
			$('#AdresDostawyKraj').val(adresy[klino].kraj);
		} else {
			$('div.extadd input').val(null);
		}
	}

	function setExtraAddr() {
		
		//alert(klino);
		if( klino && $('#OrderSposobDostawy').val() == 2 ) {
			$('div.extadd input').removeAttr('disabled');
			$('div.extadd input:not(#AdresDostawyKod)').attr('required','required');
			$('div.extadd:not(#kod_div)').addClass('required');			
		}
		else {
			$('div.extadd input').removeAttr('required');
			$('div.extadd input').attr('disabled','disabled');
			$('div.extadd').removeClass('required');
		}		
		
	}
	

	var klino; 
	var ile_checked;
	
	ile_checked = l_c_k();
	klino = nr_klienta();
	
	checkCheckboxes();
	setExtraAddr();
	//setFormaZaliczki(klino);	
	//setFormaPlatnosci();
	
	$('#OrderSposobDostawy').change(function() { setExtraAddr(); updateaddr(); });
	$('#OrderFormaZaliczki').change(function() { setFormaZaliczki(); });
	$('#OrderFormaPlatnosci').change(function() { setFormaPlatnosci(); });
	$('td [type=checkbox]' ).change(function() { checkCheckboxes(); });

	$( '#datepicker' ).datepicker({
		altField: '#OrderHdate',
		dateFormat: 'yy-mm-dd',
		defaultDate: + czas_realiz
	});
	
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
	
});




	

	
