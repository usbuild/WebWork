<input type="hidden" value="<?=$blog->id?>" id="blog_id_input"/>
<?php
/**
 * User: usbuild
 * DateTime: 12-11-22  下午3:09
 */
?>
<div class="add-area">
    <input class="add-writer" type="text" id="add_writer_txt"/>
    <input type="button" id="add_writer_btn" value="确认" class="add-writer-btn"/>
</div>
<ul class="writer-list">
    <?php foreach ($blog->writers as $w): ?>
    <?php $b = $w->user->myblog ?>
    <li class="writer-item" data-id="<?=$b->id?>">
        <div class="writer-info">
            <div class="writer-avatar"><img src="<?=Yii::app()->baseUrl . $b->avatar?>" alt="头像"></div>
            <div class="writer-name"><a href="<?=$this->createUrl('view/' . $b->id)?>"><?= $b->name?></a></div>
            <div class="writer-delete"><a href="javascript:;">X</a></div>
        </div>
    </li>
    <?php endforeach;?>
</ul>