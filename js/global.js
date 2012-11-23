/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-26
 * Time: 上午10:20
 * To change this template use File | Settings | File Templates.
 */
//var baseUrl = 'http://localhost/blog/';
var json_decode = function (e) {
    return eval('(' + e + ')');
};
var json_encode = function (e) {
    return JSON.stringify(e);
};
var setActive = function (id) {
    $('li a.active').removeClass('active');
    if ($('#' + id).length > 0)
        $('#' + id).addClass('active');
};

var renderMusic = function (input) {
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
    input.remove();
};
$(function () {
    if ($('#blog_id_input').length > 0) {
        if (isNaN(parseInt($('#blog_id_input').val())))
            setActive($('#blog_id_input').val());
        else setActive('blog_id_' + $('#blog_id_input').val());
    }

    $('.feed').live('mouseenter',function () {
        $(this).find('.link-to-post-holder').css('display', '');
    }).live('mouseleave', function () {
            $(this).find('.link-to-post-holder').css('display', 'none');
        });
});
