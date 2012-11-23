<div class="clearfix"></div>
<input type="hidden" data-blog='<?=CJSON::encode($blog)?>'/>
<input type="hidden" id="is_request" value="<?=$request?>">
<div id="pb_main_title" class="clearfix">
    <span><?php if (!$request) echo '发表在'; else echo '投递到';?>
        &nbsp;<?=CHtml::link($blog->name, array('view/' . $blog->id), array('target' => '_blank'))?></span>
</div>
<div class="pb-post-area">
    <div id="current_type">
    </div>

    <div class="g-box2">
        <h3 class="w-ttl"><em>描述</em>
            <small>(可不填)</small>
        </h3>
        <textarea id="myEditor"><?php if (isset($post)) echo $post->content;?></textarea>
    </div>
    <div class="g-box2">
        <div class="m-edtact">
            <input type="button" class="w-bbtn w-bbtn-0 publish ztag" value="发　布" id="submit">
        </div>
    </div>

</div>
<div class="hidden">
    <div id="post_text">
        <div class="g-box2">
            <h3 class="w-ttl"><em>标题</em>
                <small>(可不填)</small>
            </h3>
            <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text"
                   id="title" value="">
        </div>
    </div>


    <div id="post_image">
        <div class="g-box2">
            <ul id="img_list">
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
    </div>


    <div id="post_video">

        <div class="g-box2">
            <input type="hidden" id="video_info">

            <h3 class="w-ttl"><em>视频地址</em>
                <small>(支持优酷、土豆、bilibili)</small>
            </h3>
            <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text" id="title" value="">

            <div id='thumb_box'>
                <div class="close" id="close_thumb"><a href="javascript:;" id="close_btn">x</a></div>
            </div>
        </div>
    </div>

    <div id="post_music">
        <div class="g-box2">
            <h3 class="w-ttl"><em>搜索音乐</em>
                <small>(输入歌名、专辑或艺术家)</small>
            </h3>
            <input maxlength="50" class="w-inputxt w-inputxt-1 ztag jq-text" type="text" id="title">

            <div id='thumb_box' class="clearfix">
                <div class="close" id="close_thumb"><a href="javascript:;" id="close_btn">x</a></div>
            </div>
        </div>
        <div id="auto_helper" style="display: none">
            <a href="javascript:;" id="prev_page" style="display: none;">上一页</a>
            <a href="javascript:;" id="next_page" style="display: none;">下一页</a>
        <span style="font-size: small;color: #ccc;" class="hint">共找到<span id="total"></span>条结果 感谢 <a
            href="http://xiami.com">虾米网</a> 提供搜索结果
            </span>
        </div>
    </div>

    <div id="post_link">
        <div class="g-box2">
            <h3 class="w-ttl"><em>标题</em>
                <small>(可不填)</small>
            </h3>
            <input maxlength="50" class="w-inputxt w-inputxt-1 ztag" type="text"
                   id="title" value="<?php if (isset($post)) echo $post->head['title'] ?>">
        </div>

        <div class="g-box2">
            <h3 class="w-ttl"><em>链接</em>
            </h3>
            <input maxlength="50" class="w-inputxt w-inputxt-1 ztag" type="text"
                   id="link" value="<?php if (isset($post)) echo $post->head['link'] ?>">
        </div>
    </div>
</div>
