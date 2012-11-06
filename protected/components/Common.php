<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-25
 * Time: 下午7:04
 * To change this template use File | Settings | File Templates.
 */
class Common
{
    public static function generatePass($pass)
    {
        $salt = sha1(rand(0, 9999999));
        return array(Common::encryptPass($pass, $salt), $salt);
    }

    public static function encryptPass($pass, $salt)
    {

        return sha1($pass + $salt);
    }

    public static function validatePass($pass, $salt, $encrypted_pass)
    {
        return Common::encryptPass($pass, $salt) === $encrypted_pass;
    }

    public static function checkEMail($email)
    {
        return preg_match('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/', $email) > 0;
    }

    public static function getBlogs()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (!empty($user))
            return $user->blogs;
        return array();
    }

    public static function getYouKuId($link)
    {
        $m = parse_url($link);
        if ($m['host'] === 'v.youku.com') {
            $path = $m['path'];
            $path = substr(strrchr($path, '/'), 4, -5);
            return $path;
        }
        return false;
    }

    public static function getYouKuImg($id)
    {
        $content = file_get_contents('http://v.youku.com/v_show/id_' . $id . '.html');
        preg_match('/&pic=(http:\/\/\S+?)"/', $content, $matches);
        return $matches[1];
    }


}
