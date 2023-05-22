jQuery( document ).ready(function($) {

    console.log( "Prakash Loaded");

    $('#raomi_api_form').on( "submit", function(e){
        
        e.preventDefault(); // avoid to execute the actual submit of the form.
        
        var form = $(this);
        var alert = $('#raomi_api_response');
        var btn = form.find('input[type="submit"]');

        alert.html('');
        alert.removeClass( 'notice notice-success notice-error' );
        alert.hide();
        btn.attr('disabled', true);
        form.find('.submit .spinner').css("float", 'left');
        form.find('.submit .spinner').css("visibility", 'visible');

        $.ajax({
            type: form.attr('method'),
            url: raomi.ajaxurl,
            data:  form.serialize(),
            // contentType: false,
            cache: false,
            // processData:false,
            success: function ( response ) {
                
                alert.show();
                
                if( response.success ){
                    alert.addClass( 'notice notice-success' );
                } else{
                    alert.addClass( 'notice notice-error' );
                }

                alert.html( '<p>'+response.data+'</p>' );
                btn.attr('disabled', false);
                
                form.find('.submit .spinner').css("float", 'right');
                form.find('.submit .spinner').css("visibility", 'hidden');
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });

    });


});