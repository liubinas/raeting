$(function() {
 
    $('body').delegate('form :submit', 'click', function(e){
        return App.Util.validateForm($(this).parents('form'));
    });
 
    
    $( "#raeting_raetingbundle_signalstype_symbol" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: $( "#raeting_raetingbundle_signalstype_symbol" ).attr('data-url'),
                dataType: "json",
                data: {
                    maxRows: 12,
                    search: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.title,
                            value: item.id
                        }
                    }));
                }
            });
        },
        focus: autocompleteFocus,
        select: autocompleteSelect,
        minLength: 2
    });
    
});

function autocompleteSelect( event, ui ) {
    $(this).val(ui.item.label);
    if($('[name="'+$(this).attr('name')+'"]').size() == 1){
        $(this).after('<input type="hidden" name="'+$(this).attr('name')+'" value="'+ui.item.value+'" />');
    }else{
        $('[name="'+$(this).attr('name')+'"]:hidden').val(ui.item.value);
    }
    return false;
}

function autocompleteFocus( event, ui ) {
    $(this).val( ui.item.label );
    return false;
}

function daysBetween(date1, date2) {

    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime()
    var date2_ms = date2.getTime()

    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms)

    // Convert back to days and return
    return Math.round(difference_ms/ONE_DAY)

}

function formatHours(hours, minutes) {
    var hours = (hours+24-2)%24; 
    var mid='AM';
    if(hours==0){
        hours = '12';
    }else if(hours>12){
        hours = hours%12;
        hours = hours.toString();
        mid='PM';
    }
    if(minutes.length < 2){
        minutes = '0'+minutes;
    }
    return hours+':'+minutes+''+mid;
}