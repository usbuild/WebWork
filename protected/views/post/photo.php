<div class="clearfix"></div>
<?php if (isset($post)): ?>
<input type="hidden" data-post='<?=CJSON::encode($post)?>'/>
<?php endif; ?>
<div id="pb_main_title" class="clearfix">
    <span>发布图片</span>
</div>
<div class="pb-post-area">

    <div class="g-box2">
        <ul id="img_list">

            <?php if (isset($post)): ?>

            <?php foreach ($post->head as $item): ?>
                <li>
                    <div class="photoList ztag">
                        <div id="" class="clearfix photoItem" opacityvalue="100" style="">
                            <div class="img"><img class="ztag" src="<?=$item['url']?>" width="60" height="60"
                                                  data-url="<?=$item['url']?>"/>
                            </div>
                            <div class="info">
                                <label class="desc" style="">描述：<input maxlength="500" type="text" class="txt"
                                                                       value="<?=$item['desc']?>"><span></span></label>
                            </div>
                            <div class="pimg move"></div>
                            <div class="pimg close"></div>
                        </div>
                    </div>
                </li>

                <?php endforeach; ?>
            <?php endif;?>

        </ul>
        <div id="progress_box">
            <div class="progress-bar hidden" id="proto_progress">
                <div class="img"><img class="ztag" src=""
                                      alt="" width="60px" height="60px"/></div>
                <div class="clearfix progress">
                    <div class="value"></div>
                    <div class="pimg close"></div>
                </div>
            </div>
        </div>

        <div class="photoList ztag hidden" id="proto_box">
            <div id="" class="clearfix photoItem" opacityvalue="100" style="">
                <div class="img"><img class="ztag" src=""/>
                </div>
                <div class="info">
                    <label class="desc" style="">描述：<input maxlength="500" type="text" class="txt"
                                                           value=""><span></span></label></div>
                <div class="pimg move"></div>
                <div class="pimg close"></div>
            </div>
        </div>


        <div class="upload-img-box">
            <div type="button" id="upload_btn">上传</div>
            <span id="original_text">jpg、gif、png或bmp格式，单张图片不超过2MB，支持文件拖拽上传。</span>
            <span id="hover_text" class="hidden">拖动多张图片到这里，直接上传</span>
            <input id="fileupload" type="file" name="files[]" data-url="<?=$this->createUrl('picture/jqupload')?>"
                   multiple>
        </div>
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>内容</em></h3>
        <textarea id="myEditor"><?php if (isset($post)) echo $post->content;?></textarea>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布" id="submit">
        </div>
    </div>

</div>