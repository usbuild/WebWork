<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function init()
    {
        Yii::app()->clientScript->registerScript('config', 'var baseUrl = "' . Yii::app()->baseUrl . '/";', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_HEAD);


        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/apprise/apprise-1.5.full.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/apprise/apprise.css');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/tipsy/jquery.tipsy.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/plugins/tipsy/tipsy.css');


        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/global.js', CClientScript::POS_END);
        parent::init();
    }

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
}