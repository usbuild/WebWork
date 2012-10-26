<?php foreach ($blogs as $blog): ?>
    <?= CHtml::link($blog->name, array('blog/view/' . $blog->id)) ?>
<?php endforeach; ?>
个人主页
<br>
<input type="text" name="post" id="blog_name"/>
<input type="submit" value="新建博客" class="btn btn-primary" id="new_blog"/>

<div class="show-zone" id="show_zone">
    <?php foreach ($posts as $post): ?>

    <div>
        <?=$post->content['content']?>
    </div>
    <hr>
    <?php endforeach;?>
</div>