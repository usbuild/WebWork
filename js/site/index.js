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
});