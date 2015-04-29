$( document ).ready(function() {
	
		
	function checkPrePayOptions() {
		
		if( $('#CustomerFormaZaliczki').val() == pay[0] || $('#CustomerFormaZaliczki').val() == pay[1] ) {
			
			if( $('#proc_div input').is(':disabled') ) {
				$('#proc_div').addClass('required');
				$('#proc_div input').attr('required', 'required');
				$('#proc_div input').removeAttr('disabled');
				if( $('#CustomerPrc').val() == '' )
					$('#proc_div input').val(defproc);
				else
					$('#proc_div input').val($('#CustomerPrc').val());
				
			}
		}
		else {
			if( $('#proc_div input').is(':disabled') == false ) {
				$('#CustomerPrc').val($('#proc_div input').val());
				$('#proc_div input').val(null);
				$('#proc_div').removeClass('required');
				$('#proc_div input').attr('disabled','disabled');
				$('#proc_div input').removeAttr('required');
			}
		}
	}

	function checkPostPayOptions() {
		
		/*
		Jeżeli jest PREZLEW lub GOTÓWKA
			Jeżeli było żadne z powyższych
				- unlock termin, uczyń required i wpisz zachowaną wartość
		W przeciwnym wypadku
			Jeżeli był PRZELEW LUB GOTÓWKA
				- zapamiętaj gdzieś termin, wpisz wart null, zdejmij required i lock
			
		*/
		//Jeżeli jest PREZLEW lub GOTÓWKA
		if( $('#CustomerFormaPlatnosci').val() == postpay[0] || $('#CustomerFormaPlatnosci').val() == postpay[1] ) {
			if( $('#CustomerTerminPlatnosci').is(':disabled') ) { // tzn. że było żadne z powyższych
				
				$('#term_div').addClass('required');
				$('#CustomerTerminPlatnosci').attr('required', 'required');
				$('#CustomerTerminPlatnosci').removeAttr('disabled');
				if( $('#CustomerTerm').val() == '' )
					$('#CustomerTerminPlatnosci').val(defterm);
				else
					$('#CustomerTerminPlatnosci').val( $('#CustomerTerm').val() );
			}
		} else {
			if( !$('#CustomerTerminPlatnosci').is(':disabled') ) {
				$('#CustomerTerm').val( $('#CustomerTerminPlatnosci').val() );
				$('#CustomerTerminPlatnosci').val(null);
				$('#term_div').removeClass('required');
				$('#CustomerTerminPlatnosci').removeAttr('required');
				$('#CustomerTerminPlatnosci').attr('disabled','disabled');				
			}
		}
	}
	
	//checkPayOptions();
	$('#CustomerFormaZaliczki').change( function() { 
		checkPrePayOptions();
	});

	$('#CustomerFormaPlatnosci').change( function() { 
		checkPostPayOptions();
	});
});