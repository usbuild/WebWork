<?php
/**
 * User: usbuild
 * DateTime: 12-11-22  上午10:20
 */
class ViewController extends CController
{
    public $layout = '//view/layout';
    public $pageTitle;
    public $blog;

    public function init()
    {
        parent::init();
        Yii::app()->clientScript->registerScript('config', 'var baseUrl = "' . Yii::app()->baseUrl . '/";', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/view.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/view.css');
    }

    public function actionView($id)
    {

        $this->blog = Blog::model()->findByPk($_REQUEST['id']);
        if (empty($this->blog)) {
            throw new CHttpException(404);
        }

        $this->pageTitle = $this->blog->name;
        $criteria = new CDbCriteria();
        $criteria->condition = 'blog_id = :id';
        $criteria->order = 'time DESC';
        $criteria->params = array(':id' => $id);
        $item_count = Post::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->setPageSize(10);
        $pages->applyLimit($criteria);
        $this->render('index', array(
            'model' => Post::model()->findAll($criteria),
            'item_count' => $item_count,
            'page_size' => 10,
            'pages' => $pages,
        ));
    }

    public function actionPost($id)
    {
        $post = Post::model()->findByPk($id);
        if (empty($post)) {
            throw new CHttpException(404, $id);
        }
        $blog = $post->blog;
        $this->pageTitle = $blog->name;
        $this->render('post', array('post' => $post, 'comments' => $post->comments, 'blog' => $blog));
    }

    public function actionPreview($id)
    {
        $request = Request::model()->findByPk($id);
        $request->tag = json_decode($request->tag, true);
        $request->head = json_decode($request->head, true);
        $this->render('preview', array('post' => $request));
    }

}
