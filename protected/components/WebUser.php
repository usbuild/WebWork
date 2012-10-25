<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-25
 * Time: 下午8:39
 * To change this template use File | Settings | File Templates.
 */
class WebUser extends CWebUser
{
    private $_model;

    function getEmail()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user->email;
    }

    protected function loadUser($id = null)
    {
        if ($this->_model === null) {
            if ($id !== null) {
                $this->_model = User::model()->findByPk($id);
            }
        }
        return $this->_model;
    }
}
