$(function() {
 
    $( ".bind-autocomplete" ).each(function(){
        var url = $(this).attr('data-url');
        $( ".bind-autocomplete" ).autocomplete({
            source: function( request, response ) {
                $.getJSON( url, {
                  term: request.term 
                }, response );
      },
      minLength: 2
    });
    });
    
  });