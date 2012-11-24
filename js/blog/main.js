/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-22
 * Time: 上午9:29
 * To change this template use File | Settings | File Templates.
 */

$(function () {
    $('#toggle_follow').live('click', function (e) {
        var tog = $(this);
        if ($(this).attr('data-follow') == 1) {
            $.post(baseUrl + 'follow/follow/' + $(this).attr('data-id'), function (e) {
                if (e.code == 0) {
                    tog.attr('data-follow', 0);
                    tog.html('取消关注');
                }
            }, 'json');
        } else {
            $.post(baseUrl + 'follow/unfollow/' + $(this).attr('data-id'), function (e) {
                if (e.code == 0) {
                    tog.attr('data-follow', 1);
                    tog.html('关注');
                }
            }, 'json');
        }
    });

    var buildWriter = function (data) {

        var li = $('<li class="writer-item" data-id="' + data.id + '">' +
            '<div class="writer-info">' +
            '<div class="writer-avatar"><img src="' + baseUrl + data.avatar + '" alt="头像"></div>' +
            '<div class="writer-name"><a href="' + baseUrl + 'view/' + data.id + '">' + data.name + '</a></div>' +
            '<div class="writer-delete"><a href="javascript:;">X</a></div></div></li>');
        return li;

    };
    $('#add_writer_txt').keypress(function (e) {
        if (e.keyCode == 13) {
            $('#add_writer_btn').trigger('click');
        }
    });
    $('#add_writer_btn').click(function () {
        $.post(baseUrl + 'blog/addwriter/' + $('#blog_id_input').val(), {email:$('#add_writer_txt').val()}, function (e) {
            if (e.code == 0) {
                var li = buildWriter(e.data);
                li.hide();
                $('#add_writer_txt').val('');
                $('.writer-list').prepend(li);
                li.fadeIn(200);
            } else {
                alert('添加失败');
            }
        }, 'json');
    });

    $('.writer-delete').live('click', function () {
        var info = $(this).parents('.writer-item');
        var id = info.attr('data-id');
        $.post(baseUrl + 'blog/delwriter/' + $('#blog_id_input').val(), {writer:id}, function (e) {
            if (e.code == 0) {
                info.fadeOut(200, function () {
                    info.remove();
                });
            } else {
                alert('删除失败');
            }
        }, 'json');
    });
    $('.request-remove').click(function () {
        var item = $(this).parents('.request-item');
        $.post(baseUrl + 'blog/delrequest/' + item.attr('data-id'), function (e) {
            if (e.code == 0) {
                item.remove();
            } else {
                alert('删除失败');
            }
        }, 'json');
    });
    $('.request-pass').click(function () {
        var item = $(this).parents('.request-item');
        $.post(baseUrl + 'blog/passrequest/' + item.attr('data-id'), function (e) {
            if (e.code == 0) {
                item.remove();
                window.location.href = baseUrl;
            } else {
                alert('操作失败');
            }
        }, 'json');
    });
});
