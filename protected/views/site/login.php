<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"
          media="screen, projection"/>
</head>
<body id="login_page">
<?php
$this->pageTitle = Yii::app()->name . ' - 登录';
?>

<div class="form login-form-container">
    <div class="login-logo" style="margin-left: 55px"></div>
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>

    <div class="row">
        <?php echo $form->textField($model, 'username', array('placeholder' => "邮箱")); ?>
    </div>

    <div class="row">
        <?php echo $form->passwordField($model, 'password', array('placeholder' => "密码")); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('登录'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<a class="button-blue right-top" href="<?=$this->createUrl('site/signup')?>">注册</a>
</body>
<!-- form -->

</html>
