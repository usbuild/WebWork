/**
 * Created with JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-26
 * Time: 上午10:20
 * To change this template use File | Settings | File Templates.
 */
var baseUrl = 'http://localhost/blog/';
var json_decode = function (e) {
    return eval('(' + e + ')');
};
var json_encode = function(e) {
    return JSON.stringify(e);
}