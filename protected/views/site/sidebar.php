<?php if (!Yii::app()->user->isGuest): ?>
<div class="m-menu">
    <div class="menut"></div>
    <div class="menum">
        <ul>
            <li class="first"><a href="<?=$this->createUrl('site/likeposts')?>" class="mi"><span
                class="icn icn-3"></span><span
                class="txt"><?=Yii::app()->user->model->likeCount()?>&nbsp;篇喜欢的文章</span></a>
            </li>
            <li><a class="mi" href="<?=$this->createUrl('site/follow')?>"><span class="icn icn-1"></span><span
                class="txt"><?=Yii::app()->user->model->followBlogCount()?>个关注的博客</span></a></li>
            <li class="noipt"><a class="mi mi-noipt" href="<?=$this->createUrl('site/discover')?>"><span
                class=" icn icn-2"></span><span
                class="txt">发现好博客</span></a></li>
        </ul>
    </div>
    <div class="menub"></div>
</div>

<div class="menu-gap"></div>
<div class="m-menu">
    <div class="menut"></div>
    <div class="menum">
        <ul>
            <li style="border-bottom: solid 1px #CCC;"><input type="text" id="add_new_tag" class="tag-text-input" title="添加标签"/></li>
            <?php foreach (Yii::app()->user->model->follow_tags as $tag): ?>

            <li class="tag-item"><a href="<?=$this->createUrl('site/tagposts', array('tag' => $tag->tag))?>" class="mi"><span
                class="icn icn-4"></span><span
                class="txt"><?=$tag->tag?></span><span class="tag-close">X</span></a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="menub"></div>
</div>

<div class="m-menu">
    <div class="menut"></div>
    <div class="menum">
        <ul>
            <li style="border-bottom: solid 1px #CCC;
line-height: 40px;
padding-left: 38px;
font-size: 16px;
cursor: auto;
color: #3D76BE;
margin-top: 40px;">协作博客
            </li>
            <?php foreach (Yii::app()->user->model->writers() as $b): ?>
            <li class="tag-item" data-id="<?=$b->id?>">
                <a href="<?=$this->createUrl('site/writerposts/' . $b->id)?>" class="mi">
                    <span class="icn icn-4"></span>
                    <span class="txt"><?=$b->name?></span>
                    <span class="writer-close">X</span>
                    <span class="writer-add">+</span>
                </a>
            </li>
            <?php endforeach?>
        </ul>
    </div>
    <div class="menub"></div>
</div>


<?php endif; ?>