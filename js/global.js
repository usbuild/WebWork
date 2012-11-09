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
$(function () {
    if ($('#blog_id_input').length > 0) {
        setActive('blog_id_' + $('#blog_id_input').val());
    }

    $('.feed').live('mouseenter',function () {
        $(this).find('.link-to-post-holder').css('display', '');
    }).live('mouseleave', function () {
            $(this).find('.link-to-post-holder').css('display', 'none');
        });
});
