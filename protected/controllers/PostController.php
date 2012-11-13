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
            'postOnly + index,getYoukuImg',
            array('application.controllers.filters.BlogOwnerFilter + index'),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view', 'fetchHots'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'text', 'photo', 'video', 'music', 'getVideoInfo', 'delete', 'repost', 'edit', 'getposts', 'link'),
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
                || (in_array($type, array('image', 'video', 'music', 'link')) && !empty($title))
            ) {
                $post = new Post();
                $post->blog_id = $this->blog->id;
                $post->type = $type;

                if (isset($_REQUEST['id'])) {
                    $old_post = Post::model()->findByPk($_REQUEST['id']);
                    if (!empty($old_post)) {
                        $post = $old_post;
                    }
                }
                $post->head = $title;
                $post->content = $content;
                $post->tag = $tags;

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

        if (isset($_REQUEST['id'])) {
            $post = Post::model()->findByPk($_REQUEST['id']);
            if (!empty($post) && $post->isMine() && $post->type == "text") {
                $this->render('text', array('blogs' => $blogs, 'post' => $post));
                return;
            }
        }
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
        if (isset($_REQUEST['id'])) {
            $post = Post::model()->findByPk($_REQUEST['id']);
            if (!empty($post) && $post->isMine() && $post->type == "image") {
                $this->render('photo', array('blogs' => $blogs, 'post' => $post));
                return;
            }
        }
        $this->render('photo', array('blogs' => $blogs));
    }

    public function actionMusic()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/music.js', CClientScript::POS_END);
        $blogs = Blog::model()->findAllByAttributes(array('owner' => Yii::app()->user->id));
        if (isset($_REQUEST['id'])) {
            $post = Post::model()->findByPk($_REQUEST['id']);
            if (!empty($post) && $post->isMine() && $post->type == "music") {
                $this->render('music', array('blogs' => $blogs, 'post' => $post));
                return;
            }
        }
        $this->render('music', array('blogs' => $blogs));
    }

    public function actionVideo()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/video.js', CClientScript::POS_END);
        $blogs = Yii::app()->user->model->blogs;
        if (isset($_REQUEST['id'])) {
            $post = Post::model()->findByPk($_REQUEST['id']);
            if (!empty($post) && $post->isMine() && $post->type == "video") {
                $this->render('video', array('blogs' => $blogs, 'post' => $post));
                return;
            }
        }
        $this->render('video', array('blogs' => $blogs));
    }

    public function actionLink()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/post/link.js', CClientScript::POS_END);
        $blogs = Yii::app()->user->model->blogs;
        if (isset($_REQUEST['id'])) {
            $post = Post::model()->findByPk($_REQUEST['id']);
            if (!empty($post) && $post->isMine() && $post->type == 'link') {
                $this->render('link', array('blogs' => $blogs, 'post' => $post));
                return;
            }
        }
        $this->render('link', array('blogs' => $blogs));
    }


    public function actionGetVideoInfo()
    {
        if (isset($_REQUEST['link'])) {
            $info = VideoHelper::getVideoInfo($_REQUEST['link']);
            if ($info != null) {
                echo CJSON::encode(array('code' => 0, 'data' => $info));
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

            $repost = Post::model()->findByPk($id);
            if (isset($_REQUEST['edit'])) {
                $this->render('repost', array('repost' => $repost->repost, 'post' => $repost));
                return;
            }

            $this->render('repost', array('repost' => $repost));
        } else {
            if (isset($_REQUEST['Post'])) {
                $post = $_REQUEST['Post'];

                $model = new Post();
                $model->blog_id = $post['blog_id'];

                if (isset($post['id'])) {
                    $model = Post::model()->findByPk($post['id']);
                    if (!empty($model)) {
                        unset($post['id']);
                    } else {
                        echo CJSON::encode(array('code' => 1, 'data' => 'no such post'));
                        return;
                    }
                }
                $model->content = $post['content'];

                if (strlen($post['tag']) == 0) $tag = array();
                else $tag = explode(',', $post['tag']);

                $model->tag = $tag;

                $parent = Post::model()->findByPk($id);
                if ($parent->repost_id == null)
                    $model->repost_id = $id;
                else
                    $model->repost_id = $parent->repost_id;
                $model->head = $parent->id;

                $model->type = 'repost';
                if ($model->save()) {
                    $model->refresh();
                    echo CJSON::encode(array('code' => 0, 'data' => $model));
                } else {
                    echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($model)));
                }
            } else {
                echo CJSON::encode(array('code' => 1, 'data' => 'missing param'));
            }
        }
    }

    public function actionFetchHots()
    {
        if (isset($_REQUEST['id']) && isset($_REQUEST['offset']) && is_numeric($_REQUEST['offset'])) {
            $post = Post::model()->findByPk($_REQUEST['id']);
            if (empty($post)) {
                echo CJSON::encode(array());
                return;
            }
            $result = $post->getHots($_REQUEST['offset']);
            echo CJSON::encode($result->readAll());
        } else {
            echo CJSON::encode(array());
        }
    }

    public function actionDelete($id)
    {
        $post = Post::model()->findByAttributes(array('id' => $id));
        if ($post->isMine()) {
            if ($post->disable()) {
                echo CJSON::encode(array('code' => 0));
            } else {
                echo CJSON::encode(array('code' => 1, 'data' => 'delete failed'));
            }
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => 'not your post'));
        }
    }

    public function actionEdit($id)
    {
        $post = Post::model()->findByPk($id);
        if (!empty($post) && $post->isMine()) {
            switch ($post->type) {
                case 'text':
                    $this->redirect(array('post/text', 'id' => $id));
                    break;
                case 'image':
                    $this->redirect(array('post/photo', 'id' => $id));
                    break;
                case 'music':
                    $this->redirect(array('post/music', 'id' => $id));
                    break;
                case 'video':
                    $this->redirect(array('post/video', 'id' => $id));
                    break;
                case 'link':
                    $this->redirect(array('post/link', 'id' => $id));
                    break;
                case 'repost':
                    $this->redirect(array('post/repost', 'id' => $id, 'edit' => ''));
                    break;
            }
        }
    }

    public function actionGetPosts()
    {
        $start = $_REQUEST['start'];
        $user = Yii::app()->user->model;
        $this->renderPartial('getposts', array('posts' => $user->getPosts($start * 10), 'myblog' => $user->myblog));
    }

}
