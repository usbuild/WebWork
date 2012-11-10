<ul class="m-nav2">
    <li class="user"><a href="#"></a></li>
    <li><a class="text" href="<?=$this->createUrl('post/text');?>" title="文字"></a></li>
    <li><a class="photo" href="<?=$this->createUrl('post/photo');?>" title="照片"></a></li>
    <li><a class="music" href="<?=$this->createUrl('post/music');?>" title="音乐"></a></li>
    <li><a class="video" href="<?=$this->createUrl('post/video');?>" title="视频"></a></li>
</ul>


<div class="feed-zone" id="feed_zone">
    <?php foreach ($posts as $post): ?>
    <?php $blog = $post->blog; ?>
    <div class="feed feed-<?=$post->type?>" data-id="<?=$post->id?>"<?php if ($post->repost_id): ?>
         data-parent-id="<?=$post->repost_id?>"<?php endif;?>>
        <div class="feed-avatar">
            <a href="<?=$this->createUrl('blog/view/' . $blog->id)?>"
               style="background-image: url('<?=Yii::app()->baseUrl . $blog->avatar?>')" class="blog-avatar">
            </a>
        </div>

        <div class="feed-content-holder pop">
            <div class="pop-triangle"></div>
            <div class="link-to-post-holder" style="display: none; ">
                <div class="link-to-post-inner" style="background-position: 0px -135px; ">
                    <a href="#" target="_blank"
                       class="link-to-post" title="查看文章">查看文章</a>
                </div>
            </div>
            <div class="feed-container-top"></div>
            <div class="pop-content clearfix">
                <div class="feed-hd no-content">
                    <div class="feed-basic">
                        <?php $data = array();?>
                        <?php if ($post->type == 'repost'): ?>
                        转载自 <?= $post->repost->blog->name ?>
                        <?php else: ?>
                        <?= $blog->owner0->name ?>
                        <?php endif;?>
                    </div>
                </div>
                <div class="feed-bd no-hd-content">
                    <?php if ($post->type == 'repost'): ?>

                    <?php $repost = $post->repost;
                    if ($repost != null) {
                        $post->head = $repost->head;
                        $post->type = $repost->type;
                        $data['hot_count'] = $repost->hotCount() + $post->hotCount();
                    } else {

                    }
                    ?>
                    <?php else: ?>
                    <?php
                    $data['hot_count'] = $post->hotCount();
                    ?>

                    <?php endif;?>

                    <?php switch ($post->type) {
                    case 'text':
                        ?>
                            <h4 class="feed-title"><?=$post->head?></h4>
                            <?php break;
                    case 'image':
                        $i = 2; //maxshow
                        ?>
                            <div class="feed-image">
                                <?php foreach ($post->head as $img): ?>
                                <?php $i--;
                                if ($i < 0) break;?>
                                <div class="feed-image-item">
                                    <p>
                                        <?php
                                        echo '<img src="' . $img['url'] . '" alt="' . $img['desc'] . '" width="500px" />'
                                        ?>
                                    </p>
                                </div>
                                <?php endforeach;?>
                                <span style="color: #ccc; font-size: small;">共有(<?=count($post->head)?>
                                    )张</span><br><br>
                            </div>

                            <?php break;
                    case 'music':
                        ?>
                            <input type="hidden" data-song='<?=CJSON::encode($post->head)?>'
                                   class="music-input"/>
                            <br><br>
                            <?php break;
                    case 'video':
                        ?>
                            <embed
                                src="http://player.youku.com/player.php/sid/<?=Common::getYouKuId($post->head)?>/v.swf"
                                allowFullScreen="true" quality="high" width="480" height="400" align="middle"
                                allowScriptAccess="always"
                                type="application/x-shockwave-flash"></embed>
                            <br><br>

                            <?php break;
                    default:
                        break; ?>

                            <?php
                }?>

                    <div class="feed-ct">
                        <div class="feed-txt-full rich-content">
                            <div
                                class="feed-txt-summary"><?=mb_strimwidth(strip_tags($post->content), 0, 200, "...");?></div>
                        </div>
                    </div>

                    <div class="feed-tag clearfix">
                        <?php foreach ($post->tag as $tag): ?>
                        <a href="#" class=" ">#<?=$tag?></a>
                        <?php endforeach;?>
                        <?php if (count($post->tag) == 0) echo "没有标签";?>
                    </div>

                    <div class="feed-act">
                        <?php if ($post->isMine()): ?>

                        <a href="javascript:;" class="feed-delete">删除</a>

                        <a href="<?=$this->createUrl('post/edit/' . $post->id)?>" target="_blank"
                           class="feed-edit">编辑</a>

                        <a class="feed-cmt" href="javascript:;">回应(<span
                            class="cmt-reply-count"><?=$post->commentCount()?></span>)</a>

                        <a href="javascript:;" class="feed-nt">热度(<span
                            class="cmt-hot-count"><?=$data['hot_count']?></span>)</a>

                        <a class="feed-fav <?php if ($post->like()) echo 'feed-faved';?>" href="javascript:;"
                           title="喜欢" style="display: none;">喜欢</a>

                        <?php else: ?>

                        <a class="feed-fav <?php if ($post->like()) echo 'feed-faved';?>" href="javascript:;"
                           title="喜欢">喜欢</a>

                        <a class="feed-rt" target="_blank"
                           href="<?=$this->createUrl('post/repost/' . $post->id)?>">转载</a>

                        <a class="feed-cmt" href="javascript:;">回应(<span
                            class="cmt-reply-count"><?=$post->commentCount()?></span>)</a>

                        <a href="javascript:;" class="feed-nt">热度(<span
                            class="cmt-hot-count"><?=$data['hot_count']?></span>)</a>

                        <?php endif;?>

                    </div>
                </div>
            </div>

            <div class="feed-ft J_FeedFooter">
                <div class="feed-ft-bottom"></div>
                <div class="feed-ft-triangle J_FeedFooterTriangle"></div>

                <div class="feed-fold-container comment">

                    <div class="feed-comment">
                        <div class="cmt-at-list clearfix"></div>
                        <div class="add-comment clearfix">

                            <textarea name="" class="cmt-content"></textarea>
                            <button class="cmt-submit">提交</button>

                        </div>
                        <div class="register-third" style="display: none"></div>
                        <ul class="cmt-list"></ul>
                        <div class="cmt-load-more">显示更多</div>
                    </div>

                </div>
                <div class="feed-fold-container notes">
                    <div class="feed-notes">
                        <ul class="nt-list"></ul>
                        <div class="nt-load-more">显示更多</div>
                    </div>
                </div>

                <div class="comment-container-bottom"><a href="javascript:;" class="slide-up">收起</a></div>


            </div>


            <div class="feed-container-bottom"></div>

            <div class="post-flag-panel"></div>
        </div>

    </div>
    <?php endforeach; ?>
</div>