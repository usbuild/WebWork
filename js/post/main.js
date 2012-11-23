/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-10-28
 * Time: 下午10:50
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {
    $.noty.defaults = {
        layout: 'top',
        theme: 'default',
        type: 'alert',
        text: '',
        dismissQueue: true, // If you want to use queue feature set this true
        template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
        animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 500 // opening & closing animation speed
        },
        timeout: false, // delay for closing event. Set false for sticky notifications
        force: false, // adds notification to the beginning of queue when set to true
        modal: false,
        closeWith: ['click'], // ['click', 'button', 'hover']
        callback: {
            onShow: function() {},
            afterShow: function() {},
            onClose: function() {},
            afterClose: function() {}
        },
        buttons: false // an array of buttons
    };


    $('#tags').tagsInput({
        defaultText:'',
        height:'auto',
        width:'auto',
        removeWithBackspace:true });
    $('select').jqTransSelect();

    window.editor = new baidu.editor.ui.Editor();
    window.editor.render("myEditor");

    function setActiveBlog() {
        setActive('blog_id_' + $('#blog_id').val());
    }

    $('#blog_id').change(function (e) {
        setActiveBlog();
    });
    setActiveBlog();

});