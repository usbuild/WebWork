<div class="clearfix"></div>

<div id="pb_main_title" class="clearfix">
    <span>转载帖子</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <?php switch ($post->type) {
        case 'text':
            ?>
            <h3 class="w-ttl"><em>标题</em>
                <small>(可不填)</small>
            </h3>
            <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text" id="title"
                   value="<?=$post->head?>">
            <?php break;
        case 'music':
            ?>
            <input type="hidden" data-song='<?=CJSON::encode($post->head)?>'
                   class="music-input"/>
            <?php break;
        case 'video':
            ?>
            <embed
                    src="http://player.youku.com/player.php/sid/<?=Common::getYouKuId($post->head)?>/v.swf"
                    allowFullScreen="true" quality="high" width="480" height="400" align="middle"
                    allowScriptAccess="always"
                    type="application/x-shockwave-flash"></embed>
            <?php break;
        case 'image':
            ?>
            <img src="<?=$post->content['title'][0]['url']?>" alt="<?=$post->content['title'][0]['desc']?>"
                 width="600"/>
            <span>共&nbsp;<?=count($post->content['title'])?>&nbsp;张</span>
            <?php break;
    }?>
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>内容</em></h3>
        <script id="myEditor">来自：<?=CHtml::link($post->blog->name, array('blog/view'))?><br><blockquote><?=$post->content?></blockquote></script>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布" id="submit">
        </div>
    </div>

</div>