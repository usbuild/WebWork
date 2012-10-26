/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-26
 * Time: 下午1:56
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {
    $('#new_tag').click(function () {
        $.post(baseUrl + 'follow/newTag', {tag:$('#tag').val()}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                window.location.reload();
            } else {
                alert("操作失败");
            }
        });
    });
    $('#new_blog').click(function () {
        $.post(baseUrl + 'follow/newBlog', {blog_id:$('#blog_id').val()}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                window.location.reload();
            } else {
                alert("操作失败");
            }
        });
    });
});