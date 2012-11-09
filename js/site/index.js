$(document).ready(function () {
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

    var buildCmtList = function (item) {
        var li = $('<li></li>');
        li.addClass('cmt-item').addClass('clearfix');

        var img = $('<img />');
        img.attr('src', baseUrl + item.blog.avatar).addClass('cmt-item-img');


        var content = $('<div></div>');

        var name = $('<span class="cmt-item-name"><a>' + item.blog.name + '</a></span>');
        content.append(name);

        if (item.reply_id != null) {
            content.append('<span class="cmt-item-reply-name">回复 <a>' + item.reply.name + '</a> :</span>');
        }
        content.append(item.content);

        content.addClass('cmt-item-content');

        var operation;
        if (item.isme) {
            operation = $('<div><a data-id="' + item.id + '">删除</a></div>');
            operation.addClass('cmt-item-delete')
        } else {
            operation = $('<div><a>回复</a></div>');
            operation.addClass('cmt-item-reply')
        }
        li.append(img).append(content).append(operation);
        li.data('item', item);
        return li;
    };

    var buildNtList = function (item) {
        var li = $('<li></li>');
        li.addClass('nt-item').addClass('clearfix');
        var img = $('<img/>');
        var content = $('<div></div>');
        img.attr('src', baseUrl + item.avatar).addClass('nt-item-img');

        var name = $('<span class="nt-item-name"><a>' + item.name + '</a></span>');
        content.append(name);
        if (item.type == 1) {
            content.append('喜欢此文章');
        } else if (item.type == 0) {
            content.append('评论了此文章');
        } else {
            content.append('转载了此文章');
        }
        content.addClass('nt-item-content');
        li.append(img).append(content);
        li.data('item', item);
        return li;
    };

    $('.feed-cmt').click(function () {

        var feed = $(this).parents('.feed');
        if (feed.find('.notes').is(':visible')) {
            feed.find('.feed-ft').animate({height:'toggle'}, 300);
            setTimeout(function () {
                feed.find('.notes').hide();
                feed.find('.comment').show();
            }, 300)
        } else {
            feed.find('.notes').hide();
            feed.find('.comment').show();
            feed.find('.feed-container-bottom').toggle();
        }


        feed.find('.feed-ft-triangle').css('left', '410px');
        feed.find('.feed-ft').animate({height:'toggle'}, 300);
        feed.find('textarea.cmt-content').get(0).focus();
        var post_id = feed.attr('data-id');
        var start = 0;

        if (!feed.attr('data-cmt')) {
            feed.find('.cmt-load-more').html('正在加载...').css('disabled', 'disabled');
            $.post(baseUrl + 'comment/fetch', {id:post_id, offset:start}, function (obj) {
                var cmt_list = feed.find('.cmt-list');
                $.each(obj, function (i, item) {
                    var li = buildCmtList(item);
                    li.hide();
                    cmt_list.append(li);
                    li.animate({height:'toggle'}, 100);
                });

                cmt_list.data('show-cmt', obj.length);
                if (obj.length == 10) {
                    feed.find('.cmt-load-more').html('显示更多').css('disabled', 'enabled').show();
                } else {
                    feed.find('.cmt-load-more').hide();
                }
            }, 'json');
        }
        feed.attr('data-cmt', true);
    });


    $('.feed-nt').click(function () {
        var feed = $(this).parents('.feed');
        if (feed.find('.comment').is(':visible')) {
            feed.find('.feed-ft').animate({height:'toggle'}, 300);
            setTimeout(function () {
                feed.find('.notes').show();
                feed.find('.comment').hide();
            }, 300)

        } else {
            feed.find('.notes').show();
            feed.find('.comment').hide();
            feed.find('.feed-container-bottom').toggle();
        }

        feed.find('.feed-ft-triangle').css('left', '353px');
        feed.find('.feed-ft').animate({height:'toggle'}, 300);

        var post_id = feed.attr('data-id');
        var start = 0;
        if (!feed.attr('data-nt')) {
            feed.find('.nt-load-more').html('正在加载...').css('disabled', 'disabled');
            $.post(baseUrl + 'post/fetchHots', {id:post_id, offset:start}, function (obj) {
                var nt_list = feed.find('.nt-list');
                $.each(obj, function (i, item) {
                    var li = buildNtList(item);
                    li.hide();
                    nt_list.append(li);
                    li.animate({height:'toggle'}, 100);
                });

                nt_list.data('show-nt', obj.length);
                if (obj.length == 10) {
                    feed.find('.nt-load-more').html('显示更多').css('disabled', 'enabled').show();
                } else {
                    feed.find('.nt-load-more').hide();
                }
            }, 'json');
        }
        feed.attr('data-nt', true);

    });

    $('.slide-up').click(function () {
        var feed = $(this).parents('.feed');
        feed.find('.feed-ft').animate({height:'toggle'}, 300);
        feed.find('.feed-container-bottom').toggle();
    });

    $('.cmt-submit').click(function () {
        var feed = $(this).parents('.feed');
        var content = feed.find('.cmt-content');
        var post_data;
        if (content.data('reply') && content.val().indexOf(content.data('reply')) == 0) {
            post_data = {'comment[post_id]':feed.attr('data-id'), 'comment[content]':content.val().substr(content.data('reply').length), 'comment[reply_id]':content.data('reply_id')};
        } else {
            post_data = {'comment[post_id]':feed.attr('data-id'), 'comment[content]':content.val()};
        }
        $.post(baseUrl + 'comment/add', post_data, function (obj) {
            if (obj.code == 0) {
                feed.find('.cmt-content').val('').css('height', '50px');

                var li = buildCmtList(obj.data);
                li.hide();
                feed.find('.cmt-list').prepend(li);
                li.animate({height:'toggle'}, 300);
                incCmt(feed);
            } else {
                alert('发表失败');
            }
        }, 'json');
    });

    $('.cmt-load-more').click(function () {
        var feed = $(this).parents('.feed');
        var cmt_list = feed.find('.cmt-list');
        var start = cmt_list.data('show-cmt');
        var load_more = $(this);
        load_more.html('正在加载...').css('disabled', 'disabled');
        $.post(baseUrl + 'comment/fetch', {id:feed.attr('data-id'), offset:start}, function (obj) {
            $.each(obj, function (i, item) {
                var li = buildCmtList(item);
                li.hide();
                cmt_list.append(li);
                li.animate({height:'toggle'}, 100);
            });

            cmt_list.data('show-cmt', start + obj.length);
            if (obj.length < 10) {
                load_more.hide();
            } else {
                load_more.html('显示更多').css('disabled', 'enabled');
            }
        }, 'json');
    });

    $('.nt-load-more').click(function () {
        var feed = $(this).parents('.feed');
        var nt_list = feed.find('.nt-list');
        var start = nt_list.data('show-nt');
        var load_more = $(this);
        load_more.html('正在加载...').css('disabled', 'disabled');
        $.post(baseUrl + 'post/fetchHots', {id:feed.attr('data-id'), offset:start}, function (obj) {
            $.each(obj, function (i, item) {
                var li = buildNtList(item);
                li.hide();
                nt_list.append(li);
                li.animate({height:'toggle'}, 100);
            });

            nt_list.data('show-nt', start + obj.length);
            if (obj.length < 10) {
                load_more.hide();
            } else {
                load_more.html('显示更多').css('disabled', 'enabled');
            }
        }, 'json');
    });


    $('.feed-fav').click(function () {
        var feed = $(this).parents('.feed');
        var id = feed.attr('data-id');
        var heart = $(this);
        heart.attr('disabled', 'disabled');

        if (heart.hasClass('feed-faved')) {
            $.get(baseUrl + 'like/unlike/' + id, {}, function (e) {
                if (e.code == 0) {
                    heart.removeClass('feed-faved').attr('title', '喜欢');
                    decHot(feed);
                }
                heart.attr('disabled', 'enabled');
            }, 'json');
        } else {
            $.get(baseUrl + 'like/like/' + id, {}, function (e) {
                if (e.code == 0) {
                    heart.addClass('feed-faved').attr('title', '取消喜欢');
                    incHot(feed);
                }
                heart.attr('disabled', 'enabled');

            }, 'json');
        }
    });
    $('.cmt-item-delete a').live('click', function () {
        var item = $(this);
        $.get(baseUrl + 'comment/del/' + $(this).attr('data-id'), {}, function (e) {
            if (e.code == 0) {
                item.parents('.cmt-item').animate({height:'toggle'}, 300);
                decCmt(item.parents('.feed'));
            } else {
                alert('删除失败');
            }
        }, 'json');
    });
    $('textarea.cmt-content').live('keydown', function (e) {
        var text = $(this);
        if (e.keyCode == 13 && e.ctrlKey) {
            text.next().trigger('click');
        }
    });
    $('.cmt-item-reply a').live('click', function () {
        var li = $(this).parents('li');
        var item = li.data('item');
        var feed = li.parents('.feed');
        var reply_string = '回复 ' + item.blog.name + ' :';

        feed.find('.cmt-content').val(reply_string + ' ').data('reply', reply_string).data('reply_id', item.blog_id);
        var len = feed.find('.cmt-content').val().length;
        locateCursor(feed.find('.cmt-content').get(0), len);
    });


    $('.feed-faved').attr('title', '取消喜欢');
    $('textarea').autosize({append:"\n"});


    var locateCursor = function (txtElement, pos) {
        if (txtElement.setSelectionRange) {
            txtElement.focus();
            txtElement.setSelectionRange(pos, pos);
        } else if (txtElement.createTextRange) {
            var range = txtElement.createTextRange();
            range.moveStart('character', pos);
            range.select();
        }
    };
    var incHot = function (feed) {
        feed.find('.cmt-hot-count').html(parseInt(feed.find('.cmt-hot-count').html()) + 1);
    };
    var decHot = function (feed) {
        feed.find('.cmt-hot-count').html(feed.find('.cmt-hot-count').html() - 1);
    };
    var incCmt = function (feed) {
        incHot(feed);
        feed.find('.cmt-reply-count').html(parseInt(feed.find('.cmt-reply-count').html()) + 1);
    };
    var decCmt = function (feed) {
        decHot(feed);
        feed.find('.cmt-reply-count').html(feed.find('.cmt-reply-count').html() - 1);
    };


});