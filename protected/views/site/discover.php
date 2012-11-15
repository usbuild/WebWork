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
                <a href="javascript:;" id="toggle_follow" data-id="<?=$blog->id?>">取消关注</a>
                <?php else: ?>
                <a href="javascript:;" id="toggle_follow" data-id="<?=$blog->id?>" data-follow="1">关注</a>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>