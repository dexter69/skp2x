//we view możemy wygenerować dowolny frgment kodu i przekazać go do tej funkcji


	function ufs(html1, html2, stri) {
	
	// htmls - w tym podmieniamy, str to wzorzec do szukania
		

            function listaPlikow(htmloza1, htmloza2, str) {


                    $('#UploadFiles').each( function() {

                            var re = new RegExp(str, 'g');


                            var $filetable = $('#filetable');
                            $filetable.empty();

                            for (var i = 0; i < this.files.length; i++) {

                            var file = this.files[i];

                            if(i == 0)
                                    $filetable.append(
                                            '<tr><th></th><th></th><th>RODO</th><th>ROLA PLIKU</th><th></th></tr>'
                                    );
                            $filetable.append(
                                    '<tr><td>' + htmloza1.replace(re,i) + '</td><td>' +
                                    file.name + '</td><td>' + 
                                    htmloza2.replace(re,i) +
                                    '</td></tr>'
                            );


                    }

                    $( '#filetable [type=checkbox]' ).change(function() {

                            var atrybut = $(this).attr('name');
                                    atrybut = atrybut.substr(13);
                                    var indeks = atrybut.indexOf(']');
                                    var thenr = atrybut.substr(0,indeks);
                                    //alert(thenr);


                                    if( $(this).is(':checked') ) {
                                            $('#Upload'+thenr+'Role').attr('required','required');
                                    }
                                    else {
                                            $('#Upload'+thenr+'Role').removeAttr('required');
                                    }

                            });


                    });

            }		

            function check_list() {

                    $('#filetable select').each( function() {

                            var atrybut = $(this).attr('name');

                            atrybut = atrybut.substr(13);
                            var indeks = atrybut.indexOf(']');
                            var thenr = atrybut.substr(0,indeks);
                            //alert($(this).val());
                            if( $(this).val() == 1 ) {
                                    $('#Upload'+thenr+'Roletxt').removeAttr('disabled');
                                    $('#Upload'+thenr+'Roletxt').attr('required','required');
                            }
                            else {
                                    $('#Upload'+thenr+'Roletxt').removeAttr('required');
                                    $('#Upload'+thenr+'Roletxt').attr('disabled','disabled');
                            }



                    });

            }

			
			
            $('#UploadFiles').change(function() {
                    //alert('bingo!');
                    listaPlikow(html1, html2, stri);
                    check_list();
                    $('#filetable select').change( function() { check_list(); });
            });
            listaPlikow(html1, html2, stri);
            check_list();
            $('#filetable select').change( function() { check_list(); });
			
			
		
	
	}
	
	function check_wybr() {
		
		var wybA = $('td.wybroza:nth-child(2) select').val();
		var wybR = $('td.wybroza:last-child select').val();
		
		if( wybA == yeswyb || wybR == yeswyb )
			$('#CardSitoComment').attr('required','required');
		else
			$('#CardSitoComment').removeAttr('required');
	}
	
	function check_podklady() {
		
		if( $('#CardAPodklad').val() != 0 ) 
			$('td.wybroza:nth-child(2) select').css('visibility', 'visible');
		else 
			$('td.wybroza:nth-child(2) select').css('visibility', 'hidden');
			
		if( $('#CardRPodklad').val() != 0 ) 
			$('td.wybroza:last-child select').css('visibility', 'visible');
		else 
			$('td.wybroza:last-child select').css('visibility', 'hidden');
		
	}
        
        function check_is_perso() {
            
            if( $('#CardIsperso').val() === '1' ) {
                $('#CardPerso').removeAttr('disabled');
                $('#CardPerso').attr('required','required');
                // dla dodatkowego pola input z ilością kart na magazyn
                $('#nag-perso > input').removeAttr('disabled');
            } else {
                $('#CardPerso').removeAttr('required');
                $('#CardPerso').attr('disabled','disabled');
                // dla dodatkowego pola input z ilością kart na magazyn
                //$('#nag-perso > input').attr('disabled','disabled');
            }
        }
        
        function check_perso() {
            
            if( $('.perso-types input[type=checkbox]:checked').length > 0 ) {
                $('#CardIsperso').val('1');
            } else {
                $('#CardIsperso').val('0');
            }
            check_is_perso();
        }
	
	/*
	tylko EDIT - sprawdza wartosc input 'role' dla wszystich dołączonych do karty plików, bu 
	ustawić atrybuty dla input 'roletxt'.
	*/
	function check_edit_pliki() {	
		
		
		function update_disabled(selektor, wartosc) {
			
			var itsname = '[name="' + selektor.substr(0, selektor.length-1) + 'txt]' + '"]';
			
			if( wartosc == orvalue ) {
				$(itsname).removeAttr('disabled');
				$(itsname).attr('required','required');
			}
			else {
				$(itsname).removeAttr('required');
				$(itsname).attr('disabled','disabled');
			}
			
				
				
		}
		
		$('#zpliki select').each( function() {
						
			update_disabled( $(this).attr('name'), $(this).val());
			$(this).change(function() { update_disabled( $(this).attr('name'), $(this).val()); });
			
		});
		
	}

    function addAutocomplete() {

        $( '#CardKlient' ).autocomplete({
            source: klienci,
            select: function(event, ui) {
                $('#CardCustomerId').val(ui.item.id);
                $('.cu' + ui.item.id).show();
                if( $('.cu' + ui.item.id).length ) {
                    $('#wdiv > label').show();
                }
                //Ustaw proponowany język wg klienta
                $('#CardEtylang').val(ui.item.etylang);
            }
        });

    }

    // Usuń i ponownie dołącz autocomplete

    function reAddAutocomplete() {

        $( '#CardKlient' ).autocomplete( "destroy" );
        addAutocomplete();
    }
	
	
	$( document ).ready(function() {
            
            //console.log(klienci);
            
            // obsługa multi - doadawania/edycji wielu kart - w card-multi.js
            multi();

            check_podklady();
            check_is_perso();
            check_edit_pliki();


            $('#CardAPodklad, #CardRPodklad').change(function() { check_podklady(); });

            
            /**
             * Jeżeli któryś z checkbox'ów od perso się zmieni             */
            $('.perso-types input[type=checkbox]').change(function() {                   
               check_perso();
            });


            if( $('.cu' + $('#CardCustomerId').val()).length )
            $('#wdiv > label').show();
            $('.cu' + $('#CardCustomerId').val()).show();

            $( '#CardKlient' ).click(function() {
                if( $( '#CardKlient' ).val() ) {
                    $( '#CardKlient' ).val('');
                    $('#CardCustomerId').val(0);
                    //alert('TAK!');	
                    //$('#wpliki input').attr('disabled', 'disabled');
                    $('#wpliki input[type="checkbox"]').removeAttr('checked');
                    $('#wpliki tr').hide();
                    $('#wdiv > label').hide();
                }
            });

            $( '#CardKlient' ).focusout(function() {
                    if( $('#CardCustomerId').val() === 0 ) {
                            $( '#CardKlient' ).val('');

                    }
            });

            /**
             * 
             */
            var theLabelEl = '#klientdiv > label';
            $( theLabelEl ).click(function() {
                var cltxt = $( theLabelEl ).text();
                
                if( cltxt == 'Klient - inny') {
                    klienci = moi;
                    $( theLabelEl ).text('Klient - mój');
                } else {
                    klienci = inni;
                    $( theLabelEl ).text('Klient - inny');
                }
                reAddAutocomplete();
                console.log(klienci.length);
            });
            
            addAutocomplete();

            /*
            $( '#CardKlient' ).autocomplete({
                source: klienci,
                select: function(event, ui) {
                    $('#CardCustomerId').val(ui.item.id);
                    $('.cu' + ui.item.id).show();
                    if( $('.cu' + ui.item.id).length ) {
                        $('#wdiv > label').show();
                    }
                    //Ustaw proponowany język wg klienta
                    $('#CardEtylang').val(ui.item.etylang);
                }
            });
            */
	
	
});
