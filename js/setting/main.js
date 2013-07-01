/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-5
 * Time: 下午9:08
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    $('.container').addClass('lf-container');

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

    $("#new_pass").passStrengthify({
        levels:levels = ['很弱', '很弱', '弱', '弱', '一般',
            '一般', '强', '很强'],
        minimum:5,
        labels:{
            tooShort:'太短',
            passwordStrength:'密码强度'
        }});

    $("[type=password]").keyup(function () {
        if ($("#repeat_pass").val() == $("#new_pass").val())
            $(".repeat-validate").html("密码匹配").css("color", "green");
        else
            $(".repeat-validate").html("密码不匹配").css("color", "red");
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
            $('.upload-img-box').show();
        };
        reader.readAsDataURL(file);
    });
    $('#img_ok').click(function () {
            var selection = selectImg.getSelection();
            if (selection.width == 0) {
                apprise('请先选择区域');
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
                        $('.blog_avatar img').attr('src', baseUrl + obj.data);
                        $('.blog_avatar img').attr('data-avatar', obj.data);
                        $('.upload-img-box').hide();
                        selectImg.cancelSelection();
                    } else {
                        apprise('上传失败');
                    }
                }
            };
        }
    );

    $('#img_cancel').click(function () {
        $('.upload-img-box').hide();
        selectImg.cancelSelection();
    });
    $('input[type=submit]').click(function (e) {
        e.preventDefault();
        var avatar = $('.blog_avatar img').attr('data-avatar');
        var name = $('#blog_name').val();
        var domain = $('#blog_domain').val();
        var id = $('#blog_id_input').val();
        $.post(baseUrl + 'setting/blog/' + id, {'avatar':avatar, 'name':name, 'domain':domain}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                apprise('更新成功');
                window.location.href = baseUrl + '/setting';
            } else {
                apprise('更新失败');
            }
        });
    });

})
;