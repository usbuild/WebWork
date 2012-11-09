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

    var buildList = function (item) {
        var li = $('<li></li>');
        li.addClass('cmt-item').addClass('clearfix');

        var img = $('<img />');
        img.attr('src', baseUrl + item.avatar).addClass('cmt-item-img');


        var content = $('<div></div>');
        content.html(' <span class="cmt-item-name"><a>' + item.name + '</a></span> ' + item.content).addClass('cmt-item-content');

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

    $('.feed-cmt').click(function () {

        var feed = $(this).parents('.feed');
        feed.find('.feed-ft-triangle').css('left', '393px');
        feed.find('.feed-ft').animate({height:'toggle'}, 300);
        feed.find('.feed-container-bottom').toggle();
        feed.find('textarea.cmt-content').get(0).focus();
        var post_id = feed.attr('data-id');
        var start = 0;
        if (!feed.attr('data-cmt')) {
            $.post(baseUrl + 'comment/fetch', {id:post_id, offset:start}, function (obj) {
                var cmt_list = feed.find('.cmt-list');
                $.each(obj, function (i, item) {
                    var li = buildList(item);
                    li.hide();
                    cmt_list.append(li);
                    li.animate({height:'toggle'}, 100);
                });

                cmt_list.data('show', obj.length);
                if (obj.length == 10) {
                    feed.find('.cmt-load-more').show();
                }
            }, 'json');
        }
        feed.attr('data-cmt', true);
    });

    $('.slide-up').click(function () {
        var feed = $(this).parents('.feed');
        feed.find('.feed-ft').animate({height:'toggle'}, 300);
        feed.find('.feed-container-bottom').toggle();
    });

    $('.cmt-submit').click(function () {
        var feed = $(this).parents('.feed');
        $.post(baseUrl + 'comment/add', {'comment[post_id]':feed.attr('data-id'), 'comment[content]':feed.find('.cmt-content').val()}, function (e) {
            var obj = json_decode(e);
            if (obj.code == 0) {
                feed.find('.cmt-content').val('');
                var li = buildList(obj.data);
                li.hide();
                feed.find('.cmt-list').prepend(li);
                li.animate({height:'toggle'}, 300);
                incCmt(feed);
            } else {
                alert('发表失败');
            }
        });
    });

    $('.cmt-load-more').click(function () {
        var feed = $(this).parents('.feed');
        var cmt_list = feed.find('.cmt-list');
        var start = cmt_list.data('show');
        var load_more = $(this);
        $.post(baseUrl + 'comment/fetch', {id:feed.attr('data-id'), offset:start}, function (obj) {
            $.each(obj, function (i, item) {
                var li = buildList(item);
                li.hide();
                cmt_list.append(li);
                li.animate({height:'toggle'}, 100);
            });

            cmt_list.data('show', start + obj.length);
            if (obj.length < 10) {
                load_more.hide();
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
        feed.find('.cmt-content').val('回复 ' + item.name + ' : ');
        var len = feed.find('.cmt-content').val().length;
        locateCursor(feed.find('.cmt-content').get(0), len);
    });


    $('.feed-faved').attr('title', '取消喜欢');
    $('textarea').autosize({append:"\n"});


    var locateCursor = function(txtElement, pos) {
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
        feed.find('.cmt-reply-count').html(parseInt(feed.find('.cmt-reply-count').html()) + 1);
    };
    var decCmt = function (feed) {
        feed.find('.cmt-reply-count').html(feed.find('.cmt-reply-count').html() - 1);
    };


});