<div class="clearfix"></div>

<?php if (isset($post)): ?>
<input type="hidden" data-post='<?=CJSON::encode($post)?>'/>
<?php endif; ?>

<div id="pb_main_title" class="clearfix">
    <span>发布音乐</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <h3 class="w-ttl"><em>搜索音乐</em>
            <small>(输入歌名、专辑或艺术家)</small>
        </h3>
        <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text" id="title">

        <div id='thumb_box' class="clearfix">
            <div class="close" id="close_thumb"><a href="javascript:;" id="close_btn">x</a></div>
        </div>
    </div>
    <div id="auto_helper" style="display: none">
        <a href="javascript:;" id="prev_page" style="display: none;">上一页</a>
        <a href="javascript:;" id="next_page" style="display: none;">下一页</a>
        <span style="font-size: small;color: #ccc;" class="hint">共找到<span id="total"></span>条结果 感谢 <a
            href="http://xiami.com">虾米网</a> 提供搜索结果
            </span>
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