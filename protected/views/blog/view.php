<input type="hidden" value="<?=$blog->id?>" id="blog_id_input"/>
<div id="publisher" class="publisher clearfix">
    <div class="pb-avatar with-tip" data-tip="设置博客">
        <a class="blog-avatar" href="<?=$this->createUrl('setting/blog/' . $myblog->id) ?>"
           style="background-image:url(<?=Yii::app()->baseurl . Yii::app()->user->model->myblog->avatar?>)">师乐园</a>
    </div>
    <div class="pb-action-holder">
        <div class="pb-triangle"></div>
        <div class="pb-action-shadow-top"></div>
        <div class="pb-action" id="pb-action">
            <ul class="clearfix">
                <li><a class="text" href="<?=$this->createUrl('post/text')?>">文字</a></li>
                <li><a class="photo" href="<?=$this->createUrl('post/photo')?>">图片</a></li>
                <li><a class="music" href="<?=$this->createUrl('post/music')?>">声音</a></li>
                <li><a class="video" href="<?=$this->createUrl('post/video')?>">影像</a></li>
                <li><a class="link" href="<?=$this->createUrl('post/link')?>">链接</a></li>
            </ul>
        </div>
        <div class="pb-action-shadow-bottom"></div>
    </div>
</div>

<input type="hidden" id="fetch_url" value="blog/getposts/<?=$blog->id?>">
<div class="feed-zone" id="feed_zone">

</div>

<img id="loading_more" src="<?=Yii::app()->baseUrl?>/images/loading-more.gif"/>
<div id="back_to_top" class="scroll-to-top"></div>
