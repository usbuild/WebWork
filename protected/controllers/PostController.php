<?php

class PostController extends Controller
{
    public $blog;
    public $blogs;
    public $layout = '//layouts/post';
    public $sidebar;

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerCoreScript('jquery.ui', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/ueditor/editor_config.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/ueditor/editor_all_min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jqtransform/jquery.jqtransform.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/jqtransform/jqtransform.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/ueditor/themes/default/ueditor.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/post.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/tagsinput/jquery.tagsinput.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/tagsinput/jquery.tagsinput.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/main.js', CClientScript::POS_END);
        $this->sidebar = $this->renderPartial('sidebar', array(), true);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete,index,getYoukuImg', // we only allow deletion via POST request
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
                'actions' => array('index', 'text', 'photo', 'video', 'music', 'getYoukuImg', 'repost'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (isset($_REQUEST['title']) && isset($_REQUEST['content']) && isset($_REQUEST['tags']) && isset($_REQUEST['type'])) {
            $title = $_REQUEST['title'];
            $content = $_REQUEST['content'];
            if (strlen($_REQUEST['tags']) == 0) $tags = array();
            else
                $tags = explode(',', $_REQUEST['tags']);

            $type = $_REQUEST['type'];
            if (($type === 'text' && strlen(trim($title)) + strlen(trim($content)) > 0)
                || (in_array($type, array('image', 'video', 'music')) && !empty($title))
            ) {
                $post = new Post();
                $post->head = $title;
                $post->content = $content;
                $post->blog_id = $this->blog->id;
                $post->tag = $tags;
                $post->type = $type;

                $transaction = Yii::app()->db->beginTransaction();
                try {

                    if ($post->save()) {
                        $post->refresh();
                        foreach ($tags as $tag) {
                            if (strlen(trim($tag)) == 0) continue;
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
                    echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($post) . CHtml::errorSummary($tagModel)));
                }
            } else {
                echo CJSON::encode(array('code' => 1));
                return;
            }
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => $_REQUEST));
            return;
        }
    }

    public function actionText()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/text.js', CClientScript::POS_END);
        $blogs = Blog::model()->findAllByAttributes(array('owner' => Yii::app()->user->id));
        $this->render('text', array('blogs' => $blogs));
    }

    public function actionPhoto()
    {
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/file-upload/css/jquery.fileupload-ui.css');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/file-upload/js/vendor/jquery.ui.widget.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/file-upload/js/jquery.iframe-transport.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/file-upload/js/jquery.fileupload.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/photo.js', CClientScript::POS_END);

        $blogs = Blog::model()->findAllByAttributes(array('owner' => Yii::app()->user->id));
        $this->render('photo', array('blogs' => $blogs));
    }

    public function actionMusic()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/music.js', CClientScript::POS_END);
        $blogs = Blog::model()->findAllByAttributes(array('owner' => Yii::app()->user->id));
        $this->render('music', array('blogs' => $blogs));
    }

    public function actionVideo()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/video.js', CClientScript::POS_END);
        $blogs = Blog::model()->findAllByAttributes(array('owner' => Yii::app()->user->id));
        $this->render('video', array('blogs' => $blogs));
    }

    public function actionGetYoukuImg()
    {
        if (isset($_REQUEST['link'])) {
            $id = Common::getYouKuId($_REQUEST['link']);
            if ($id) {
                echo CJSON::encode(array('code' => 0, 'data' => Common::getYouKuImg($id)));
            } else {
                echo CJSON::encode(array('code' => 1));
            }
        } else {
            echo CJSON::encode(array('code' => 1));
        }
    }

    public function actionRepost($id)
    {
        if (!Yii::app()->request->isPostRequest) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/repost.js', CClientScript::POS_END);
            $this->render('repost', array('post' => Post::model()->findByPk($id)));
        } else {

        }
    }

}
