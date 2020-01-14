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
            $('#scaninput').focus();
        });
    }

    focusScannerOnInput();

});

