<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-5
 * Time: 下午12:49
 * To change this template use File | Settings | File Templates.
 */
class SettingController extends Controller
{
    public $layout = "//layouts/main";

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/setting/main.js', CClientScript::POS_END);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + newPassword', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'blog', 'account', 'newPassword'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionBlog($id)
    {
        $this->layout = "//layouts/column2";
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/imgareaselect/css/imgareaselect-default.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/imgareaselect/scripts/jquery.imgareaselect.min.js', CClientScript::POS_HEAD);
        if (is_numeric($id)) {
            $blog = Blog::model()->findByPk($id);
        } else {
            $blog = Blog::model()->findByAttributes(array('domain'));
        }
        $this->render('blog', array('blog' => $blog));
    }

    public function actionAccount()
    {
        $this->render('account');
    }

    public function actionNewPassword()
    {
        if (isset($_REQUEST['old_pass']) && isset($_REQUEST['new_pass'])) {
            $user = Yii::app()->user->model;
            if (strlen(trim($_REQUEST['new_pass'])) < 5) {
                echo CJSON::encode(array('code' => 1, 'data' => '密码过短，至少为5位'));
                exit();
            }

            if (Common::validatePass($_REQUEST['old_pass'], $user->salt, $user->password)) {
                list($user->password, $user->salt) = Common::generatePass($_REQUEST['new_pass']);
                if ($user->save()) {
                    echo CJSON::encode(array('code' => 0, 'data' => '修改成功'));
                    exit();
                } else {
                    echo CJSON::encode(array('code' => 1, 'data' => '修改失败'));
                    exit();
                }
            } else {
                echo CJSON::encode(array('code' => 1, 'data' => '原密码错误'));
                exit();
            }
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => '缺失参数'));
            exit();
        }
    }

}
