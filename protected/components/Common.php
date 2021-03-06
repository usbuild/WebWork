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

    public static function curl_get_contents($link)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_ENCODING, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
