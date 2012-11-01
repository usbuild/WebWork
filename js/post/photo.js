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
        dropElement.removeClass('drop-hover');
    });


    $(document).bind('dragenter dragover', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = "none";
        $('.upload-img-box span').html('拖动多张图片到这里，直接上传');
    });
    $(document).bind('dragleave', function (e) {
        $('.upload-img-box span').html('jpg、gif、png或bmp格式，单张图片不超过2MB，支持文件拖拽上传。');
    });
    $('#fileupload').fileupload({
        dataType:'json',
        done:function (e, data) {
            $('#progress .bar').css('display', 'none');
            $.each(data.result, function (index, file) {
                var img = $('<img/>');
                img.attr('src', file.thumbnail_url);
                img.attr('alt', file.name);
                $('#img_list').append(img);
            });
        },
        progressall:function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css('display', 'block');
            $('#progress .bar').css('width', progress + '%');
        },
        dragover:function (e, data) {
            e.originalEvent.dataTransfer.dropEffect = "move";
            dropElement.addClass('drop-hover');
            e.stopPropagation();
        },
        dropZone:dropElement
    });
    $('#upload_btn').click(function () {
        $('#fileupload').trigger('click');
    });

});