<div class="">
    标签们: <br>
    <?php foreach ($follow_tags as $tag): ?>
    <?= $tag->tag ?>&nbsp;
    <?php endforeach; ?>
</div>
<div class="">
    博客们: <br>
    <?php foreach ($follow_blogs as $blog): ?>
    <?= $blog->name ?>
    <?php endforeach; ?>
</div>
<hr>
标签: <input type="text" id="tag"/>
<button class="btn btn-primary" id="new_tag">确认</button>
<br>
博客: <input type="text" id="blog_id"/>
<button id="new_blog" class="btn btn-primary">确认</button>
