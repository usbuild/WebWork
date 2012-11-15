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
<div class="login-form-container form">
    <div class="login-logo"></div>
    <?php if (isset($message)): ?>
    <div class="message">
        <?= $message;?>
    </div>
    <?php endif;?>
    <form action="<?=$this->createUrl('site/signup')?>" method="post">
        <div class="row">
            <input type="text" name="email" placeholder="邮箱" id="signup_email"/>
        </div>

        <div class="row">
            <input type="text" name="name" placeholder="昵称" id="signup_nick"/>
        </div>
        <div class="row">
            <input type="password" name="password" placeholder="密码" id="signup_pass"/>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('注册'); ?>
        </div>
    </form>
</div>
<a class="button-blue right-top" href="<?=$this->createUrl('site/login')?>">登录</a>
</body>
<!-- form -->

</html>