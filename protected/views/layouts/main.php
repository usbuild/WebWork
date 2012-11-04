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
        <div class="opt-holder">
            <ul>
                <li id="logout"><a href="#"></a></li>
                <li id="setting"><a href="#"></a></li>
                <li id="discover"><a href="#"></a></li>
            </ul>
        </div>
        <div class="link-holder">
            <ul>
                <li><a href="<?=Yii::app()->homeUrl?>" class="active">主页</a></li>
                <?php foreach (Common::getBlogs() as $blog): ?>
                <li><?= CHtml::link($blog->name, array('blog/view/' . $blog->id)) ?></li>
                <?php endforeach;?>
                <li><a href="<?=Yii::app()->homeUrl?>" id="add_blog"></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="container">
    <?php echo $content; ?>
    <div class="clear"></div>
</div>
<!-- page -->

</body>
</html>
