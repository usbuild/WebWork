<h3>发表在:</h3>
<select name="blog" id="blog_id">
    <?php foreach (Common::getBlogs() as $blog): ?>
    <option value="<?=$blog->id?>"><?=$blog->name?></option>
    <?php endforeach;?>
</select>
<br>
<br>
<h3>标签(用逗号或回车分隔)</h3>
<textarea id="tags"></textarea>
