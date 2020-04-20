$( document ).ready(function() {

    var
        percent = '',
        termin  = '',      
        prePaySelect    = $('#CustomerFormaZaliczki'),
        prePayPercent   = $('#CustomerProcentZaliczki'),
        postPaySelect   = $('#CustomerFormaPlatnosci'),
        postPayTermin   = $('#CustomerTerminPlatnosci');
    
    //window.termin  = '',

    prePaySelect.change( function() { 
		checkPrePayOptions();
	});

	postPaySelect.change( function() { 
		checkPostPayOptions();
	});

    function checkPrePayOptions() {
        
        if( prePaySelect.val() == pay[0] || prePaySelect.val() == pay[1] ) {
            
            if( prePayPercent.is(':disabled') ) {
                
                prePayPercent.removeAttr('disabled');
                if( percent == '' ) {
                    prePayPercent.val(defproc);
                } else {
                    prePayPercent.val(percent);
                }					
            } 
        } else {
            if( prePayPercent.is(':disabled') == false ) {
                percent = prePayPercent.val();
                prePayPercent.val(null);
                prePayPercent.attr('disabled','disabled');
            }
        }
    }
    
    function checkPostPayOptions() {

        //Jeżeli jest PREZLEW lub GOTÓWKA
        if( postPaySelect.val() == postpay[0] || postPaySelect.val() == postpay[1] ) {
            if( postPayTermin.is(':disabled') ) {
                postPayTermin.removeAttr('disabled');
                if( termin == '' ) {
                    postPayTermin.val(defterm);
                } else {
                    postPayTermin.val(termin);
                }
            }
        } else {
            if( !postPayTermin.is(':disabled') ) {
                termin = postPayTermin.val();
                postPayTermin.val(null);
                postPayTermin.attr('disabled','disabled');
            }
        }
    }
});