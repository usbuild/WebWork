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
            $result = $comment->attributes;
            $result['blog'] = $comment->blog;
            $result['reply'] = $comment->reply;
            $result['isme'] = 1;
            echo CJSON::encode(array('code' => 0, 'data' => $result));
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($comment)));
        }
    }

    public function actionDel($id)
    {

        $result = Comment::model()->deleteAllByAttributes(array('blog_id' => Yii::app()->user->model->blog, 'id' => $id));

        if ($result == 1) {
            echo CJSON::encode(array('code' => 0));
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => "delete failed"));
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

                $result = $comment->attributes;
                $result['isme'] = $comment->blog->id == $myblog_id ? 1 : 0;
                $result['blog'] = $comment->blog;
                if (!empty($result['reply_id'])) {
                    $result['reply'] = $comment->reply;
                }
                $results[] = $result;
            }

            echo CJSON::encode($results);
        } else {
            echo CJSON::encode(array());
        }
    }

}
