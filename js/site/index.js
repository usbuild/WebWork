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
    var buildTagItem = function (e) {
        return $('<li class="tag-item"><a href="' + baseUrl + 'site/tagposts?tag=' + e + '" class="mi"><span class="icn icn-4"></span>' +
            '<span class="txt">' + e + '</span><span class="tag-close with-tip" data-tip="删除这个标签">X</span></a>');
    };

    $('#add_new_tag').live('keydown', function (e) {
        var new_tag = $(this);
        if (e.keyCode == 13) {
            $.post(baseUrl + '/follow/newtag', {tag: $(this).val()}, function (e) {
                if (e.code == 0) {
                    var item = buildTagItem(e.data.tag);
                    item.hide();
                    new_tag.parents('li').after(item);
                    item.animate({height: 'toggle'}, 200);
                    new_tag.val('');
                } else {
                    apprise('添加失败');
                }
            }, 'json');
        }
    });
    $(".follow-btn").click(function () {
        $.post(baseUrl + '/follow/newtag', {tag: $(this).data("tag")}, function (e) {
            if (e.code == 0) {
                var item = buildTagItem(e.data.tag);
                item.hide();
                $('#add_new_tag').parents('li').after(item);
                item.animate({height: 'toggle'}, 200);
                $('#add_new_tag').val('');
                $(".tag-follow").slideUp("slow");
            } else {
                apprise('添加失败');
            }
        }, 'json');
    });
    $('.tag-close').live('click', function (e) {
        e.stopPropagation();
        var tag = $(this).parents('a').find('.txt').html();
        var close_span = $(this);
        $.post(baseUrl + 'follow/deltag', {'tag': tag}, function (e) {
            if (e.code == 0) {
                close_span.parents('li').animate({height: 'toggle'}, 200, function () {
                    close_span.remove();
                });
            } else {

            }
        }, 'json');

        return false;
    });

    $('.writer-close').live('click', function (e) {
        e.stopPropagation();
        var li = $(this).parents('li');
        var id = li.attr('data-id');
        $.post(baseUrl + 'blog/delWriter/' + id, {}, function (e) {
            if (e.code == 0) {
                li.remove();
            } else {
                apprise('删除失败');
            }
        }, 'json');
        return false;
    });

    $('.writer-add').live('click', function (e) {
        e.stopPropagation();
        var id = $(this).parents('li').attr('data-id');
        window.open(baseUrl + 'writer/write/' + id);
        return false;
    });
});