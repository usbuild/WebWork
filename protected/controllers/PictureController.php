<?php
/**
 * User: Usbuild
 * DateTime: 12-10-28 下午8:09
 */
class PictureController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly',
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
                'actions' => array('upload', 'jqupload'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionUpload()
    {
        //上传配置
        $savePath = Yii::app()->basePath . "/../upload/";
        $config = array(
            "savePath" => $savePath,
            "maxSize" => 2000, //单位KB
            "allowFiles" => array(".gif", ".png", ".jpg", ".jpeg", ".bmp")
        );
        //上传图片框中的描述表单名称，
        $title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
        //生成上传实例对象并完成上传
        $up = new Uploader("upfile", $config);
        $info = $up->getFileInfo();
        $info['url'] = '/upload/' . substr($info['url'], strlen($savePath));
        $result = array('url' => $info['url'], 'title' => $title, 'original' => $info["originalName"], 'state' => $info['state']);
        echo json_encode($result);
    }

    public function actionJqUpload()
    {
        $upload_handler = new UploadHandler(array('upload_dir' => Yii::app()->basePath . "/../upload/" . date("Ymd") . '/',
            'upload_url' => Yii::app()->baseUrl . '/upload/' . date("Ymd") . '/'));
    }
}
