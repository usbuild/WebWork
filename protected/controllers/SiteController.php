<?php

class SiteController extends Controller
{
    public $layout = '//layouts/column2';
    public $sidebar;
    public $pageTitle = '我的轻博客';

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/underscore-min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/backbone-min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/autosize/jquery.autosize-min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/site/index.js', CClientScript::POS_END);
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
                'actions' => array('index', 'logout', 'likeposts', 'discover', 'follow', 'tagposts', 'writerposts'),
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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqueryscrollpagination/scrollpagination.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/feed.js', CClientScript::POS_END);
        $user = Yii::app()->user->model;
        $this->render('index', array('myblog' => $user->myblog));
    }

    public function actionLikePosts()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqueryscrollpagination/scrollpagination.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/feed.js', CClientScript::POS_END);
        $user = Yii::app()->user->model;
        $this->render('likeposts', array('myblog' => $user->myblog));
    }

    public function actionTagPosts()
    {
        $tag = $_REQUEST['tag'];
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqueryscrollpagination/scrollpagination.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/feed.js', CClientScript::POS_END);
        $user = Yii::app()->user->model;
        $this->render('tagposts', array('myblog' => $user->myblog, 'tag' => $tag));
    }
    public function actionWriterPosts($id)
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqueryscrollpagination/scrollpagination.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/feed.js', CClientScript::POS_END);
        $user = Yii::app()->user->model;
        $this->render('writerposts', array('myblog' => $user->myblog, 'id' => $id));
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
                $this->renderPartial('error', $error);
        }
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
        $this->renderPartial('login', array('model' => $model));
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
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            if ($user->save()) {
                                $user->refresh();
                                $blog = new Blog();
                                $blog->owner = $user->id;
                                if (!$blog->save()) throw new Exception(CHtml::errorSummary($blog));
                                $blog->refresh();

                                $follow_blog = new FollowBlog();
                                $follow_blog->user_id = $user->id;
                                $follow_blog->blog_id = $blog->id;
                                if (!$follow_blog->save()) throw new Exception(CHtml::errorSummary($follow_blog));

                                $user->blog = $blog->id;
                                if (!$user->save()) throw new Exception(CHtml::errorSummary($user));
                                $transaction->commit();
                                $login = new LoginForm();
                                $login->username = $user->email;
                                $login->password = $password;
                                $login->rememberMe = true;
                                $login->login();
                                $this->redirect(Yii::app()->homeUrl);
                            } else {
                                $this->renderPartial('signup', array('message' => CHtml::errorSummary($user)));
                            }
                        } catch (Exception $ex) {
                            $transaction->rollback();
                            $this->renderPartial('signup', array('message' => $ex->getMessage()));
                        }
                    } else {
                        $this->renderPartial('signup', array('message' => '该邮箱已被占用'));
                    }
                } else {
                    $this->renderPartial('signup', array('message' => '请填写完整信息'));
                }
            } else {
                $this->renderPartial('signup', array('message' => '请填写完整信息'));
            }
        } else {
            $this->renderPartial('signup');
        }
    }

    public function actionDiscover()
    {
        $this->render('discover', array('blogs' => Blog::model()->getHotBlog(0)));
    }

    public function actionFollow()
    {
        $this->render('follow', array('follow' => Yii::app()->user->model->followBlogs()));
    }
}