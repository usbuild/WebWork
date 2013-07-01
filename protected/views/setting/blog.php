<input type="hidden" value="<?=$blog->id?>" id="blog_id_input"/>

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
                <img src="<?=Yii::app()->baseUrl . $blog->avatar?>" alt="<?=$blog->name?>" width="64px" height="64px"
                     data-avatar="<?=$blog->avatar?>"/>
            </div>
            <div class="upload-operation">
                <input type="button" id="upload_btn" value="上传头像" class="button"/>

                <form action="" id="img_form">
                    <input type="file" name="file" id="file"/>
                </form>
            </div>
            <div class="upload-img-box" style="display: none;">
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
            <input type="text" class="normal-text" value="<?=$blog->name?>" id="blog_name"/>
        </div>
    </div>

    <div class="g-box2 clearfix">
        <div class="setting-item">
            域名:
        </div>
        <div class="setting-content">
            <input type="text" class="normal-text" value="<?=$blog->domain?>" id="blog_domain"/>
        </div>
        <div class="domain-suffix">.lecoding.com</div>
    </div>
    <div class="alert" style="display: none;margin: 20px 45px;
width: 525px;">

    </div>
    <div class="g-box2 clearfix">
        <div class="setting-content">
            <input type="submit" value="保存" class="button"/>
        </div>
    </div>

</div>
