$(function () {
    $('#toggle_follow').click(function (e) {
        var tog = $(this);
        if ($(this).data('follow')) {
            $.post(baseUrl + 'follow/follow/' + $(this).attr('data-id'), function (e) {
                if (e.code == 0) {
                    tog.data('follow', 0);
                    tog.html('取消关注');
                }
            }, 'json');
        } else {
            $.post(baseUrl + 'follow/unfollow/' + $(this).attr('data-id'), function (e) {
                if (e.code == 0) {
                    tog.data('follow', 1);
                    tog.html('关注');
                }
            }, 'json');
        }
    });
});