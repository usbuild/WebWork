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
//    $('button').jqTransInputButton();
    $('input[type=submit]').jqTransInputButton();
    $('input[type=text]').jqTransInputText();
    $('select').jqTransSelect();
});