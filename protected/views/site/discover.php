<div class="follow-zone">
    <?php foreach ($blogs as $blog): ?>
    <div class="follow-item clearfix">
        <div class="follow-item-avatar">
            <img src="<?=Yii::app()->baseUrl . $blog->avatar?>" alt="头像" width="64" height="64"/>
        </div>
        <div class="follow-item-content">
            <div class="follow-item-name"><a href=""><?=$blog->name?></a></div>
            <div class="follow-item-action">
                <?php if ($blog->isFollow()): ?>
                <a href="">取消关注</a>
                <?php else: ?>
                <a href="">关注</a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>