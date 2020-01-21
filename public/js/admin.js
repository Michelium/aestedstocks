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
        $('.scan_multiple_button').on('click', function () {
            $('#scan_multiple_input').focus();
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

                const getUrl = window.location;
                let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                if (baseUrl.search('localhost') !== -1) {
                    baseUrl += '/public/admin';
                }
                $.get(baseUrl + "/function/scaninput/" + input, function (data) {
                    $('.scan_output-modal .modal-body').html(data);
                });

                // NOT FOUND
                $(document).on('click', '.scan_output-modal .add-product-button', function () {
                    $('.add-product-wrapper').removeClass('d-none');
                    $('#product_name').focus();
                });

                //FOUND
                $(document).on('click', '.scan_output-modal .update-product-button', function () {
                    $('.update-product-wrapper').removeClass('d-none');
                    $('#product_name').focus();
                });

                $(this).val('');
                e.preventDefault();
            }
        });
    }

    function scanMultipleProducts() {
        const getUrl = window.location;
        let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        if (baseUrl.search('localhost') !== -1) {
            baseUrl += '/public/admin';
        }

        $('#scan_multiple_input').keypress(function (e) {
            if (e.which === 13) {
                let id = $(this).val();
                $.get(baseUrl + "/function/addproducttolist/" + id, function (data) {
                    $('.scan_multiple_table tbody').append(data);
                });
                $(this).val('');
                $(this).focus();
            }
        });

        $(document).on('click', '.scan_multiple_delete-button', function () {
            $(this).parent().parent().remove();
        });

        $('.scan_multiple_submit').on('click', function () {
            let alertBox = $('.scan_multiple_alert-box');
            $.ajax({
                url: baseUrl + "/function/submitproductlist",
                method: 'POST',
                data: {items: getListItems()},
                success: function (data) {
                    alertBox.html('');
                    alertBox.append('' +
                        '<div class="alert alert-success alert-dismissible fade show">\n' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
                        'Producten succesvol toegevoegd!' +
                        '</div>');
                    $('.scan_multiple_table tbody').empty();
                },
                error: function () {
                    alertBox.html('');
                    alertBox.append('' +
                        '<div class="alert alert-danger alert-dismissible fade show">\n' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
                        'Oops! Er is iets misgegaan. Vraag de CEO!' +
                        '</div>');
                }
            });
        });
    }
    function getListItems() {
        const items = [];
        $('.scan_multiple_table tr:not(:first-of-type)').each(function () {
            items.push($(this).attr('data-id'));
        });
        return items;
    }

    function productPage() {
        $('.product_action_product_button').on('click', function () {
            $('.product-modal').modal('show');
            const id = $(this).data('id');
            const action = $(this).data('action');
            const getUrl = window.location;
            let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            if (baseUrl.search('localhost') !== -1) {
                baseUrl += '/public/admin';
            }

            if (action === 'update') {
                $('.product-modal .modal-body').html('');
                $.get(baseUrl + "/function/updateproductform/" + id, function (data) {
                    $('.product-modal .modal-body').html(data);
                });
            } else if (action === 'view') {
                $('.product-modal .modal-body').html('');
                $.get(baseUrl + "/function/showproduct/" + id, function (data) {
                    $('.product-modal .modal-body').html(data);
                });
            }

        });
    }

    focusScannerOnInput();
    handleScannerModal();
    scanMultipleProducts();
    productPage();

});

