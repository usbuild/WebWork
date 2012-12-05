/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-10-31
 * Time: 下午11:17
 */
$(document).ready(function () {

    var data_post = null;
    if ($('[data-post]').length > 0) {
        data_post = json_decode($('[data-post]').attr('data-post'));
        var tag = json_decode(data_post.tag);
        $('#blog_id').attr('disabled', 'disabled');
        $.each(tag, function (i, t) {
            $('#tags').addTag(t);
        });
    }

    var dropElement = $('.upload-img-box');
    $(document).bind('dragover', function (e) {
        var timeout = window.dropZoneTimeout;
        if (!timeout) {
            $('#hover_text').removeClass('hidden');
            $('#original_text').addClass('hidden');
        } else {
            clearTimeout(timeout);
        }
        if (dropElement.has(e.target).length > 0 || e.target == dropElement.get(0)) {
            dropElement.addClass('upload-img-box-drag');
        } else {
            dropElement.removeClass('upload-img-box-drag');
        }
        window.dropZoneTimeout = setTimeout(function () {
            window.dropZoneTimeout = null;
            $('#hover_text').addClass('hidden');
            $('#original_text').removeClass('hidden');
            dropElement.removeClass('upload-img-box-drag');
        }, 100);
    });
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });


    $('#img_list').sortable({handle:'.move', revert:'true'});

    $('div.close').live('click', function () {
        $(this).parents('li').remove();
    });
    $('#fileupload').fileupload({
        dataType:'json',
        add:function (e, data) {
            $.each(data.files, function (index, file) {

                file.id = Date.parse(new Date()) + parseInt(Math.random() * 1000);
                var div = $('#proto_progress').clone().removeClass('hidden');
                div.attr('id', file.id);
                var img = div.find('img');
                var reader = new FileReader();
                reader.onload = function (e) {
                    img.attr('src', e.target.result);
                    img.attr('alt', file.name);
                    img.attr('width', '60px');
                    img.attr('height', '60px');
                    $('#progress_box').append(div);
                };
                reader.readAsDataURL(file);


            });
            data.submit();
        },

        done:function (e, data) {
            $.each(data.result, function (index, file) {
                var id = data.files[0].id;
                $('#' + id).remove();

                var template = $('#proto_box').clone().removeClass('hidden').attr('id', id);
                var li = $('<li></li>');
                var img = template.find('img');
                img.attr('src', file.thumbnail_url);
                img.attr('data-url', file.url);
                img.attr('alt', file.name);
                img.attr('width', '60px');
                img.attr('height', '60px');
                li.append(template);
                $('#img_list').append(li);
            });
        },
        progress:function (e, data) {
            var id = data.files[0].id;
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#' + id).find('.value').css('width', progress + '%');
        },
        dragover:function (e, data) {
            dropElement.addClass('upload-img-box-drag');
        },
        dropZone:dropElement,
        fail:function (e, data) {
            apprise('上传文件失败');
        }
    });
    $('#upload_btn').click(function () {
        $('#fileupload').trigger('click');
    });
    $('#submit').click(function (e) {
        var li = $('#img_list').find('li');
        var data = [];
        li.each(function (i, l) {
            data.push({url:$(l).find('img').attr('data-url'), desc:$(l).find('input').val()});
        });
        var content = window.editor.getContent();
        var blog_id = $('#blog_id').val();
        var tags = $('#tags').val();
        var post_data = {'title':data, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'image'};
        if (data_post != null) {
            post_data['id'] = data_post['id'];
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