var App = App || {};

App.Config = {};

App.Util = {
    init: function() {
        var body = document.body,
            controller = body.getAttribute( "data-controller" ),
            action = body.getAttribute( "data-action" );

        App.Util.exec( 'Base' );
        App.Util.exec( controller );
        App.Util.exec( controller, action );

    },

    exec: function( controller, action ) {
        
        var ns = App,
        action = ( action === undefined ) ? "init" : action;
        controller = controller.charAt(0).toUpperCase() + controller.slice(1);

        if ( controller !== "" && ns[controller] && typeof ns[controller][action] == "function" ) {
            ns[controller][action]();
        }
    },
    
    validateForm: function(form) {
        var errors = 0;

        if (typeof form == 'string') {
            form = $(form);
        }
        
        form.find(':input:not(button)').each(function(){
            errors += App.Util.validateField($(this));
        });

        if (errors > 0) {
            if (form.find('.response').length == 1) {
                form.find('.response').html(App.Dict.trans('core.fill_all_fields'));
            }
            return false;
        } else {
            return true;
        }
    },

    validateField: function(field, type) {
        var errors = 0;
        var container = field.parents('.form-group');

        field.parents('.input-prepend:first').removeClass('error');
        field.removeClass('error');
        container.removeClass('error');

        if ((field.val() === '' || field.val() == field.attr('placeholder')) && field.attr('required') == 'required' && !field.hasClass('placeholder')){
            errors++;
        }else{
            if (field.attr('required') == 'required' && field.attr('type') == 'checkbox' &&  field.attr('checked') != 'checked'){
                errors++;
                field.parent().children('.checkbox').addClass('error');
            }
            if (field.attr('type') == 'email' && !App.Util.isValidEmail(field.val())){
                errors++;
            }
            if (field.attr('type') == 'number' && !App.Util.isValidNumber(field.val())){
                errors++;
            }
            if (field.attr('type') == 'url' && !App.Util.isValidUrl(field.val())){
                errors++;
            }
            if (field.attr('type') == 'date' && !App.Util.isValidDate(field.val())){
                errors++;
            }
        }

        if (errors > 0) {
            field.addClass('error');
            container.addClass('has-error');
            field.parents('.input-prepend:first').addClass('error');
        }

        return errors;
    },

    //returns true if pattern is a valid email address
    isValidEmail: function(emailAddress) {
        var emailPattern = /^[a-zA-Z0-9\+._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(emailAddress);
    },
    //returns true if pattern is a whole number
    isValidNumber: function(number) {
        var numberPattern = /^[+-]?\d+(\.\d+)?$/;
        return numberPattern.test(number);
    },
    //returns true if pattern is a valid url
    isValidUrl: function(url) {
        var urlPattern = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
        return urlPattern.test(url);
    },
    //returns true if pattern is a valid date dd/mm/yyyy or dd-mm-yyyy
    //@TODO add case for yyyy/mm/dd
    isValidDate: function(date) {
        var datePattern = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/;
        return datePattern.test(date);
    },
    //returns true if pattern is a valid time stamp hh:mm:ss
    isValidTime: function(time) {
        var timePattern = /^([01]\d|2[0-3]):?([0-5]\d)$/;
        return timePattern.test(date);
    },

    confirm: function() {
        return confirm('Confirm delete.');
    }
};

App.Dict = {
    dict: null,
    trans: function(key){
        if (App.Dict.dict != null && App.Dict.dict[key] !== undefined){
            return App.Dict.dict[key];
        } else {
            return key;
        }
    }
};

$(document).ready(function() {
    App.Util.init();
});