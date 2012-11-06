/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-6
 * Time: 下午9:26
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    $('input#title').blur(function () {
        var url = $('input#title').val();
        $('.jqTransformInputWrapper').hide();
        $('#thumb_box').show('slow');
        $.post(baseUrl + 'post/getYoukuImg', {link:url}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                $('#thumb_box *').remove();
                var img = $('<img/>');
                img.attr('src', obj.data);
                img.attr('alt', '缩略图');
                $('#thumb_box').append(img);
            }
        });
    });

    $('#thumb_box').click(function () {
        $('#thumb_box').hide('slow');
        $('.jqTransformInputWrapper').show();
        $('input#title').trigger('focus');
    });
    $('#submit').click(function (evt) {
        var title = $('#title').val();
        var content = window.editor.getContent();
        var blog_id = $('#blog_id').val();
        var tags = $('#tags').val();
        $.post(baseUrl + 'post', {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'text'}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                window.location.reload();
            } else {
                alert('发表失败');
            }
        });
    });
});