<?php

class BlogController extends Controller
{
    public function init()
    {
        parent::init();
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete,create', // we only allow deletion via POST request
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
                'actions' => array('create'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        $blog = Blog::model()->findByPk($id);
        if (empty($blog)) {
            throw new CHttpException(404);
        } else {

            $criteria = new CDbCriteria();
            $count = Post::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 5;
            $pages->applyLimit($criteria);
            $posts = Post::model()->findAll($criteria);
            $this->render('view', array('posts'=>$posts, 'pages'=>$pages));
        }
    }

    public function actionCreate()
    {
        if (isset($_REQUEST['name'])) {
            $name = $_REQUEST['name'];
            if (!empty($name)) {
                $blog = Blog::model()->findByAttributes(array('name' => $name, 'owner' => Yii::app()->user->id));
                if (empty($blog)) {
                    $blog = new Blog();
                    $blog->name = $name;
                    $blog->owner = Yii::app()->user->id;
                    if ($blog->save()) {
                        echo CJSON::encode(array('code' => 0, 'data' => $blog));
                    } else {
                        echo CJSON::encode(array('code' => 1, 'data' => Chtml::errorSummary($blog)));
                    }
                } else {
                    echo CJSON::encode(array('code' => 1));
                }
            } else {
                echo CJSON::encode(array('code' => 1));
            }
        } else {
            echo CJSON::encode(array('code' => 1));
        }
    }


}
