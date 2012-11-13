<div class="clearfix" xmlns="http://www.w3.org/1999/html"></div>
<?php if (isset($post)): ?>
<input type="hidden" data-post='<?=CJSON::encode($post)?>'/>
<?php endif; ?>
<div id="pb_main_title" class="clearfix">
    <span>发布链接</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <h3 class="w-ttl"><em>标题</em>
            <small>(可不填)</small>
        </h3>
        <input maxlength="50" class="w-inputxt w-inputxt-1 ztag" type="text"
               id="title" value="<?php if (isset($post)) echo $post->head['title'] ?>">
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>链接</em>
        </h3>
        <input maxlength="50" class="w-inputxt w-inputxt-1 ztag" type="text"
               id="link" value="<?php if (isset($post)) echo $post->head['link'] ?>">
    </div>


    <div class="g-box2">
        <h3 class="w-ttl"><em>描述</em>
            <small>(可不填)</small>
        </h3>
        <textarea id="myEditor"><?php if (isset($post)) echo $post->content;?></textarea>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布" id="submit">
        </div>
    </div>

</div>