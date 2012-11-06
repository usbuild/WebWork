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
                <img src="<?=Yii::app()->baseUrl . $blog->avatar?>" alt="<?=$blog->name?>" width="64px" height="64px"/>
            </div>
            <div class="upload-operation">
                <input type="button" id="upload_btn" value="上传头像" class="button"/>

                <form action="" id="img_form">
                    <input type="file" name="file" id="file"/>
                </form>
            </div>
            <div class="upload-img-box">
                <img src="" alt="" id="upload_img"/>

                <div>
                    <button id="img_ok" class="button">确认</button>
                    <button id="img_cancel" class="button">取消</button>
                </div>
            </div>
        </div>
    </div>

    <div class="g-box2 clearfix">
        <div class="setting-item">
            博客名称:
        </div>
        <div class="setting-content">
            <input type="text" class="normal-text"/>
        </div>
    </div>


</div>
