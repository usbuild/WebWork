<?php
/**
 * User: usbuild
 * DateTime: 12-11-23  下午3:09
 */
class WriterController extends Controller
{
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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/autosize/jquery.autosize-min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/file-upload/css/jquery.fileupload-ui.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/file-upload/js/vendor/jquery.ui.widget.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/file-upload/js/jquery.iframe-transport.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/file-upload/js/jquery.fileupload.js', CClientScript::POS_END);

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/writer/index.js', CClientScript::POS_END);
        $this->sidebar = $this->renderPartial('sidebar', array(), true);
    }

    public function actionWrite($id)
    {
        $this->pageTitle = '协作 - 发布文章';
        $blog = Blog::model()->findByPk($id);
        $this->render('index', array('blog' => $blog, 'request' => 0));
    }

    public function actionRequest($id)
    {
        $blog = Blog::model()->findByPk($id);
        $this->pageTitle = $blog->name . ' - 投递文章';
        $this->render('index', array('blog' => $blog, 'request' => 1));
    }
}
