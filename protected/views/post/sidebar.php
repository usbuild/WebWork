<div class="g-box2">
    <div class="clearfix">
        <h3 class="w-ttl"><em>发表在:</em></h3>
        <select name="blog" id="blog_id">
            <?php foreach (Common::getBlogs() as $blog): ?>
            <option value="<?=$blog->id?>"><?=$blog->name?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>
<div class="g-box2">
    <div class="clearfix">
        <h3 class="w-ttl"><em>标签</em>
            <small>(用逗号或回车分隔)</small>
        </h3>
        <textarea id="tags"></textarea>
    </div>
</div>
