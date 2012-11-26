<html>
<head>
    <title><?php $this->pageTitle = Yii::app()->name . ' - Error'; ?></title>
</head>
<body>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>
</body>
</html>