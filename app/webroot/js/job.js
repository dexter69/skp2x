$( document ).ready( function() {
	
	
	function sumuj() {
		
		var suma = 0;
		var ikna_suma = 0;
		
		$( 'td.cbox [type=checkbox]' ).each( function() {
			
			var cid = $(this).attr('card_id');
			var inputt = 'td.ikna [card_id='+cid+']';
			
			if( $(this).is(':checked') ) {
				suma = suma + parseInt($(this).attr('ilosc'));
				//ikna-suma = 
				ikna_suma = ikna_suma + ikna_val(cid);
				$( inputt  ).removeAttr('disabled');
				$( inputt  ).attr('required','required');
			} else {
				$( inputt ).attr('disabled','disabled');
				$( inputt  ).removeAttr('required');
				//$( inputt  ).val('');
			}
		});
                
		if( suma > 0 ) 
			$('td.suma').text(suma);
		else
			$('td.suma').text('');
		if( ikna_suma > 0 ) 
			$('td.iknas').text(ikna_suma);
		else
			$('td.iknas').text('');
		
	}
	
	function ikna_val(kid) {
		
		
		var input; var war;
		
		input = parseInt( $( 'td.ikna [card_id='+kid+']' ).val() );
		
		if( isNaN(input) )war = 0; else war = input;
			
		return war;
		
	}

	function sumuj_ikna() {
		
		var cid;
		var ikna_suma=0;
		
		$( 'td.ikna input' ).each( function() {
			if( !$(this).attr('disabled') ) {
				cid = $(this).attr('card_id');
				ikna_suma = ikna_suma + ikna_val(cid);
			}
		});
		if( ikna_suma > 0 ) 
			$('td.iknas').text(ikna_suma);
		else
			$('td.iknas').text('');

	}

	function sumuj_arkusze() {
		
		//var ilosc_kart = parseInt($('td.suma').val());
		var ilosc_kart;
		var rodz_ark;
		var ark_netto;
		 
		ilosc_kart = parseInt($('td.suma').text());
		rodz_ark = $('#JobRodzajArkusza').val();
		
		if( isNaN(ilosc_kart) || rodz_ark == 77 )
                    ark_netto = 0;
		else
                    ark_netto = Math.round(ilosc_kart / rodz_ark * 1.05);
		
				
		return ark_netto;
	}
        
        /**/
	$( 'td.cbox [type=checkbox]' ).change( function() {
		
		var oid = $(this).attr('order_id');
		
		var check;
		
		if( $(this).is(':checked') ) check = true; else check = false;
				
		sumuj();
	});
	
	/**/
	
	$('#JobRodzajArkusza, td.cbox [type=checkbox]').change( function() {
		
		$('#JobArkuszeNetto, #JobDlaLaminacji, #JobDlaDrukarzy').val(sumuj_arkusze());
		//alert(sumuj_arkusze());
	});
	
	$( 'td.ikna input' ).change( function() {
		sumuj_ikna();
	});
	
	$( 'td.ikna input' ).keyup( function() {
		sumuj_ikna();
	});
        
        function check_utech( textarea_selektor ) {
            
            var ta = $(textarea_selektor);
            //var ta = textarea_selektor;
            var pid = '#wyz' + ta.data( 'kid' );
            if( ta.val() === '' ) {
                $(pid).removeClass('jest');
            } else {                
                $(pid).addClass('jest');
            }
        }
	
        $('.wyzwalacz').click( function() {
            
            var thediv = $(this).next();
            
            thediv.addClass('up');
            thediv.children( 'textarea' ).focus();
	});
        
        $('p.zamek').click( function() {
            $( this ).parent().removeClass('up');
        });
       
	sumuj();
        
        $( '.utech textarea' ).each(function() {
            check_utech(this);
        });
        
        $( '.utech textarea' ).change(function() {
            check_utech(this);
        });
        
	//$('#JobArkuszeNetto, #JobDlaLaminacji, #JobDlaDrukarzy').val(sumuj_arkusze());
	
        
	
});