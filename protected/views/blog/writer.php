<input type="hidden" value="<?=$blog->id?>" id="blog_id_input"/>
<?php
/**
 * User: usbuild
 * DateTime: 12-11-22  下午3:09
 */
?>
<input class="add-writer" type="text"/>
<ul class="writer-list">
    <?php foreach ($blog->writers as $w): ?>
    <?php $b = $w->user->myblog ?>
    <li class="writer-item">
        <div class="writer-info">
            <div class="writer-avatar"><img src="<?=Yii::app()->baseUrl . $b->avatar?>" alt="头像"></div>
            <div class="writer-name"><?= $b->name?></div>
        </div>
    </li>
    <?php endforeach;?>
</ul>