/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-25
 * Time: 下午9:48
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {

    $('#submit_text').click(function (evt) {
        var title = $('#title').val();
        var content = editor.getContent();
        var blog_id = $('#blog_id').val();
        var tags = $('#tags').val();
        $.post(baseUrl + 'post', {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags}, function (e) {
            var obj = json_decode(e);
            if(obj.code == 0) {
                window.location.reload();
            } else {
                alert('发表失败');
            }
        });
    });

});