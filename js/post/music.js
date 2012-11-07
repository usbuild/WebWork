/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-11-6
 * Time: 下午11:04
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    /*
     $('input#title').change(function () {
     var page = 1;
     var api_url = 'http://kuang.xiami.com/app/nineteen/search/key/' + encodeURI($('input#title').val()) +'/logo/1/page/' + page;
     $.get(api_url, {}, function (e) {
     }, 'jsonp');
     });
     */
    var page = 1;
    var total = 0;
    $('input#title').autocomplete({
        source:function (request, response) {
            $.ajax({
                url:'http://kuang.xiami.com/app/nineteen/search/key/' + encodeURIComponent($('input#title').val()) + '/logo/1/page/' + page,
                dataType:'jsonp',
                data:{},
                success:function (data) {
                    total = data.total;
                    response($.map(data.results, function (item) {
                        return {
                            label:decodeURIComponent(item.song_name).replace(/\+/g, ' ') + ' - ' + decodeURIComponent(item.artist_name).replace('+', ' '),
                            data:item.song_id
                        }
                    }));
                }

            });
        },
        minLength:2,
        autoFocus:true,
        select:function (event, ui) {
            console.log(ui.item.data);
        },
        open:function () {
            var au = $('#auto_helper').clone().css('display', 'block');
            au.find('span').html(total);
            $(this).autocomplete('widget').append(au);
        },
        close:function () {

        }
    });

});
