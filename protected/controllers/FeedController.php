<?php

class Post extends Controller
{
    public function init() {
        Yii::app()->clientScript->registerScriptFile(, CClientScript::POS_HEAD);
        return parent::init();
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'text', 'image', 'link', 'refer'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (Yii::app()->request->isPostRequest) {

        } else {

        }
    }

    public function actionPostText()
    {

        $this->render('text', array());
    }
}
