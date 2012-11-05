/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-5
 * Time: 下午4:39
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    setActive('null');
    $('#new_blog_form').submit(function (evt) {
        evt.preventDefault();
        $.post(baseUrl + 'blog/create', {name:$('#blog_name').val(), domain:$('#domain').val()}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                window.location.href = baseUrl + "blog/view/" + obj.data.id;
            } else {
                $('#create_error').html(obj.data).css('display', 'block');
            }
        });
    });
});