$(document).ready(function () {
    var loaded = 0;

    $.fn.fadeInWithDelay = function () {
        var delay = 0;
        return this.each(function () {
            $(this).delay(delay).animate({opacity:1}, 200);
            delay += 100;
        });
    };

    var nullFeedDiv = $("<div class='null-feed'>没有可供显示的博文</div>");


    $('#feed_zone').scrollPagination({
        'contentPage':baseUrl + $('#fetch_url').val(),
        'contentData':function () {
            return {'start':loaded};
        },
        'scrollTarget':$(window),
        'heightOffset':50,
        'beforeLoad':function () {
            if ($(".null-feed").length > 0) {
                $(".null-feed").remove();
            }
            $('#loading_more').fadeIn();
        },
        'afterLoad':function (elementsLoaded) {
            loaded++;
            if (elementsLoaded.length < 10) {
                $('#feed_zone').stopScrollPagination();
            }
            $('#loading_more').fadeOut();
            elementsLoaded.fadeInWithDelay();
            elementsLoaded.find('.music-input').each(function (i, item) {
                renderMusic($(item));
            });

            if ($("#feed_zone .feed").length == 0) {
                $("#feed_zone").before(nullFeedDiv);
            }
        }
    });


    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#back_to_top').fadeIn();
        } else {
            $('#back_to_top').fadeOut();
        }
    });
    $('#back_to_top').click(function () {
        window.scrollTo(0, 0);
    });

    var buildCmtList = function (item) {
        var li = $('<li></li>');
        li.addClass('cmt-item').addClass('clearfix');

        var img = $('<img />');
        img.attr('src', baseUrl + item.blog.avatar).addClass('cmt-item-img');
        var content = $('<div></div>');
        var name = $('<span class="cmt-item-name"><a target="_blank" href="' + baseUrl + 'view/' + item.blog.id + '">' + item.blog.name + '</a></span>');
        content.append(name);

        if (item.reply_id != null) {
            content.append('<span class="cmt-item-reply-name">回复 <a target="_blank" href="' + baseUrl + 'view/' + item.reply.id + '">' + item.reply.name + '</a> :</span>');
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

        var name = $('<span class="nt-item-name"><a target="_blank" href="' + baseUrl + 'view/' + item.blog_id + '">' + item.name + '</a></span>');
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

    $('.feed-cmt').live('click', function () {

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
            feed.find('.feed-container-bottom').animate({height:'toggle'}, 300);
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


    $('.feed-nt').live('click', function () {
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
            feed.find('.feed-container-bottom').animate({height:'toggle'}, 300);
        }
        feed.find('.feed-ft').animate({height:'toggle'}, 300);
        feed.find('.feed-ft-triangle').css('left', '353px');

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

    $('.slide-up').live('click', function () {
        var feed = $(this).parents('.feed');
        feed.find('.feed-ft').animate({height:'toggle'}, 300);
        feed.find('.feed-container-bottom').animate({height:'toggle'}, 300);
    });

    $('.cmt-submit').live('click', function () {
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
                $('[data-parent-id=' + feed.attr('data-id') + ']').each(function (i, feed) {
                    incHot($(feed));
                });
            } else {
                apprise('发表失败');
            }
        }, 'json');
    });

    $('.cmt-load-more').live('click', function () {
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

    $('.nt-load-more').live('click', function () {
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


    $('.feed-fav').live('click',function () {
        var feed = $(this).parents('.feed');
        var id = feed.attr('data-id');
        var heart = $(this);
        heart.attr('disabled', 'disabled');

        if (heart.hasClass('feed-faved')) {
            $.get(baseUrl + 'like/unlike/' + id, {}, function (e) {
                if (e.code == 0) {
                    if (feed.attr('data-parent-id')) {
                        $('[data-id=' + feed.attr('data-parent-id') + ']').find('.feed-fav').trigger('inactive');
                        $('[data-parent-id=' + feed.attr('data-parent-id') + ']').find('.feed-fav').trigger('inactive');
                    } else {
                        heart.trigger('inactive');
                        $('[data-parent-id=' + feed.attr('data-id') + ']').find('.feed-fav').trigger('inactive');
                    }
                }
                heart.attr('disabled', 'enabled');
            }, 'json');
        } else {
            $.get(baseUrl + 'like/like/' + id, {}, function (e) {
                if (e.code == 0) {
                    if (feed.attr('data-parent-id')) {
                        $('[data-id=' + feed.attr('data-parent-id') + ']').find('.feed-fav').trigger('active');
                        $('[data-parent-id=' + feed.attr('data-parent-id') + ']').find('.feed-fav').trigger('active');
                    } else {
                        heart.trigger('active');
                        $('[data-parent-id=' + feed.attr('data-id') + ']').find('.feed-fav').trigger('active');
                    }

                }
                heart.attr('disabled', 'enabled');

            }, 'json');
        }
    }).live('inactive',function () {
            $(this).removeClass('feed-faved').attr('title', '喜欢');
            decHot($(this).parents('.feed'))
        }).live('active', function () {
            $(this).addClass('feed-faved').attr('title', '取消喜欢');
            incHot($(this).parents('.feed'))
        });
    $('.cmt-item-delete a').live('click', function () {
        var item = $(this);
        $.get(baseUrl + 'comment/del/' + $(this).attr('data-id'), {}, function (e) {
            if (e.code == 0) {
                item.parents('.cmt-item').animate({height:'toggle'}, 300);
                decCmt(item.parents('.feed'));
                $('[data-parent-id=' + item.parents('.feed').attr('data-id') + ']').each(function (i, feed) {
                    decHot($(feed));
                });
            } else {
                apprise('删除失败');
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


    $('.feed-delete').live('click', function (e) {
        var feed = $(this).parents('.feed');
        apprise("您确定要删除?", {verify:true}, function (e) {
            console.dir(e);
            if (e) {
                $.post(baseUrl + 'post/delete/' + feed.attr('data-id'), function (e) {
                    if (e.code == 0) {
                        feed.animate({height:0}, function () {
                            feed.remove();
                        });
                    } else {
                        apprise('删除失败');
                    }
                }, 'json');
            }
        });
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

    var cancel = false;

    $(".feed-avatar").live('mouseover',function () {
        if (cancel)  cancel = false;
        else
            $(".feed-avatar .feed-avatar-action").fadeIn();
    }).live("mouseout", function () {
            cancel = true;
            setTimeout(function () {
                if (cancel) {
                    $(".feed-avatar .feed-avatar-action").fadeOut();
                    cancel = false;
                }
            }, 500);
        });

    $(".feed-follow").live("click", function () {
        var blog_id = $(this).data("blog");
        var t = $(this);
        $.post(baseUrl + 'follow/follow/' + blog_id, function (e) {
            if (e.code == 0) {
                t.html("取消关注").removeClass("feed-follow").addClass("feed-unfollow");
            }
        }, 'json');

    });

    $(".feed-unfollow").live("click", function () {
        var blog_id = $(this).data("blog");
        var t = $(this);

        $.post(baseUrl + 'follow/unfollow/' + blog_id, function (e) {
            if (e.code == 0) {
                t.html("关注").addClass("feed-follow").removeClass("feed-unfollow");
            }
        }, 'json');

    });

    $(".feed-visit-blog").live("click", function () {
        open($(this).data("url"));
    });
});