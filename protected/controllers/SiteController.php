<?php

class SiteController extends Controller
{
    public $layout = '//layouts/column2';
    public $sidebar;
    public $pageTitle = '我的轻博客';

    public function init()
    {
        parent::init();
        $this->sidebar = $this->renderPartial('sidebar', array(), true);
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('error', 'login', 'signup'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'logout'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/site/index.js', CClientScript::POS_HEAD);
        $user = User::model()->findByPk(Yii::app()->user->id);
        $this->render('index', array('posts' => $user->getPosts(), 'myblog' => $user->myblog));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionSignUp()
    {
        if (Yii::app()->request->isPostRequest) {
            if (isset($_REQUEST['email']) && isset($_REQUEST['password']) && isset($_REQUEST['name'])) {
                $email = $_REQUEST['email'];
                $password = $_REQUEST['password'];
                $username = $_REQUEST['name'];
                if (Common::checkEMail($email) && strlen($password) > 0 && strlen(trim($username)) > 3) {
                    $user = User::model()->findByAttributes(array('email' => $email));
                    if (empty($user)) {
                        list($pass, $salt) = Common::generatePass($password);
                        $user = new User;
                        $user->password = $pass;
                        $user->salt = $salt;
                        $user->email = $email;
                        $user->name = $username;
                        if ($user->save()) {
                            $login = new LoginForm();
                            $login->username = $user->email;
                            $login->password = $password;
                            $login->rememberMe = true;
                            $login->login();
                            $this->redirect(Yii::app()->homeUrl);
                        } else {
                            $this->render('signup', array('message' => CHtml::errorSummary($user)));
                        }
                    } else {
                        $this->render('signup', array('message' => '该邮箱已被占用'));
                    }
                } else {
                    $this->render('signup', array('message' => '请填写完整信息'));
                }
            } else {
                $this->render('signup', array('message' => '请填写完整信息'));
            }
        } else {
            $this->render('signup');
        }
    }
}