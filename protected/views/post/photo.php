<div class="clearfix"></div>

<div id="pb_main_title" class="clearfix">
    <span>发布图片</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <ul id="img_list"></ul>
        <div class="upload-img-box">
            <div type="button" id="upload_btn">上传</div>
            <span>jpg、gif、png或bmp格式，单张图片不超过2MB，支持文件拖拽上传。</span>
            <input id="fileupload" type="file" name="files[]" data-url="<?=$this->createUrl('picture/jqupload')?>"
                   multiple>
        </div>
    </div>
    <div id="progress">
        <div class="bar"></div>
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>内容</em></h3>
        <script id="myEditor"></script>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn delete ztag" value="取　消">
            <input style="display:none" type="button" class="w-bbtn save ztag" value="保存草稿">
            <input type="button" class="w-bbtn preview ztag" value="预　览">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布">
        </div>
    </div>

</div>