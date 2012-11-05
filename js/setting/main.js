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
});