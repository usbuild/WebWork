<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-13
 * Time: 上午10:29
 * To change this template use File | Settings | File Templates.
 */
class VideoHelper
{
    public static $youku_flash = 'http://player.youku.com/player.php/sid/${id}/v.swf';
    public static $bili_flash = 'http://static.hdslb.com/miniloader.swf?aid=${id}';
    public static $tudou_flash = 'http://www.tudou.com/${id}/v.swf';

    public static function getFlashUrl($id, $type)
    {
        switch ($type) {
            case 'youku':
                $embed = VideoHelper::$youku_flash;
                break;
            case 'bili':
                $embed = VideoHelper::$bili_flash;
                break;
            case 'tudou':
                $embed = VideoHelper::$tudou_flash;
                break;
        }
        return str_replace('${id}', $id, $embed);
    }

    public static function getYoukuInfo($m)
    {
        $info = array();
        $info['type'] = 'youku';
        $info['originUrl'] = $m['originUrl'];
        $id = substr(strrchr($m['path'], '/'), 4, -5);
        $content = Common::curl_get_contents($m['originUrl']);
        preg_match('/&pic=(http:\/\/\S+?)"/', $content, $matches);
        $info['img'] = $matches[1];
        preg_match('/name="title" content="(.+?)">/', $content, $matches);
        $info['title'] = $matches[1];
        $info['flashUrl'] = VideoHelper::getFlashUrl($id, 'youku');
        return $info;
    }

    public static function getBiliInfo($m)
    {
        $info = array();
        $info['type'] = 'bili';
        $info['originUrl'] = $m['originUrl'];
        $id = substr(strrchr(substr($m['path'], 0, -1), '/'), 1);
        $content = Common::curl_get_contents($m['originUrl']);
        preg_match('/name="title"\s+content="(.+?)"/', $content, $matches);
        $info['title'] = $matches[1];
        preg_match('/wb_img=\'(\S+?)\'/', $content, $matches);
        $info['img'] = $matches[1];
        $info['flashUrl'] = VideoHelper::getFlashUrl(substr($id, 2), 'bili');
        return $info;
    }

    public static function getTudouInfo($m)
    {
        $info = array();
        $info['type'] = 'tudou';
        $info['originUrl'] = $m['originUrl'];

        $content = Common::curl_get_contents($m['originUrl']);

        preg_match('/,kw:\s*"(.+?)"/', $content, $matches);
        $info['title'] = iconv('gb2312', 'utf-8', $matches[1]);
        preg_match('/iid:\s*(\d+)/', $content, $matches);
        $iid = $matches[1];
        preg_match('/,pic:\s*(\S+)/', $content, $matches);
        $info['img'] = substr($matches[1], 1, -1);

        if (strpos($m['path'], '/albumplay/') === 0) {
            $acode = substr($m['path'], strlen('/albumplay/'), 11);
            $info['flashUrl'] = VideoHelper::getFlashUrl('a/' . $acode . '/&iid=' . $iid, 'tudou');
        } else if (strpos($m['path'], '/listplay/') === 0) {
            $acode = substr($m['path'], strlen('/listplay/'), 11);

            $info['flashUrl'] = VideoHelper::getFlashUrl('l/' . $acode . '/&iid=' . $iid, 'tudou');
        } else if (strpos($m['path'], '/programs/view/') === 0) {

            $acode = substr($m['path'], strlen('/programs/view/'), 11);
            $info['flashUrl'] = VideoHelper::getFlashUrl('v/' . $acode . '/&iid=' . $iid, 'tudou');

        } else return null;
        return $info;
    }

    public static function getVideoInfo($link)
    {
        $m = parse_url($link);
        $m['originUrl'] = $link;
        if (isset($m['host'])) {
            switch ($m['host']) {
                case 'v.youku.com':
                    return VideoHelper::getYoukuInfo($m);
                case 'bilibili.smgbb.cn':
                    return VideoHelper::getBiliInfo($m);
                case 'www.tudou.com':
                    return VideoHelper::getTudouInfo($m);
            }
        }
    }
}
