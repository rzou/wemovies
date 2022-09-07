/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import $ from "jquery";

$("input[type='radio']").change(function (e) {
    e.stopImmediatePropagation();
    var id = this.id;
    var items = $(".card");
    if (id === null) {
        $items.show();
    } else {
        items.hide();
        items.filter(function (index) {
            let ids = $(this).attr("value");
            const genres = ids.split('-');
            return genres.includes(id);
        }).show();
    }
});
