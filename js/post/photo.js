/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-10-31
 * Time: 下午11:17
 */
$(document).ready(function () {
    jQuery.event.props.push('dataTransfer');
    var dropElement = $('.upload-img-box');

    dropElement.bind('dragleave drop dragend', function (e) {
        dropElement.removeClass('upload-img-box-drag');
    });


    $(document).bind('dragenter dragover', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = "move";
        $('.upload-img-box span').html('拖动多张图片到这里，直接上传');
    });
    $(document).bind('drop', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = "none";
    });

    $(document).bind('dragleave', function (e) {
        $('.upload-img-box span').html('jpg、gif、png或bmp格式，单张图片不超过2MB，支持文件拖拽上传。');
    });
    $('#img_list').sortable().change(function(e){
        console.dir(e);
    });

    $('#fileupload').fileupload({
        dataType:'json',
        done:function (e, data) {
            $('#progress .bar').css('display', 'none');
            $.each(data.result, function (index, file) {
                var li = $('<li></li>')
                var img = $('<img/>');
                img.attr('src', file.thumbnail_url);
                img.attr('alt', file.name);
                li.append(img);
                $('#img_list').append(li);
            });
        },
        progressall:function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css('display', 'block');
            $('#progress .bar').css('width', progress + '%');
        },
        dragover:function (e, data) {
            e.originalEvent.dataTransfer.dropEffect = "move";
            $('.upload-img-box span').html('拖动多张图片到这里，直接上传');
            dropElement.addClass('upload-img-box-drag');
            e.stopPropagation();
        },
        dropZone:dropElement
    });
    $('#upload_btn').click(function () {
        $('#fileupload').trigger('click');
    });

});