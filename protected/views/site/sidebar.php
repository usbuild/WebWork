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
<?php endif; ?>