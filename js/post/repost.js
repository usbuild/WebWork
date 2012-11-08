/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-11-8
 * Time: 下午11:43
 * To change this template use File | Settings | File Templates.
 */
$(function(){
    $('.music-input').each(function (i, item) {
        var input = $(this);
        var data = json_decode(input.attr('data-song'));
        var div = $('<div class="clearfix"></div>');
        input.after(div);

        var img = $('<img/>');
        var small_logo = data.album_logo;
        var big_log = small_logo.substring(0, small_logo.length - 5) + '4.jpg';
        img.attr('src', big_log)
            .attr('width', 164)
            .css('float', 'left');
        var em = '<embed src="http://www.xiami.com/widget/0_' + data.song_id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed>';

        var xiami_container = $('<div></div>');
        xiami_container.addClass('xiami-container');
        if ($.browser.webkit) {
            var iframe;
            iframe = $('<iframe frameborder="0" style=""></iframe>');
            div.append(img).append(xiami_container.append(iframe));
            iframe.addClass('xiamiframe');
            iframe.contents().find('body').html(em).css('margin', '0');
        } else {
            div.append(img).append(xiami_container);
            xiami_container.html(em);
        }
    });
});
