// Apprise 1.5 by Daniel Raftery
// http://thrivingkings.com/apprise
//
// Button text added by Adam Bezulski
//

function apprise(string, args, callback) {
    var default_args =
    {
        'confirm':false, // Ok and Cancel buttons
        'verify':false, // Yes and No buttons
        'input':false, // Text input (can be true or string for default text)
        'animate':200, // Groovy animation (can true or number, default is 400)
        'textOk':'好', // Ok button default text
        'textCancel':'取消', // Cancel button default text
        'textYes':'是', // Yes button default text
        'textNo':'否'        // No button default text
    }

    if (args) {
        for (var index in default_args) {
            if (typeof args[index] == "undefined") args[index] = default_args[index];
        }
    }

    $('body').append('<div class="appriseOverlay" id="aOverlay"></div>');
    $('.appriseOverlay').css('height', '100%').css('width', '100%').fadeIn(300);
    $('body').append('<div class="appriseOuter"></div>');
    $('.appriseOuter').append('<div class="appriseInner"></div>');
    $('.appriseInner').append(string);
    $('.appriseOuter').css("left", ( $(window).width() - $('.appriseOuter').width() ) / 2 + $(window).scrollLeft() + "px");
    $('input').blur();

    $('.appriseOuter').css('top', '-' + $(this).height() + 'px').show().animate({top:0}, 300);

    if (args) {
        if (args['input']) {
            if (typeof(args['input']) == 'string') {
                $('.appriseInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" value="' + args['input'] + '" /></div>');
            }
            else {
                $('.appriseInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" /></div>');
            }
            $('.aTextbox').focus();
        }
    }

    $('.appriseInner').append('<div class="aButtons"></div>');
    if (args) {
        if (args['confirm'] || args['input']) {
            $('.aButtons').append('<button value="ok">' + args['textOk'] + '</button>');
            $('.aButtons').append('<button value="cancel">' + args['textCancel'] + '</button>');
        }
        else if (args['verify']) {
            $('.aButtons').append('<button value="ok">' + args['textYes'] + '</button>');
            $('.aButtons').append('<button value="cancel">' + args['textNo'] + '</button>');
        }
        else {
            $('.aButtons').append('<button value="ok">' + args['textOk'] + '</button>');
        }
    }
    else {
        $('.aButtons').append('<button value="ok">Ok</button>');
    }

    $(document).keydown(function (e) {
        if ($('.appriseOverlay').is(':visible')) {
            if (e.keyCode == 13) {
                $('.aButtons > button[value="ok"]').click();
            }
            if (e.keyCode == 27) {
                $('.aButtons > button[value="cancel"]').click();
            }
        }
    });

    var aText = $('.aTextbox').val();
    if (!aText) {
        aText = false;
    }
    $('.aTextbox').keyup(function () {
        aText = $(this).val();
    });
    if (!args || !(args['input'] || args['confirm'] || args['verify'])) {
        setTimeout(function () {
            $('.appriseOverlay').fadeOut(400, function () {
                $('.appriseOverlay').remove();
            });
            $('.appriseOuter').animate({top:'-' + $('.appriseOuter').height() + 'px'}, 200, function () {
                $('.appriseOuter').remove();
            });
        }, 1000)
    }


    $('.aButtons > button').click(function () {
        $('.appriseOverlay').fadeOut(400, function () {
            $('.appriseOverlay').remove();
        });
        $('.appriseOuter').animate({top:'-' + $('.appriseOuter').height() + 'px'}, 200, function () {
            $('.appriseOuter').remove();
            if (callback) {
                var wButton = $(this).attr("value");
                if (wButton == 'ok') {
                    if (args) {
                        if (args['input']) {
                            callback(aText);
                        }
                        else {
                            callback(true);
                        }
                    }
                    else {
                        callback(true);
                    }
                }
                else if (wButton == 'cancel') {
                    callback(false);
                }
            }
        });
    });
}
