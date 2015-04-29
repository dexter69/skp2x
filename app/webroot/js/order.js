$( document ).ready(function() {
		
	$('#extraadres input').removeAttr("required");
	$('td[row] input').removeAttr("required");
	$('td[row] input').val('');
	$('td.mnoznik select').val(1);
	$('td[row] input').attr("disabled","disabled");
	$('#extraadres div').removeClass("required");
	//$('th.special').removeClass("special");
	$('#OrderSposobDostawy').val(0);
	
	$('#OrderSposobDostawy').change(function() {
		
		if( $(this).val() == 2 ) {
			
			$('#extraadres').show();
			$('#extraadres input').attr("required","required");
			$('#extraadres div').addClass("required");
		}
		else {
			$('#extraadres').hide();
			$('#extraadres input').removeAttr("required");
			$('#extraadres div').removeClass("required");
		}
	});
	
	var theCheckboxClass;
	var theRow;
	var selektor;
	var paydata = {
		"forma_zaliczki":"0",
		"procent_zaliczki":"",
		"forma_platnosci":"2",
		"termin_platnosci":"",
		"osoba_kontaktowa":"",
		"tel":""
	};
	
	$('#OrderFormaZaliczki').change(function() {

		if( $(this).val() < 2) {
			$('div#procent').css('visibility', 'hidden');
			$('div#procent').removeClass("required");
			$('div#procent input').removeAttr("required");
		}
		else {
			$('div#procent').css('visibility', 'visible');
			$('div#procent').addClass("required");
			$('div#procent input').attr("required","required");
		}
	});
	
	
	$('#OrderFormaPlatnosci').change(function() {
		if( $(this).val() < 2 ) {
			$('div#payterm').css('visibility', 'hidden');
			$('div#payterm').removeClass("required");
			$('div#payterm input').removeAttr("required");
		}
		else {
			$('div#payterm').css('visibility', 'visible');
			$('div#payterm').addClass("required");
			$('div#payterm input').attr("required","required");
		}
	});
	
	// WARTOŚCI POCZĄTKOWE, W RAZIE ODŚWIERZENIA STRONY PRZEZ UŻYTKOWNIKA
	var nchecked = 0;
	
	$( 'td [type=checkbox]' ).removeAttr("disabled");
	$( 'td [type=checkbox]' ).removeAttr("checked");
	$('#OrderFormaZaliczki').val(paydata.forma_zaliczki);
	$('#OrderProcentZaliczki').val(paydata.procent_zaliczki);
	$('#OrderFormaPlatnosci').val(paydata.forma_platnosci);
	$('#OrderTerminPlatnosci').val(paydata.termin_platnosci);
	//$('#OrderOsobaKontaktowa').val(paydata.osoba_kontaktowa);
	//$('#OrderTel').val(paydata.tel);
	
	$( 'td [type=checkbox]' ).change(function() {
		
		var kid = $(this).attr("customer_id");
		
		
		if( $(this).is(':checked') ) {
			$('#OrderCustomerId').val(kid);
			$('#OrderSiedzibaId').val(adresy[kid]['id']);
			theRow = $(this).attr("row");
			$('td[row=' + theRow + '] input').attr("required","required");
			//$('td[row] input').attr("disabled","disabled");
			$('td[row=' + theRow + '] input').removeAttr("disabled");
			//alert(theRow);
			nchecked = nchecked + 1;
			if( nchecked == 1 ) {
				$('th.cenaile').addClass("required");
				theCheckboxClass = $(this).attr("class");
				selektor = 'td [type=checkbox]:not(.' + theCheckboxClass + ')';
				$(selektor).attr("disabled","disabled");
				$( 'td [type=checkbox]' ).removeAttr("required");
				// WPISZ W POLA PŁATNOŚCI DOMYŚLNE WRTOŚCI POCZĄTKOWE
				$('#OrderFormaZaliczki').val(platnosci[kid].forma_zaliczki);
				$('#OrderProcentZaliczki').val(platnosci[kid].procent_zaliczki);
				$('#OrderFormaPlatnosci').val(platnosci[kid].forma_platnosci);
				$('#OrderTerminPlatnosci').val(platnosci[kid].termin_platnosci);
				$('#OrderOsobaKontaktowa').val(platnosci[kid].osoba_kontaktowa);
				$('#OrderTel').val(platnosci[kid].tel);
				$('#OrderFormaPlatnosci, #OrderFormaZaliczki' ).change();
				
			}
		}
		else {
			//$('td[row] input').removeAttr("required");
			theRow = $(this).attr("row");
			$('td[row=' + theRow + '] input').removeAttr("required");
			$('td[row=' + theRow + '] input').attr("disabled","disabled");
			nchecked = nchecked - 1;
			if( nchecked == 0 ) {
				$('th.cenaile').removeClass("required");
				theCheckboxClass = $(this).attr("class");
				selektor = 'td [type=checkbox]:not(.' + theCheckboxClass + ')';
				$(selektor).removeAttr("disabled");
				$( 'td [type=checkbox]' ).attr("required","required");
				//alert("TU");
				// WPISZ W POLA PŁATNOŚCI WRTOŚCI, KTÓRE BYŁY TAM NA POCZĄTKU
				$('#OrderFormaZaliczki').val(paydata.forma_zaliczki);
				$('#OrderProcentZaliczki').val(paydata.procent_zaliczki);
				$('#OrderFormaPlatnosci').val(paydata.forma_platnosci);
				$('#OrderTerminPlatnosci').val(paydata.termin_platnosci);
				$('#OrderOsobaKontaktowa').val(paydata.osoba_kontaktowa);
				$('#OrderTel').val(paydata.tel);
				$( '#OrderFormaPlatnosci, #OrderFormaZaliczki' ).change();
				
			}
		}
		
	});

	$('#OrderFormaZaliczki').change();
	$('#OrderFormaPlatnosci').change();
});
	
	