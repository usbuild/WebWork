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
                            data:item
                        }
                    }));
                }

            });
        };
    };


    $('input#title').autocomplete({
        source:getSource(1),
        autoFocus:true,
        focus:function (e, ui) {
            return false;
        },
        select:function (e, ui) {
            var data = ui.item.data;
            $('#thumb_box img').remove();
            $('#thumb_box iframe').remove();
            var img = $('<img/>');
            img.attr('src', data.album_logo);
            var em = '<div class="embedWrap ztag"><embed src="http://www.xiami.com/widget/0_' + data.song_id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed></div>';
            var iframe = $('<iframe frameborder="0"></iframe>');
            $('#thumb_box').append(img).append(iframe);
            iframe.contents().find('body').html(em).css('margin', '0');
            iframe.data('id', data);
            iframe.addClass('xiamiframe');
            $('input#title').hide();
            $('#thumb_box').show();
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
            .append("<a>" + item.label + "<span style='color: #ccc;'>  -  " + item.artist + "</span></a>")
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

    $('#close_btn').click(function () {
        $('#thumb_box').hide();
        $('input#title').show();
    });

    $('#submit').click(function () {
        if ($('#thumb_box').is(':visible')) {
            var old_data = $('.xiamiframe').data('id');
            var content = window.editor.getContent();
            var blog_id = $('#blog_id').val();
            var tags = $('#tags').val();

            var title = {};
            for (var i in old_data) {
                title[i] = decodeURIComponent(old_data[i]);
            }

            $.post(baseUrl + 'post', {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'music'}, function (e) {
                var obj = json_decode(e);
                if (obj.code == 0) {
                    alert('发表成功');

//                    window.location.reload();
                } else {
                    alert('发表失败');
                }
            });
        } else {
            alert('请选择歌曲');
        }
    });
});
