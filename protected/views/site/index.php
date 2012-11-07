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
    <div class="feed feed-<?=$post->type?>">
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
                       class="link-to-post" title="查看文章 - 17:26">查看文章</a>
                </div>
            </div>
            <div class="feed-container-top"></div>
            <div class="pop-content clearfix">
                <div class="feed-hd no-content">
                    <div class="feed-basic"></div>
                </div>
                <div class="feed-bd no-hd-content">

                    <?php switch ($post->type) {
                    case 'text':
                        ?>
                        <h4 class="feed-title"><?=$post->content['title']?></h4>
                        <?php break;
                    case 'image':
                        $i = 5;
                        ?>
                        <div class="feed-image">
                            <?php foreach ($post->content['title'] as $img): ?>
                            <div class="feed-image-item">
                                <p>
                                    <?php $i--;
                                    if ($i < 0) break;
                                    echo '<img src="' . $img['url'] . '" alt="' . $img['desc'] . '" width="500px" />'
                                    ?>
                                </p>
                            </div>
                            <?php endforeach;?>
                            <span style="color: #ccc; font-size: small;">共有(<?=count($post->content['title'])?>)张</span><br><br>
                        </div>

                        <?php break;
                    case 'music':
                        ?>
                        <input type="hidden" data-song='<?=CJSON::encode($post->content['title'])?>' class="music-input"/>
                        <br><br>
                        <?php break;
                    case 'video':
                        ?>
                        <embed src="http://player.youku.com/player.php/sid/<?=Common::getYouKuId($post->content['title'])?>/v.swf"
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
                                    class="feed-txt-summary"><?=mb_strimwidth(strip_tags($post->content['content']), 0, 200, "...");?></div>
                        </div>
                    </div>

                    <div class="feed-act">
                        <a class="feed-rt" target="_blank" href="#">转载</a>
                        <a class="feed-del">删除</a>
                        <a href="#" class="feed-edit">编辑</a>
                        <a class="feed-cmt" data-nid="#">回应</a>
                    </div>
                </div>
            </div>
            <div class="feed-container-bottom"></div>
            <div class="post-flag-panel"></div>
        </div>

    </div>
    <?php endforeach; ?>
</div>