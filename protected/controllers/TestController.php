<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-10
 * Time: 下午7:40
 * To change this template use File | Settings | File Templates.
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        $post = Post::model()->findByPk(57);
        var_dump($post->head['flashUrl']);
//        $info = VideoHelper::getVideoInfo('http://www.tudou.com/albumplay/nDZX3rQhcdk/RKwIgZ35n-c.html');
//        var_dump(mb_detect_encoding($info['title'], 'auto'));
//        VideoHelper::getVideoInfo('http://bilibili.smgbb.cn/video/av391405/');
//        Common::getVideoInfo('http://v.youku.com/v_show/id_XNDcwNjQ4NjQ4.html');
    }

}
