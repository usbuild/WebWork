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
        renderMusic(input);
    });
});
