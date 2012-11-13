<ul class="m-nav2">
    <li class="user"><a href="#"></a></li>
    <li><a class="text" href="<?=$this->createUrl('post/text');?>" title="文字"></a></li>
    <li><a class="photo" href="<?=$this->createUrl('post/photo');?>" title="照片"></a></li>
    <li><a class="music" href="<?=$this->createUrl('post/music');?>" title="音乐"></a></li>
    <li><a class="video" href="<?=$this->createUrl('post/video');?>" title="视频"></a></li>
</ul>
<input type="hidden" id="fetch_url" value="post/getlikes">

<div class="feed-zone" id="feed_zone">

</div>

<img id="loading_more" src="<?=Yii::app()->baseUrl?>/images/loading-more.gif"/>
<div id="back_to_top" class="scroll-to-top"></div>
