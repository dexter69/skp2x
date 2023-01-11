$('#datoza').datepicker({
    startDate: today()
    //language: "pl",
    //todayHighlight: true
});
$('#datoza').on('changeDate', function() {
    $('#mhi').val(
        $('#datoza').datepicker('getFormattedDate')
    );
});

function today() {
    return new Date();
}

function tomorrow() {
    let tomorrow = new Date(new Date());
    tomorrow.setDate(tomorrow.getDate() + 1);
    return tomorrow;
}