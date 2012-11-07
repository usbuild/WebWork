/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-11-6
 * Time: 下午11:04
 * To change this template use File | Settings | File Templates.
 */
$(function () {
    var page = 1;
    var list_data = null;
    $('input#title').keydown(function () {
        if (page != 1) {
            page = 1;
            $('input#title').autocomplete('option', 'source', getSource(page)).autocomplete('search', $('input#title').val());
        }
    });

    var getSource = function (page) {
        return function (request, response) {
            $.ajax({
                url:'http://kuang.xiami.com/app/nineteen/search/key/' + encodeURIComponent($('input#title').val()) + '/logo/1/page/' + page,
                dataType:'jsonp',
                data:{},
                success:function (data) {
                    list_data = data;

                    $('#next_page').hide();
                    $('#prev_page').hide();
                    if ((page - 1) * 8 + list_data.results.length < list_data.total) {
                        $('#next_page').show();
                    }
                    if (page > 1) {
                        $('#prev_page').show();
                    }

                    response($.map(data.results, function (item) {
                        return {
                            label:decodeURIComponent(item.song_name).replace(/\+/g, ' '),
                            artist:decodeURIComponent(item.artist_name).replace(/\+/g, ' '),
                            data:item.song_id
                        }
                    }));
                }

            });
        };
    };


    $('input#title').autocomplete({
        source:getSource(1),
        minLength:2,
        autoFocus:true,
        focus:function (e, ui) {
            return false;
        },
        select:function (e, ui) {
            console.dir(ui.item.data);
        },
        open:function () {
            var au = $('#auto_helper').clone().css('display', 'block');
            au.find('span#total').html(list_data.total);
            $(this).autocomplete('widget').append(au);
        },
        close:function () {

        }
    }).data("autocomplete")._renderItem = function (ul, item) {
        return $("<li>")
            .data("item.autocomplete", item)
            .append("<a>" + item.label + "<small>  -  " + item.artist + "</small></a>")
            .appendTo(ul);
    };


    $('#next_page').live('click', function () {
        page++;
        $('input#title').autocomplete('option', 'source', getSource(page)).autocomplete('search', $('input#title').val());
    });
    $('#prev_page').live('click', function () {
        page--;
        $('input#title').autocomplete('option', 'source', getSource(page)).autocomplete('search', $('input#title').val());
    });


});
