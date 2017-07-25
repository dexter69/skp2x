$(function() {
    //console.log( "ready!" );
    $('.ikony > #loopka').click(function(){
        loadingON();    
        getData(loadingOFF);
    });    
});

//WŁącz kręciołe
function loadingON() {
    $('.ikony').addClass("kreci");
}

//WYącz kręciołe
function loadingOFF() {
    $('.ikony').removeClass("kreci");
    console.log( "Kreciola OFF!" );
}

function getData( doItWhenYouHaveData ) {

    var theUrl = "/requests/search";

    var posting = $.post( theUrl, request );

    posting.done(function( answer ) { // sukces, dostaliśmy dane        
        console.log("Data: " + answer);
        updateDOM(answer); //wpisz otrzymane dane
        doItWhenYouHaveData();
    });

}

//
function updateDOM(dane) {

    var domElId = 'rezultat';

    $('#' + domElId + '>#czas').append( Date() + '<br>');
    $('#' + domElId + '>#tmp').html(dane);
    
}