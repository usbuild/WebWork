<input type="hidden" value="no-value" id="blog_id_input">
<div id="setting_container">
    <div class="g-box3">
        <h2 class="w-fttl">
            <div class="diamond"></div>
            <a class="w-go" href="<?=$this->createUrl('setting/blog')?>">博客设置</a>帐号设置
        </h2>
    </div>

    <ul>
        <li>
            <div class="g-box2 clearfix">
                <div class="setting-item">
                    帐号信息
                </div>
                <div class="setting-content">
                    <span class="user-email"><?=Yii::app()->user->email?></span>
                    <div class="acount-link"><?=CHtml::link('修改邮箱和密码>>', array('setting/account'))?></div>
                </div>
            </div>
        </li>
    </ul>
</div>
