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
            $blog = Blog::model()->findByAttributes(array('id' => $blog_id, 'owner' => Yii::app()->user->id));
            if(empty($blog)) {
                echo CJSON::encode(array('code'=>1, 'data'=>'Not Authorized'));
                exit();
            }
            $filterChain->controller->blog = &$blog;
            $filterChain->run();
        } else {
            echo CJSON::encode(array('code'=>1, 'data'=>'Missing Param(s)'));
            exit();
        }
    }
}
