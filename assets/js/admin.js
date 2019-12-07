require('../css/admin.css');
require('../css/bootstrap.superhero.css');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

$(document).ready(function () {

    function titleToSlug() {
        let titlefield = $('.titlefield');
        let slugfield = $('.slugfield');

        titlefield.on('change', function () {
            let Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            slugfield.val(Text);
        })
    }


    titleToSlug();

});

