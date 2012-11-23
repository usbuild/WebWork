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

    $('#post_type').change(function () {
        var type = $('#post_type').val();
        var container = $('#current_type');
        container.html('');
        switch (type) {
            case 'text':
                container.append($('#post_text').clone());
                break;
            case 'image':
                container.append($('#post_image').clone());
                break;
            case 'music':
                container.append($('#post_music').clone());
                break;
            case 'video':
                container.append($('#post_video').clone());
                break;
            case 'link':
                container.append($('#post_link').clone());
                break;
        }
    }).trigger('change');
});