<div class="clearfix"></div>
<?php if (isset($post)): ?>
<input type="hidden" data-post='<?=CJSON::encode($post)?>'/>
<?php ?>
<?php endif; ?>
<input type="hidden" data-repost='<?=CJSON::encode($repost)?>'/>

<div id="pb_main_title" class="clearfix">
    <span>转载帖子</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <?php switch ($repost->type) {
        case 'text':
            ?>
                <h3 class="w-ttl"><em>标题</em>
                    <small>(可不填)</small>
                </h3>
                <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text" id="title"
                       value="<?=$repost->head?>">
                <?php break;
        case 'music':
            ?>
                <input type="hidden" data-song='<?=CJSON::encode($repost->head)?>'
                       class="music-input"/>
                <?php break;
        case 'video':
            ?>
                <embed
                    src="http://player.youku.com/player.php/sid/<?=Common::getYouKuId($repost->head)?>/v.swf"
                    allowFullScreen="true" quality="high" width="480" height="400" align="middle"
                    allowScriptAccess="always"
                    type="application/x-shockwave-flash"></embed>
                <?php break;
        case 'image':
            ?>
                <img src="<?=$repost->head['url']?>" alt="<?=$repost->head[0]['desc']?>"
                     width="600"/>
                <span>共&nbsp;<?=count($repost->head)?>&nbsp;张</span>
                <?php break;
    }?>
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>内容</em></h3>
        <textarea id="myEditor"><?php if(isset($post)):echo $post->content?><?php else:?><br>来自：<?=CHtml::link($repost->blog->name, array('blog/view'))?><br>
            <blockquote><?=$repost->content?></blockquote><?php endif;?>
        </textarea>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布" id="submit">
        </div>
    </div>

</div>