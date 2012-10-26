<h3>博客</h3>
<select name="blog" id="blog_id">
    <?php foreach ($blogs as $blog): ?>
    <option value="<?=$blog->id?>"><?=$blog->name?></option>
    <?php endforeach;?>
</select>
<h3>标签</h3>
<input type="text" id="tags" />
<h3>标题</h3>
<input type="text" name="title" id="title"/><br>
<h3>内容</h3>
<div id="myEditor"></div>


<button id="submit_text" class="btn">发布</button>