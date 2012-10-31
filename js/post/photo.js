/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-10-31
 * Time: 下午11:17
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {
    $("#pic_file").fileupload({
        url: baseUrl + '/picture/jqupload',
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $('<p/>').text(file.name).appendTo(document.body);
            });
        }
    });
});