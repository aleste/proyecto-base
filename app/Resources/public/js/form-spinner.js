(function ( $ ) {
    'use strict';

    $(document).ready(function() {
        $('form').bind('submit', function() {
            $(this).find('button[type="submit"].btn i').attr('class', 'icon-spinner icon-spin');
        });
   });
})( jQuery );
