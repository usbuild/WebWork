/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-6
 * Time: 下午9:26
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    var valid = false;
    var data_post = null;

    var setVideo = function () {
        var url = $('input#title').val();
        $('#title').hide();
        var img = $('<img/>');
        img.attr('src', baseUrl + 'images/loading.gif')
            .attr('alt', '加载中').attr('width', '128px').attr('height', '128px');
        $('#thumb_box img').remove();
        $('#thumb_box').append(img).show();
        $.ajax({
            url:baseUrl + 'post/getVideoInfo',
            type:'POST',
            data:{link:url},
            success:function (e) {
                if (e.code == 0) {
                    $('#thumb_box img').attr('src', e.data.img)
                        .attr('alt', '缩略图');
                    valid = true;
                    $('#video_info').val(json_encode(e.data));
                }
            },
            error:function (e) {
                $('#thumb_box').hide();
                $('input#title').show().trigger('focus');
                valid = false;
            },
            dataType:'json'
        });
    };


    if ($('[data-post]').length > 0) {
        data_post = json_decode($('[data-post]').attr('data-post'));
        var tag = json_decode(data_post.tag);
        $('#blog_id').attr('disabled', 'disabled');
        $.each(tag, function (i, t) {
            $('#tags').addTag(t);
        });
        $('#video_info').val(data_post.head);
        var head = json_decode(data_post.head);
        $('#title').val(head.originUrl);
        $('#title').hide();
        var img = $('<img/>');
        $('#thumb_box').append(img).show();
        $('#thumb_box img').attr('src', head.img)
            .attr('alt', '缩略图');
        valid = true;

    }


    $('input#title').blur(function () {
        setVideo();
    });

    $('#close_btn').click(function () {
        $('#thumb_box').hide();
        $('input#title').show().trigger('focus');
        valid = false;
    });
    $('#submit').click(function (evt) {
        var title = $('#title').val();
        var content = window.editor.getContent();
        var blog_id = $('#blog_id').val();
        var tags = $('#tags').val();
        if (!valid) {
            alert('请输入有效的视频地址');
            return;
        }
        var post_data = {'title':$('#video_info').val(), 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'video'};
        if (data_post != null) {
            post_data['id'] = data_post.id;
        }
        $.post(baseUrl + 'post', post_data, function (obj) {
            if (obj.code == 0) {
                window.location.href = baseUrl;
            } else {
                alert('发表失败');
            }
        }, 'json');
    });
});