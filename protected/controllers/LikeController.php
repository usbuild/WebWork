<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-8
 * Time: 下午9:31
 * To change this template use File | Settings | File Templates.
 */
class LikeController extends Controller
{
    public function actionLike($id)
    {
        $like = Like::model()->findByAttributes(array('post_id' => $id, 'blog_id' => Yii::app()->user->model->blog));
        if (empty($like)) {
            $like = new Like();
            $like->post_id = $id;
            $like->blog_id = Yii::app()->user->model->blog;
            if (!$like->save()) {
                echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($like)));
                exit();
            }
            $like->refresh();
        }
        echo CJSON::encode(array('code' => 0, 'data'=>'like'));
    }

    public function actionUnlike($id)
    {
        Like::model()->deleteAllByAttributes(array('post_id' => $id, 'blog_id' => Yii::app()->user->model->blog));
        echo CJSON::encode(array('code' => 0));
    }

}
