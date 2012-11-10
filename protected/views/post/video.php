<div class="clearfix"></div>
<?php if (isset($post)): ?>
<input type="hidden" data-post='<?=CJSON::encode($post)?>'/>
<?php endif; ?>
<div id="pb_main_title" class="clearfix">
    <span>发布视频</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <h3 class="w-ttl"><em>视频地址</em>
            <small>(仅支持Youku)</small>
        </h3>
        <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text" id="title" value="">

        <div id='thumb_box'>
            <div class="close" id="close_thumb"><a href="javascript:;" id="close_btn">x</a></div>
        </div>
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>描述</em></h3>
        <textarea id="myEditor"><?php if(isset($post)) echo $post->content;?></textarea>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布" id="submit">
        </div>
    </div>

</div>