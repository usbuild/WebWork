<?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-10-26
 * Time: 上午11:11
 * To change this template use File | Settings | File Templates.
 */
class BlogOwnerFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        if (isset($_REQUEST['blog_id'])) {
            $blog_id = $_REQUEST['blog_id'];
            $blog = Blog::model()->findByAttributes(array('id' => $blog_id));
            if (empty($blog)) {
                exit();
            }
            if ($blog->owner != Yii::app()->user->id) {
                $cowriter = Cowriter::model()->findByAttributes(array('blog_id' => $blog_id, 'user_id' => Yii::app()->user->id));
                if (empty($cowriter)) {
                    echo CJSON::encode(array('code' => 1, 'data' => 'Not Authorized'));
                    exit();
                } else {
                    $blog = Blog::model()->findByPk($_REQUEST['blog_id']);
                }
            }
            $filterChain->controller->blog = &$blog;
            $filterChain->run();
        } else {
            echo CJSON::encode(array('code' => 1, 'data' => 'Missing Param(s)'));
            exit();
        }
    }
}
