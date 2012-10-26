$(document).ready(function () {
    $('#new_blog').click(function (e) {
        $.post(baseUrl + 'blog/create', {name:$('#blog_name').val()}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                window.location.reload();
            }
        });
    });
});