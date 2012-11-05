<input type="hidden" value="<?=Yii::app()->user->model->blog?>" id="blog_id_input"/>

<div id="blog_setting">
    <div class="g-box3">
        博客设置
    </div>


    <div class="g-box2 clearfix">
        <div class="setting-item">
            博客头像
        </div>
        <div class="setting-content">
            <div class="blog_avatar">
                <img src="<?=Yii::app()->baseUrl . $blog->avatar?>" alt="<?=$blog->name?>"/>
                <img src="" alt="" id="upload_img"/>
            </div>
            <div class="upload_operation">
                <input type="file" name="file" id="file"/>
            </div>
        </div>
    </div>


</div>
