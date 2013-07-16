$(document).ready(function(){

    $('#dp1').datepicker({
        language: 'es'
    });

    $('.autohide').delay(2000).fadeOut('slow'); 

    // Muestra/oculta filtros
    $(".btn-filters").on('click', function(e){
        $('#filters-container').toggle('100');
        $("i",this).toggleClass(" icon-circle-arrow-down icon-circle-arrow-up");
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
