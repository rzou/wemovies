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
    $.ajax({
        type: "POST",
        url: "/movies/genre/"+id,
        data: JSON.stringify({ 'genreId': id }),
        context: '#movies',
        success: function (returnedData) {
            $(this).empty().html(returnedData);
            $("#" + id).prop("checked", true);
            //$('.mostPopular').hide();
        }
    });
});

$('#search').on('keyup', function (e) {
    //e.stopImmediatePropagation();
    let val = $(this).val();
    if (val == '') {
        return;
    }
    $.ajax({
        type: "POST",
        url: "/movies/search",
        data: JSON.stringify({ 'query': val }),
        context: '#movies',
        success: function (returnedData) {
            $(this).empty().html(returnedData);
            return true;
        }
    });
})


