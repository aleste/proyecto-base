$(document).ready(function(){

    $('#dp1').datepicker({
        language: 'es'
    });

    $('#btn-carga-ajax').on('click', function(){
        var loading = $('#loading');
        var result = $('#result-ajax');

        $.ajax({
            url: Routing.generate('ajax'),
            type: "POST",
            dataType: "html",
            beforeSend: function(){
                loading.show();
            },
            success: function(data){
                loading.hide();
                result.html(data);

            },
            error: function(){
                loading.hide();
                result.html('Ocurrió un error');
            }
        });

    });
});
