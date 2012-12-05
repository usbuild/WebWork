/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-11-8
 * Time: 下午11:43
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    var data_post = null;
    if ($('[data-post]').length > 0) {
        data_post = json_decode($('[data-post]').attr('data-post'));
        var tag = json_decode(data_post.tag);
        $('#blog_id').attr('disabled', 'disabled');
        $.each(tag, function (i, t) {
            $('#tags').addTag(t);
        });
    } else {
        var tag = json_decode(json_decode($('[data-repost]').attr('data-repost')).tag);
        $.each(tag, function (i, t) {
            $('#tags').addTag(t);
        });
    }

    $('.music-input').each(function (i, item) {
        var input = $(this);
        renderMusic(input);
    });

    $('#submit').click(function () {
        var content = window.editor.getContent();
        var blog_id = $('#blog_id').val();
        var tags = $('#tags').val();
        var repost = json_decode($('[data-repost]').attr('data-repost'));

        var post_data = {'Post[content]':content, 'Post[blog_id]':blog_id, 'Post[tag]':tags};


        if (data_post !== null) {
            post_data['Post[id]'] = data_post.id;
        }

        $.post(baseUrl + 'post/repost/' + repost.id, post_data, function (e) {
            if (e.code == 0) {
                window.location.href = baseUrl;
            } else {
                apprise('发布失败');
            }
        }, 'json');

    });
});
