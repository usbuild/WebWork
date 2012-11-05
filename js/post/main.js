/**
 * Created with JetBrains PhpStorm.
 * User: Usbuild
 * Date: 12-10-28
 * Time: 下午10:50
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {
    $('#tags').tagsInput({
        defaultText:'',
        height:'150px',
        width:'190px',
        removeWithBackspace:true });
    $('.jq-text').jqTransInputText();
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