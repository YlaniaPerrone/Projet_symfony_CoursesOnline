/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';



const $ = require('jquery');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
    $(".js-example-tokenizer").select2({
       tags: true,
       tokenSeparators: [',', ' ']
   })

});

import './js/filter.js';

