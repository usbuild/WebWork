<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-8
 * Time: 下午6:59
 */
class CommentController extends Controller
{
    public function actionAdd()
    {
        $comment = new Comment();
        $comment->attributes = $_REQUEST['comment'];
        $comment->blog_id = Yii::app()->user->model->blog;
        if ($comment->save()) {
            $comment->refresh();
            $result = array_merge($comment->blog->attributes, $comment->attributes);
            $result['isme'] = 1;
            echo CJSON::encode(array('code' => 0, 'data' => $result));
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($comment)));
        }
    }

    public function actionDel()
    {
        if (isset($_REQUEST['id'])) {
            $comment = Comment::model()->findByPk($_REQUEST['id']);
            if (!empty($comment)) {
                if ($comment->blog_id == Yii::app()->user->model->blog) {
                    if ($comment->delete()) {
                        echo CJSON::encode(array('code' => 0));
                    } else {
                        echo CJSON::encode(array('code' => 1, 'data' => "database error"));
                    }
                } else {
                    echo CJSON::encode(array('code' => 1, 'data' => "not you comment"));
                }
            } else {
                echo CJSON::encode(array('code' => 1, 'data' => "no comment"));
            }

        } else {
            echo CJSON::encode(array('code' => 1, 'data' => "Missing Param"));
        }
    }

    public function actionFetch()
    {
        if (isset($_REQUEST['id']) && isset($_REQUEST['offset'])) {
            $id = $_REQUEST['id'];
            $offset = $_REQUEST['offset'];
            $limit = 10;
            $criteria = new CDbCriteria();
            $criteria->compare('post_id', $id);
            $criteria->order = 'time desc';
            $criteria->limit = $limit;
            $criteria->offset = $offset;
            $comments = Comment::model()->findAll($criteria);

            $results = array();

            $myblog_id = Yii::app()->user->model->blog;
            foreach ($comments as $comment) {

                $result = array_merge($comment->blog->attributes, $comment->attributes);
                $result['isme'] = $comment->blog->id == $myblog_id ? 1 : 0;
                $results[] = $result;
            }

            echo CJSON::encode($results);
        } else {
            echo CJSON::encode(array());
        }
    }

}
