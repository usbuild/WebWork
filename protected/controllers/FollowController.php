<?php

class FollowController extends Controller
{
    public $blog;

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/follow/index.js', CClientScript::POS_END);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + followTag,followBlog', // we only allow deletion via POST request
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
                'actions' => array('index', 'newTag', 'follow', 'unfollow'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $blogs = array();
        foreach ($user->follow_blogs as $blog) {
            $blogs[] = $blog->blog;
        }
        $this->render('index', array('follow_tags' => $user->follow_tags, 'follow_blogs' => $blogs));
    }

    public function actionNewTag()
    {
        if (isset($_REQUEST['tag'])) {
            $tag = $_REQUEST['tag'];
            if (empty($tag)) {
                echo CJSON::encode(array('code' => 1, 'data' => 'Illegal Param(s)'));
            } else {
                $old_tag = FollowTag::model()->findByAttributes(array('tag' => $tag, 'user_id' => Yii::app()->user->id));
                if (!empty($old_tag)) {
                    echo CJSON::encode(array('code' => 1, 'data' => 'Already Exists'));
                    return;
                }
                $follow_tag = new FollowTag();
                $follow_tag->user_id = Yii::app()->user->id;
                $follow_tag->tag = $tag;
                if ($follow_tag->save()) {
                    echo CJSON::encode(array('code' => 0, 'data' => $follow_tag));
                } else {
                    echo CJSON::encode(array('code' => 1, 'data' => 'DB Error'));
                }
            }
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => 'Missing Param(s)'));
        }
    }

    public function actionDelTag()
    {
        $result = FollowTag::model()->deleteAllByAttributes(array('user_id' => Yii::app()->user->id, 'tag' => $_REQUEST['tag']));
        if ($result > 0) {
            echo CJSON::encode(array('code' => 0));
        } else {
            echo CJSON::encode(array('code' => 1));
        }
    }


    public function actionFollow($id)
    {
        $blog = Blog::model()->findByPk($id);
        if (empty($blog)) {
            echo CJSON::encode(array('code' => 1, 'data' => "No such blog"));
            exit();
        }
        FollowBlog::model()->deleteAllByAttributes(array('user_id' => Yii::app()->user->id, 'blog_id' => $id));
        $follow_blog = new FollowBlog();
        $follow_blog->user_id = Yii::app()->user->id;
        $follow_blog->blog_id = $id;
        if ($follow_blog->save()) {
            echo CJSON::encode(array('code' => 0, 'data' => $follow_blog));
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => 'DB Error'));
        }
    }

    public function actionUnfollow($id)
    {
        $follow_blog = FollowBlog::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'blog_id' => $id));
        if ($follow_blog->delete()) {
            echo CJSON::encode(array('code' => 0, 'data' => $follow_blog));
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => 'DB Error'));
        }
    }
}
