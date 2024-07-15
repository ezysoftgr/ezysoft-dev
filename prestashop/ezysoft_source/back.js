$(window).on('load', function() {
    if (typeof showSuccessMessage != 'undefined' && typeof translate_javascripts != 'undefined'
        && 'Form update success' in translate_javascripts && $('[name="form[id_product]"]').length) {
        var showSuccessMessageOriginal = showSuccessMessage,
            id_product = $('[name="form[id_product]"]').val();

        showSuccessMessage = function(msg) {
            showSuccessMessageOriginal(msg);
            if (msg == translate_javascripts['Form update success']) {
                $.ajax({
                    url: ezysoft_source,
                    data: {
                        ajax : true,
                        type: "updateOrCreate",
                        id_product : id_product,
                    },
                    dataType: 'json',
                    success: function(r) {

                    }
                });
            }


        }
    }

});
