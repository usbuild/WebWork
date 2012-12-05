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

    var blog = json_decode($('[data-blog]').attr('data-blog'));
    var is_request = $('#is_request').val();
    var post_url;
    if (is_request == 1) {
        post_url = baseUrl + 'writer/request/' + blog.id;
    } else {
        post_url = baseUrl + 'post';
    }
    var prepareText = function () {
        var activeArea = $('#current_type #post_text');
        var $$ = function (x) {
            return $(x, activeArea)
        };

        $('#submit').unbind('click');
        $('#submit').bind('click', function () {
            var title = $$('#title').val();
            var content = window.editor.getContent();
            var blog_id = blog.id;
            var tags = $('#tags').val();

            var post_data = {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'text', 'write':1};
            $.post(post_url, post_data, function (obj) {
                if (obj.code == 0) {
                    window.location.href = baseUrl;
                } else {
                    apprise('发表失败');
                }
            }, 'json');
        });
    };


    var prepareMusic = function () {
        var activeArea = $('#current_type #post_music');
        var $$ = function (x) {
            return $(x, activeArea)
        };

        $('#submit').unbind('click');
        $('#submit').bind('click', function () {
            if ($$('#thumb_box').is(':visible')) {
                var old_data = $('.xiami-container').data('id');
                var content = window.editor.getContent();
                var blog_id = blog.id;
                var tags = $('#tags').val();

                var title = {};
                for (var i in old_data) {
                    title[i] = decodeURIComponent(old_data[i]);
                }
                var post_data = {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'music', 'write':1};

                $.post(post_url, post_data, function (obj) {
                    if (obj.code == 0) {
                        window.location.href = baseUrl;
                    } else {
                        apprise('发表失败');
                    }
                }, 'json');
            } else {
                apprise('请选择歌曲');
            }
        });
        var setMusic = function (data) {
            $$('#thumb_box img').remove();
            $$('#thumb_box .xiami-container').remove();
            $$('#title').val(data.song_name);
            var img = $('<img/>');
            img.attr('src', data.album_logo).css('float', 'left');
            var em = '<embed src="http://www.xiami.com/widget/0_' + data.song_id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="300" height="40" wmode="transparent"></embed>';
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
            var li = $$('#img_list').find('li');
            var data = [];
            li.each(function (i, l) {
                data.push({url:$(l).find('img').attr('data-url'), desc:$(l).find('input').val()});
            });
            var content = window.editor.getContent();
            var blog_id = blog.id;
            var tags = $('#tags').val();
            var post_data = {'title':data, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'image', 'write':1};

            $.post(post_url, post_data, function (obj) {
                if (obj.code == 0) {
                    window.location.href = baseUrl;
                } else {
                    apprise('发表失败');
                }
            }, 'json');
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
                apprise('上传文件失败');
            }
        });
        $$('#upload_btn').click(function () {
            $$('#fileupload').trigger('click');
        });
    };
    var prepareVideo = function () {
        var activeArea = $('#current_type #post_video');
        var $$ = function (x) {
            return $(x, activeArea)
        };
        $('#submit').unbind('click');
        $('#submit').bind('click', function () {
            var title = $$('#title').val();
            var content = window.editor.getContent();
            var blog_id = blog.id;
            var tags = $('#tags').val();
            if (!valid) {
                apprise('请输入有效的视频地址');
                return;
            }
            var post_data = {'title':$$('#video_info').val(), 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'video', 'write':1};
            $.post(post_url, post_data, function (obj) {
                if (obj.code == 0) {
                    window.location.href = baseUrl;
                } else {
                    apprise('发表失败');
                }
            }, 'json');

        });

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
        var activeArea = $('#current_type #post_link');
        var $$ = function (x) {
            return $(x, activeArea)
        };
        $('#submit').unbind('click');
        $('#submit').bind('click', function () {
            var content = window.editor.getContent();
            var blog_id = blog.id;
            var tags = $('#tags').val();
            if ($$('#link').val().trim().length == 0) {
                apprise('链接不能为空');
                return;
            }
            var title = {'title':$$('#title').val(), 'link':$$('#link').val()};
            var post_data = {'title':title, 'content':content, 'blog_id':blog_id, 'tags':tags, 'type':'link', 'write':1};

            $.post(post_url, post_data, function (obj) {
                if (obj.code == 0) {
                    window.location.href = baseUrl;
                } else {
                    apprise('发表失败');
                }
            }, 'json');
        });
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