/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-5
 * Time: 下午9:08
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    $('#renew_pass').submit(function (evt) {
        evt.preventDefault();
        if ($('#new_pass').val().length < 5 || $('#new_pass').val() != $('#repeat_pass').val()) {
            $('#pass_error').html('两次密码不一致').css('display', 'block');
            return;
        }

        $.post(baseUrl + 'setting/newpassword', {old_pass:$('#old_pass').val(), new_pass:$('#new_pass').val()},
            function (e) {
                var obj = json_decode(e);
                if (obj.code == 0) {
                    $('#pass_error').html('密码修改成功').css('display', 'block');
                } else {
                    $('#pass_error').html(obj.data).css('display', 'block');
                }
            });
    });
    $('#upload_btn').click(function (e) {
        $('#file').trigger('click');
    });

    var selectImg = null;
    $('#file').change(function (e) {
        var file = $('#file').get(0).files[0];
        var reader = new FileReader();
        var img = $('#upload_img');
        reader.onload = function (e) {
            img.attr('src', e.target.result);
            img.attr('alt', file.name);
            img.attr('width', '400px');
            selectImg = img.imgAreaSelect({
                aspectRatio:'1:1',
                handles:true,
                instance:true,
                minWidth:60
            });
            selectionArea = null;
//            $('.upload-img-box').css('display', 'block');
            $('.upload-img-box').show();
        };
        reader.readAsDataURL(file);
    });
    $('#img_ok').click(function () {
            var selection = selectImg.getSelection();
            if (selection.width == 0) {
                alert('请先选择区域');
                return;
            }
            var form = $('#img_form').get(0);
            var f = new FormData(form);
            f.append('x1', selection.x1);
            f.append('y1', selection.y1);
            f.append('width', selection.width);
            f.append('height', selection.height);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', baseUrl + 'picture/avatarupload');
            xhr.send(f);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var obj = json_decode(xhr.responseText);
                    if (obj.code == 0) {
                        $('.blog_avatar img').attr('src', obj.data);
                        $('.upload-img-box').hide();
                        selectImg.cancelSelection();
                    } else {
                        alert('上传失败');
                    }
                }
            };
        }
    );

    $('#img_cancel').click(function () {
        $('.upload-img-box').hide();
        selectImg.cancelSelection();
    });

})
;