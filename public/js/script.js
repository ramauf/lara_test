window.onload = function(){
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.editButtonClass').on('click', function(){
            const id = $(this).attr('forid')
            if ($(this).html() == 'edit'){
                $('#span_' + id).hide();
                $('#input_' + id).show();
                $(this).html('save');
            }else{
                $('#span_' + id).show();
                $('#input_' + id).hide();
                $(this).html('edit');
                $.post('/products/' + id, {price: $('#input_' + id).val()}, function( data ) {
                    console.log(data);
                }, "json");
            }
        });
        $('.editInputClass').on('keyup', function(){
            const id = $(this).attr('forid')
            $('#span_' + id).html($('#input_' + id).val());
        });
    });
};