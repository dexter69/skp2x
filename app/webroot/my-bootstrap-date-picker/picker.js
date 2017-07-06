$('.picker-container .input-group').datepicker()
    .on('changeDate', function(e) {
        //console.log('zmiana');
        console.log(e.date);
        //console.log($('.picker-container .input-group input').val());  
        gibon.test = $('.picker-container .input-group input').val();
        console.log(gibon);
    });    

console.log(request);