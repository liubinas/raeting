$(function() {
 
    $('body').delegate('form :submit', 'click', function(e){
        e.preventDefault();
        return App.Util.validateForm($(this).parents('form'));
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
    
    
    $( "#raeting_raetingbundle_signalstype_quote" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: $( "#raeting_raetingbundle_signalstype_quote" ).attr('data-url'),
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
    
    $( "#raeting_raetingbundle_signalstype_ticker" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: $( "#raeting_raetingbundle_signalstype_ticker" ).attr('data-url'),
                dataType: "json",
                data: {
                    maxRows: 12,
                    search: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.symbol,
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