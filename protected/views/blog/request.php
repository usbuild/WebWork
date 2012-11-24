<ul class="request-list">
    <?php foreach ($model as $m): ?>
    <li class="request-item" data-id="<?=$m->id?>">
        <div class="request-blog-info">
            <div class="request-avatar"><img src="<?=Yii::app()->baseUrl . $m->sender0->myblog->avatar?>" alt="头像">
            </div>
            <div class="request-name"><a
                href="<?=$this->createUrl('view/' . $m->sender0->blog)?>"
                target="_blank"><?=$m->sender0->myblog->name?></a></div>
        </div>
        <div class="request-content"><?=mb_strimwidth(strip_tags($m->content), 0, 200, "...");?></div>
        <div class="request-action">
            <a class="request-remove" href="javascript:;">删除</a>
            <a class="request-view" href="<?=$this->createUrl('view/preview/' . $m->id)?>" target="_blank">查看</a>
            <a class="request-pass" href="javascript:;">通过</a>
        </div>
    </li>
    <?php endforeach; ?>
</ul>