$(document).ready(function(){

    $('#dp1').datepicker({
        language: 'es'
    });

    $(".btn-filters").on('click', function(e){
        /*
        var formFilterInputs = $("#filters-container form > :input");
        var filterActive = false;
        formFilterInputs.each(function(index, element){
            if(element.value != ''){
                filterActive = true;
                return false;
            }
        });
        if(!filterActive){
            $('#filters-container').toggle('100');
            $("i",this).toggleClass(" icon-circle-arrow-down icon-circle-arrow-up");
        } */       
        $('#filters-container').toggle('100');
        $("i",this).toggleClass(" icon-circle-arrow-down icon-circle-arrow-up");
            
    });        


    $("#delete_confirm").on('click', function(e){
        var self = $this;
        e.preventDefault();
        self.closest("form").submit();
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
