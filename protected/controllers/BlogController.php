<?php

class BlogController extends Controller
{
    public $layout = '//layouts/column2';

    public function init()
    {
        parent::init();
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
                'actions' => array('create', 'view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        if (is_numeric($id)) {
            $blog = Blog::model()->findByPk($id);
        } else {
            $blog = Blog::model()->findByAttributes(array('domain' => $id));
        }
        if (empty($blog)) {
            throw new CHttpException(404);
        } else {

            $criteria = new CDbCriteria();
            $criteria->compare('poster', $id);
            $criteria->order = 'time desc';
            $count = Post::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 5;
            $pages->applyLimit($criteria);
            $posts = Post::model()->findAll($criteria);
            $this->render('view', array('posts' => $posts, 'pages' => $pages, 'blog' => $blog));
        }
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
                    if ($blog->save()) {
                        echo CJSON::encode(array('code' => 0, 'data' => $blog));
                    } else {
                        echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($blog)));
                    }
                } else {
                    echo CJSON::encode(array('code' => 1, 'data' => '博客名或域名不能为空'));
                }
            } else {
                echo CJSON::encode(array('code' => 1, 'data' => '参数缺失'));
            }
        } else {
            $this->layout = '//layouts/main';
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqtransform/jquery.jqtransform.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/jqtransform/jqtransform.css');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/blog/create.js', CClientScript::POS_HEAD);
            $this->render('create');
        }
    }

    public function actionCheckUse($name)
    {

    }
}
