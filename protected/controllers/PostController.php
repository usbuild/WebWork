<?php

class PostController extends Controller
{
    public $blog;

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/ueditor/editor_config.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/ueditor/editor_all_min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/ueditor/themes/default/ueditor.css');
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete,index', // we only allow deletion via POST request
            array('application.controllers.filters.BlogOwnerFilter + index'),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'text', 'image', 'link', 'refer'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (isset($_REQUEST['title']) && isset($_REQUEST['content']) && isset($_REQUEST['tags'])) {
            $title = $_REQUEST['title'];
            $content = $_REQUEST['content'];
            $tags = explode(',', $_REQUEST['tags']);
            if (strlen(trim($title)) + strlen(trim($content)) > 0) {
                $post = new Post();
                $post->content = array('title' => $title, 'content' => $content);
                $post->poster = $this->blog->id;
                $post->tag = $tags;
                $post->type = 'text';

                $transaction = Yii::app()->db->beginTransaction();
                try {

                    if ($post->save()) {
                        $post->refresh();
                        foreach ($tags as $tag) {
                            $tagModel = new Tag();
                            $tagModel->post = $post->id;
                            $tagModel->tag = $tag;
                            if (!$tagModel->save()) throw new CDbException("insert error");
                        }
                        $transaction->commit();

                        echo CJSON::encode(array('code' => 0, 'data' => $post->id));
                    } else {
                        echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($post)));
                    }
                } catch (Exception $ex) {
                    $transaction->rollback();
                    echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($post)));
                }
            } else {
                echo CJSON::encode(array('code' => 1));
                return;
            }
        } else {
            echo CJSON::encode(array('code' => 1));
            return;
        }
    }

    public function actionText()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/text.js', CClientScript::POS_HEAD);
        $blogs = Blog::model()->findAllByAttributes(array('owner' => Yii::app()->user->id));
        $this->render('text', array('blogs' => $blogs));
    }
}
