/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-25
 * Time: 下午9:48
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {

    var data = null;
    if ($('[data-post]').length > 0) {
        data = json_decode($('[data-post]').attr('data-post'));
        var tag = json_decode(data.tag);
        $('#blog_id').attr('disabled', 'disabled');
        $.each(tag, function (i, t) {
            $('#tags').addTag(t);
        });
    }

    $('#submit').click(function (evt) {
        var content = window.editor.getContent();
        var blog_id = $('#blog_id').val();
        var tags = $('#tags').val();
        if ($('#link').val().trim().length == 0) {
            apprise('链接不能为空');
            return;
        }
        var title = {'title':$('#title').val(), 'link':$('#link').val()};
        var post_data = {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'link'};

        if (data) {
            post_data['id'] = data.id;
        }

        $.post(baseUrl + 'post', post_data, function (obj) {
            if (obj.code == 0) {
                window.location.href = baseUrl;
            } else {
                apprise('发表失败');
            }
        }, 'json');
    });


});