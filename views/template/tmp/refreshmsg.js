/**
 * Created by Сергей on 01.11.2016.
 */
function f() {
    $.ajax({
        url: "/messages/refresh",
        method: 'post'
    }).done(function (data) {
        $('#messagefor').html(data);
    });
}
setInterval("f()",5000);
