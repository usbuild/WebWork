/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-23
 * Time: 下午3:09
 * To change this template use File | Settings | File Templates.
 */


$(function () {
    $('#tags').tagsInput({
        defaultText:'',
        height:'auto',
        width:'auto',
        removeWithBackspace:true });
    $('select').jqTransSelect();
    window.editor = new baidu.editor.ui.Editor();
    window.editor.render("myEditor");


    var prepareText = function () {
        var activeArea = $('#current_type #post_music');
        var $$ = function (x) {
            return $(x, activeArea)
        };
        $('#submit').unbind('click');
        $('#submit').click(function () {
            alert('text');
        });
    };


    var prepareMusic = function () {
        $('#submit').unbind('click');
        $('#submit').click(function () {
            alert('music');
        });
        var activeArea = $('#current_type #post_music');
        var $$ = function (x) {
            return $(x, activeArea)
        };
        var setMusic = function (data) {
            $$('#thumb_box img').remove();
            $$('#thumb_box .xiami-container').remove();
            $$('#title').val(data.song_name);
            var img = $('<img/>');
            img.attr('src', data.album_logo).css('float', 'left');
            var em = '<embed src="http://www.xiami.com/widget/0_' + data.song_id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed>';
            var xiami_container = $('<div></div>');
            xiami_container.addClass('xiami-container').data('id', data);
            if ($.browser.webkit) {
                var iframe;
                iframe = $('<iframe frameborder="0" style=""></iframe>');
                $$('#thumb_box').append(img).append(xiami_container.append(iframe));
                iframe.contents().find('body').html(em).css('margin', '0');
                iframe.addClass('xiamiframe');

            } else {
                $$('#thumb_box').append(img).append(xiami_container);
                xiami_container.html(em);
            }
            $$('#title').hide();
            $$('#thumb_box').show();
        };

        //for music --start--
        var page = 1;
        var list_data = null;
        $$('#title').live('keydown', function () {
            if (page != 1) {
                page = 1;
                $$('#title').autocomplete('option', 'source', getSource(page)).autocomplete('search', $$('#title').val());
            }
        });
        var getSource = function (page) {
            return function (request, response) {
                $.ajax({
                    url:'http://kuang.xiami.com/app/nineteen/search/key/' + encodeURIComponent($$('input#title').val()) + '/logo/1/page/' + page,
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

        $$('#title').autocomplete({
            source:getSource(1),
            autoFocus:true,
            focus:function (e, ui) {
                return false;
            },
            select:function (e, ui) {
                var data = ui.item.data;
                setMusic(data);
            },
            open:function () {
                var au = $('#auto_helper').clone().css('display', 'block');
                au.find('span#total').html(list_data.total);
                $(this).autocomplete('widget').append(au);
                $(this).autocomplete('widget').css('width', ($$('#title').width() + 18 - 40) + 'px').css('left', ($$('#title').offset().left + 18) + 'px');
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
            $$('#title').autocomplete('option', 'source', getSource(page)).autocomplete('search', $$('#title').val());
        });
        $('#prev_page').live('click', function () {
            page--;
            $$('#title').autocomplete('option', 'source', getSource(page)).autocomplete('search', $$('#title').val());
        });

        $$('#close_btn').click(function () {
            $$('#thumb_box').hide();
            $$('#title').show();
        });
    };
    //for music --end--
    var prepareImage = function () {
        $('#submit').unbind('click');
        $('#submit').click(function () {
            alert('image');
        });
        var activeArea = $('#current_type #post_image');
        var $$ = function (x) {
            return $(x, activeArea)
        };

        var dropElement = $$('.upload-img-box');

        $(document).bind('dragover', function (e) {
            var timeout = window.dropZoneTimeout;
            if (!timeout) {
                $$('#hover_text').removeClass('hidden');
                $$('#original_text').addClass('hidden');
            } else {
                clearTimeout(timeout);
            }
            if (dropElement.has(e.target).length > 0 || e.target == dropElement.get(0)) {
                dropElement.addClass('upload-img-box-drag');
            } else {
                dropElement.removeClass('upload-img-box-drag');
            }
            window.dropZoneTimeout = setTimeout(function () {
                window.dropZoneTimeout = null;
                $$('#hover_text').addClass('hidden');
                $$('#original_text').removeClass('hidden');
                dropElement.removeClass('upload-img-box-drag');
            }, 100);
        });
        $(document).bind('drop dragover', function (e) {
            e.preventDefault();
        });


        $$('#img_list').sortable({handle:'.move', revert:'true'});

        $$('div.close').live('click', function () {
            $(this).parents('li').remove();
        });
        $$('#fileupload').fileupload({
            dataType:'json',
            add:function (e, data) {
                $.each(data.files, function (index, file) {

                    file.id = Date.parse(new Date()) + parseInt(Math.random() * 1000);
                    var div = $$('#proto_progress').clone().removeClass('hidden');
                    div.attr('id', file.id);
                    var img = div.find('img');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                        img.attr('alt', file.name);
                        img.attr('width', '60px');
                        img.attr('height', '60px');
                        $$('#progress_box').append(div);
                    };
                    reader.readAsDataURL(file);


                });
                data.submit();
            },

            done:function (e, data) {
                $.each(data.result, function (index, file) {
                    var id = data.files[0].id;
                    $$('#' + id).remove();

                    var template = $$('#proto_box').clone().removeClass('hidden').attr('id', id);
                    var li = $('<li></li>');
                    var img = template.find('img');
                    img.attr('src', file.thumbnail_url);
                    img.attr('data-url', file.url);
                    img.attr('alt', file.name);
                    img.attr('width', '60px');
                    img.attr('height', '60px');
                    li.append(template);
                    $$('#img_list').append(li);
                });
            },
            progress:function (e, data) {
                var id = data.files[0].id;
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $$('#' + id).find('.value').css('width', progress + '%');
            },
            dragover:function (e, data) {
                dropElement.addClass('upload-img-box-drag');
            },
            dropZone:dropElement,
            fail:function (e, data) {
                alert('上传文件失败');
            }
        });
        $$('#upload_btn').click(function () {
            $$('#fileupload').trigger('click');
        });
    };
    var prepareVideo = function () {
        $('#submit').unbind('click');
        $('#submit').click(function () {
            alert('image');
        });
        var activeArea = $('#current_type #post_video');
        var $$ = function (x) {
            return $(x, activeArea)
        };
        var valid = false;
        var setVideo = function () {
            var url = $$('#title').val();
            $$('#title').hide();
            var img = $('<img/>');
            img.attr('src', baseUrl + 'images/loading.gif')
                .attr('alt', '加载中').attr('width', '128px').attr('height', '96px');
            $$('#thumb_box img').remove();
            $$('#thumb_box').append(img).show();
            $.ajax({
                url:baseUrl + 'post/getVideoInfo',
                type:'POST',
                data:{link:url},
                success:function (e) {
                    if (e.code == 0) {
                        $$('#thumb_box img').attr('src', e.data.img)
                            .attr('alt', '缩略图');
                        valid = true;
                        $$('#video_info').val(json_encode(e.data));
                    }
                },
                error:function (e) {
                    $$('#thumb_box').hide();
                    $$('input#title').show().trigger('focus');
                    valid = false;
                },
                dataType:'json'
            });
        };

        $$('#title').blur(function () {
            setVideo();
        });

        $$('#close_btn').click(function () {
            $$('#thumb_box').hide();
            $$('input#title').show().trigger('focus');
            valid = false;
        });
    };
    var prepareLink = function () {
    };


    $('#post_type').change(function () {
        var type = $('#post_type').val();
        var container = $('#current_type');
        container.html('');
        switch (type) {
            case 'text':
                container.append($('#post_text').clone());
                prepareText();
                break;
            case 'image':
                container.append($('#post_image').clone());
                prepareImage();
                break;
            case 'music':
                container.append($('#post_music').clone());
                prepareMusic();
                break;
            case 'video':
                container.append($('#post_video').clone());
                prepareVideo();
                break;
            case 'link':
                container.append($('#post_link').clone());
                prepareLink();
                break;
        }
    }).trigger('change');

});