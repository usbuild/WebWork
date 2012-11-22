<input type="hidden" value="<?=$blog->id?>" id="blog_id_input"/>

<div class="follow-zone">
    <?php foreach ($follows as $blog): ?>
    <div class="follow-item clearfix">
        <div class="follow-item-avatar">
            <img src="<?=Yii::app()->baseUrl . $blog->avatar?>" alt="头像" width="64" height="64"/>
        </div>
        <div class="follow-item-content">
            <div class="follow-item-name"><a href=""><?=$blog->name?></a></div>
            <div class="follow-item-action"><a href="javascript:;" id="toggle_follow" data-id="<?=$blog->id?>"
                                               data-follow="<?php if ($blog->isFollow()) echo 0; else echo 1;?>"
                >
                <?php if ($blog->isFollow()): ?>
                取消关注
                <?php else: ?>
                关注
                <?php endif;?>
            </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>