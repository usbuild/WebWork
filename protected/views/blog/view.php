<ul class="m-nav2">
    <li class="user"><a href="#"></a></li>
    <li><a class="text" href="<?=$this->createUrl('post/text');?>" title="文字"></a></li>
    <li><a class="photo" href="<?=$this->createUrl('post/photo');?>" title="照片"></a></li>
    <li><a class="music" href="<?=$this->createUrl('post/music');?>" title="音乐"></a></li>
    <li><a class="video" href="<?=$this->createUrl('post/video');?>" title="视频"></a></li>
</ul>
<input type="hidden" value="<?=$blog->id?>" id="blog_id"/>



<div class="feed-zone" id="feed_zone">
    <?php foreach ($posts as $post): ?>
    <?php $blog = $post->blog; ?>
    <div class="feed feed-<?=$post->type?>">

        <div class="feed-content-holder pop">
            <div class="link-to-post-holder" style="display: none; ">
                <div class="link-to-post-inner" style="background-position: 0px -135px; ">
                    <a href="http://usbuild.diandian.com/post/2012-10-26/40041346844" target="_blank"
                       class="link-to-post" title="查看文章 - 17:26">查看文章</a>
                </div>
            </div>
            <div class="feed-container-top"></div>
            <div class="pop-content clearfix">
                <div class="feed-hd no-content">
                    <div class="feed-basic"></div>
                </div>
                <div class="feed-bd no-hd-content">
                    <h4 class="feed-title"><?php if ($post->type === 'text'): ?><?= $post->content['title'] ?><?php endif;?></h4>

                    <div class="feed-ct">
                        <div class="feed-txt-full rich-content">
                            <div class="feed-txt-summary"><?=$post->content['content']?></div>
                        </div>
                    </div>
                    <div class="feed-act">
                        <a class="feed-rt" target="_blank"
                           href="http://www.diandian.com/reblog/usbuild/426c08b0-1f4f-11e2-8136-782bcb43ae03">转载</a>
                        <a class="feed-del">删除</a>
                        <a href="http://www.diandian.com/edit/426c08b0-1f4f-11e2-8136-782bcb43ae03"
                           class="feed-edit">编辑</a>
                        <a class="feed-cmt" data-nid="426c08b0-1f4f-11e2-8136-782bcb43ae03">回应</a></div>
                </div>
            </div>
            <div class="feed-container-bottom"></div>
            <div class="post-flag-panel"></div>
        </div>

    </div>
    <?php endforeach;?>
</div>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>