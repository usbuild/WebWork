<?php

class BlogController extends Controller
{
    public $layout = '//layouts/column2';
    public $sidebar;

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/underscore-min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/backbone-min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/autosize/jquery.autosize-min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/blog/main.js', CClientScript::POS_END);

        if (isset($_REQUEST['id']))
            $this->sidebar = $this->renderPartial('sidebar', array('blog' => Blog::model()->findByPk($_REQUEST['id'])), true);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('create', 'view', 'info', 'getposts', 'follows', 'index', 'addwriter'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqueryscrollpagination/scrollpagination.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/feed.js', CClientScript::POS_END);
        $user = Yii::app()->user->model;

        $this->render('view', array('myblog' => $user->myblog, 'blog' => Blog::model()->findByPk($id)));
    }

    public function actionGetPosts($id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('blog_id', $id);
        $criteria->compare('isdel', 0);
        $criteria->order = 'time DESC';
        $criteria->limit = 10;
        $criteria->offset = $_REQUEST['start'] * 10 - 10;

        $posts = Post::model()->findAll($criteria);
        $this->renderPartial('all', array('posts' => $posts));
    }

    public function actionCreate()
    {
        if (Yii::app()->request->isPostRequest) {
            if (isset($_REQUEST['name']) && isset($_REQUEST['domain'])) {
                $name = $_REQUEST['name'];
                $domain = $_REQUEST['domain'];
                if (!empty($name) && !empty($domain)) {
                    if (is_numeric($domain)) {
                        echo CJSON::encode(array('code' => 1, 'data' => '域名不能全为数字'));
                        exit();
                    }
                    if (strlen($domain) <= 3) {
                        echo CJSON::encode(array('code' => 1, 'data' => '域名长度至少为4'));
                        exit();
                    }
                    $blog = Blog::model()->findByAttributes(array('domain' => $domain));
                    if (!empty($blog)) {
                        echo CJSON::encode(array('code' => 1, 'data' => '该域名已被占用'));
                        exit();
                    }


                    $blog = new Blog();
                    $blog->name = $name;
                    $blog->domain = $domain;
                    $blog->owner = Yii::app()->user->id;

                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if (!$blog->save()) throw new Exception(CHtml::errorSummary($blog));
                        $blog->refresh();

                        $follow_blog = new FollowBlog();
                        $follow_blog->user_id = Yii::app()->user->id;
                        $follow_blog->blog_id = $blog->id;
                        if (!$follow_blog->save()) throw new Exception(CHtml::errorSummary($follow_blog));
                        $transaction->commit();

                        echo CJSON::encode(array('code' => 0, 'data' => $blog));

                    } catch (Exception $ex) {
                        $transaction->rollback();
                        echo CJSON::encode(array('code' => 1, 'data' => $ex->getMessage()));
                    }

                } else {
                    echo CJSON::encode(array('code' => 1, 'data' => '博客名或域名不能为空'));
                }
            } else {
                echo CJSON::encode(array('code' => 1, 'data' => '参数缺失'));
            }
        } else {
            $this->layout = '//layouts/main';
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqtransform/jquery.jqtransform.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/jqtransform/jqtransform.css');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/blog/create.js', CClientScript::POS_END);
            $this->render('create');
        }
    }

    public
    function actionInfo($id)
    {
        $blog = Blog::model()->findByPk($id);
        echo CJSON::encode($blog);
    }

    public function actionFollows($id)
    {
        $blog = Blog::model()->findByPk($id);
        $follows = $blog->follows();
        $this->render('follow', array('follows' => $follows, 'blog' => $blog));
    }

    public function actionAddWriter()
    {
        $email = $_REQUEST['email'];
//        $user = User::model()
    }

}
