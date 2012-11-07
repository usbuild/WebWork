$(document).ready(function () {
    $('.music-input').each(function (i, item) {
        var input = $(this);
        var data = json_decode(input.attr('data-song'));
        var div = $('<div></div>');
        input.after(div);

        var img = $('<img/>');
        var small_logo = data.album_logo;
        var big_log = small_logo.substring(0, small_logo.length - 5) + '4.jpg';
        img.attr('src', big_log);
        img.attr('width', 164);
        var em = '<embed src="http://www.xiami.com/widget/0_' + data.song_id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed>';
        var iframe = $('<iframe frameborder="0" style="top: -195px;"></iframe>');
        div.append(img).append(iframe);
        iframe.data('id', data.song_id)
            .addClass('xiamiframe');

        if ($.browser.mozilla) {
            setTimeout(function () {
                iframe.contents().find('body').html(em).css('margin', '0');
            }, 100);
        } else {
            iframe.contents().find('body').html(em).css('margin', '0');
        }
    });

});