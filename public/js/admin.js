$(document).ready(function () {

    // function titleToSlug() {
    //     let titlefield = $('.titlefield');
    //     let slugfield = $('.slugfield');
    //
    //     titlefield.on('change', function () {
    //         let Text = $(this).val();
    //         Text = Text.toLowerCase();
    //         Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
    //         slugfield.val(Text);
    //     })
    // }
    //
    //
    // titleToSlug();

    function focusScannerOnInput() {
        $('.scan').on('click', function () {
            $('#scan_input').focus();
        });
        $('.close-modal').on('click', function () {
            $('#scan_input').focus();
        });
    }

    function handleScannerModal() {
        $('#scan_input').keypress(function (e) {
            if (e.which === 13) {
                $('.scan_output-modal').modal('show');
                let input = $(this).val();

                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                if (baseUrl.search('localhost') !== -1) {
                    baseUrl += '/public';
                }
                $.get(baseUrl + "/admin/function/scaninput/"+input, function (data) {
                    $('.scan_output-modal .modal-body').html(data);
                });

                // NOT FOUND
                $(document).on('click', '.scan_output-modal .add-product-button', function () {
                    $('.add-product-wrapper').removeClass('d-none');
                    $('#product_name').focus();
                });

                $(this).val('');
                e.preventDefault();
            }
        });
    }

    focusScannerOnInput();
    handleScannerModal();

});

