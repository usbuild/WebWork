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
        Common::getVideoInfo('http://bilibili.smgbb.cn/video/av391405/');
    }

}
