<html>
<head>
    <title>出错啦!</title>
    <style type="text/css">
        .error-title {
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 20px;
            margin-left: 20px;
        }

        .error-detail {

            border: solid lightgray 1px;
            border-radius: 5px;
            text-align: center;

            padding: 40px;
        }

        .container {
            width: 600px;
            margin: 100px auto;
        }

        .error-num {
            color: red;
            font-size: 25px;
            font-weight: bold;
        }

        .operation {
            margin-top: 20px;
            font-size: 13px;
        }

        .operation a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="error-title">访问出错啦</div>

    <div class="error-detail">
        <span class="error-num"><?php echo $code; ?></span>
        <hr>
        <?php echo CHtml::encode($message); ?>
        <div class="operation">
            <a href="<?=Yii::app()->createUrl('/')?>">回到首页</a> 或 <a href="javascript:history.go(-1)">返回上页</a>
        </div>
    </div>
</div>
</body>
</html>