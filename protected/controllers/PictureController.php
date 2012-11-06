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
                'actions' => array('upload', 'jqupload', 'avatarupload'),
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

    public function actionAvatarUpload()
    {
        $file = $_FILES['file'];
        $savePath = Yii::app()->basePath . "/../upload/avatar/";
        if (!is_dir($savePath)) {
            mkdir($savePath, true);
        }
        $file_path = time() . rand(1, 10000) . strtolower(strrchr($file["name"], '.'));

        move_uploaded_file($file['tmp_name'], $savePath . $file_path);

        list($img_width, $img_height) = @getimagesize($savePath . $file_path);

        $file_name = $file['name'];

        $ratio = $img_width * 1.0 / 400; //client width

        $new_width = $_REQUEST['width'] * $ratio;
        $new_height = $_REQUEST['height'] * $ratio;
        $new_x = $_REQUEST['x1'] * $ratio;
        $new_y = $_REQUEST['y1'] * $ratio;


        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($savePath . $file_path);
                $write_image = 'imagejpeg';
                $image_quality = 75;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($savePath . $file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($savePath . $file_path);
                $write_image = 'imagepng';
                $image_quality = 9;
                break;
            default:
                $src_img = null;
        }
        if (empty($src_img)) {
            echo CJSON::encode(array('code' => 1, 'data' => 'unknown'));
            return;
        }
        imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, $new_x, $new_y,
            $new_width,
            $new_height,
            $new_width,
            $new_height
        );
        $return_path = $savePath . 'avatar-' . $file_path;
        $write_image($new_img, $return_path, $image_quality);
        @imagedestroy($src_img);
        @imagedestroy($new_img);

        echo CJSON::encode(array('code' => 0, 'data' => Yii::app()->baseUrl . '/upload/avatar/avatar-' . $file_path));
    }
}
