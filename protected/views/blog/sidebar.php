<div class="m-menu">
    <div class="menut"></div>
    <div class="menum">
        <ul>
            <li class="first"><a href="<?=$this->createUrl('view/' . $blog->id)?>" class="mi" target="_blank"><span
                class="txt go-blog">访问博客</span></a>
            </li>
            <li><a href="<?=$this->createUrl('blog/follows/' . $blog->id)?>" class="mi"><span
                class="txt follow-blog"><?=$blog->followCount()?>
                &nbsp;个关注</span></a>
            </li>

            <li><a href="<?=$this->createUrl('blog/writer/' . $blog->id)?>" class="mi"><span
                class="txt follow-blog"><?=$blog->writerCount()?>
                &nbsp;个创作者</span></a>
            </li>

            <li><a href="<?=$this->createUrl('blog/request/' . $blog->id)?>" class="mi"><span
                class="txt follow-blog"><?=$blog->requestCount()?>
                &nbsp;个投递</span></a>
            </li>

            <li class="noipt"><a class="mi mi-noipt" href="<?=$this->createUrl('setting/blog/' . $blog->id)?>"><span
                class=" icn icn-2"></span><span
                class="txt">博客设置</span></a></li>
        </ul>
    </div>
    <div class="menub"></div>
</div>
