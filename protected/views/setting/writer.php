<input type="hidden" value="novalue" id="blog_id_input">
<div id="setting_container">
    <div class="writer-blog-list">
        <?php foreach ($blog as $b): ?>
        <li class="writer-blog-item">
            <div class="writer-blog-avatar"><img src="<?=Yii::app()->baseUrl . $b->avatar?>" alt=""></div>
            <div class="writer-blog-name"><a target="_blank" href="<?=$this->createUrl('view/' . $b->id)?>"><?=$b->name?></a></div>
            <div class="writer-blog-action">
                <a class="writer-blog-write" href="<?=$this->createUrl('writer/write/'.$b->id)?>">写作</a>
                <a class="writer-blog-all" href="">已有文章</a>
            </div>
        </li>
        <?php endforeach; ?>
    </div>
</div>