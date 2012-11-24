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
        if (Yii::app()->request->isPostRequest) {

            if (isset($_REQUEST['title'], $_REQUEST['content'], $_REQUEST['tags'], $_REQUEST['type'])) {
                $title = $_REQUEST['title'];
                $content = $_REQUEST['content'];
                if (strlen($_REQUEST['tags']) == 0) $tags = array();
                else
                    $tags = explode(',', $_REQUEST['tags']);

                $type = $_REQUEST['type'];
                if (($type === 'text' && strlen(trim($title)) + strlen(trim($content)) > 0)
                    || (in_array($type, array('image', 'video', 'music', 'link')) && !empty($title))
                ) {
                    $request = new Request();
                    $request->blog_id = $id;
                    $request->type = $type;
                    $request->head = json_encode($title);
                    $request->content = $content;
                    $request->tag = json_encode($tags);
                    $request->sender = Yii::app()->user->model->blog;
                    if ($request->save()) {
                        $request->refresh();
                        echo CJSON::encode(array('code' => 0, 'data' => $request));
                    } else {
                        echo CJSON::encode(array('code' => 1, 'data' => CHtml::errorSummary($request)));
                    }
                }
            }


        } else {
            $blog = Blog::model()->findByPk($id);
            $this->pageTitle = $blog->name . ' - 投递文章';
            $this->render('index', array('blog' => $blog, 'request' => 1));
        }
    }
}
