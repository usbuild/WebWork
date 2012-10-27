<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"
          media="screen, projection"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="header_holder" class="startpage">
    <div id="header" class="clearfix">
        <div id="logo_holder">
            <h1 id="logo"><a href="<?=Yii::app()->homeUrl?>">轻博客</a></h1>
        </div>
        <div class="home-holder"><a href="<?=Yii::app()->homeUrl?>">主页</a></div>
        <?php foreach (Common::getBlogs() as $blog): ?>
        <div class="blog-holder"><?= CHtml::link($blog->name, array('blog/view/' . $blog->id)) ?></div>
        <?php endforeach;?>
        <div class="opt-holder">
            各种操作
        </div>
    </div>
</div>
<div class="container">
    <?php echo $content; ?>
    <div class="clear"></div>
</div>
<!-- page -->

</body>
</html>
