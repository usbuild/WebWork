<div class="blog-info">
    <div class="avatar"><img src="<?=Yii::app()->baseUrl . $this->blog->avatar?>" alt="头像"></div>
    <div class="blog-name"><?=$this->blog->name?></div>
</div>
<div class="clear"></div>

<div class="feed-zone">
    <?php foreach ($model as $post): ?>
    <div class="feed">
        <div class="feed-hd no-content">
            <div class="feed-basic">
                <?php $data = array();?>
                <?php if ($post->type == 'repost'): ?>
                转载自 <a
                    href="<?=Yii::app()->baseUrl . $this->createUrl('view/' . $post->repost->blog->id)?>"><?= $post->repost->blog->name ?></a>
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
            case 'link':
                ?>
                    <h4 class="feed-title"><?=$post->head['title']?></h4>
                    <div class="feed-link-main">
                        <a href="<?=$post->head['link']?>"><?=$post->head['link']?></a>
                    </div>
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
                        <span style="color: #ccc; font-size: small;">共有(<?=count($post->head)?>)张</span><br><br>
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
                        src="<?=$post->head['flashUrl']?>"
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
            <div class="feed-op">
                <div class="feed-time">发表于<?=$post->time?></div>
                <div class="feed-read"><a href="<?=$this->createUrl('view/post/' . $post->id)?>">阅读更多</a></div>
            </div>


        </div>
    </div>
    <?php endforeach; ?>
</div>





<?php
$this->widget('CLinkPager', array(
    'currentPage' => $pages->getCurrentPage(),
    'itemCount' => $item_count,
    'pageSize' => $page_size,
    'maxButtonCount' => 5,
    'nextPageLabel' => '后页',
    'prevPageLabel' => '前页',
    'firstPageLabel' => '首页',
    'lastPageLabel' => '末页',
    'header' => '',
    'htmlOptions' => array('class' => 'pages'),
));
?>