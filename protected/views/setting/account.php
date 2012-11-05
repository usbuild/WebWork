<div id="account_box">
    <div class="g-box3">
        修改密码
    </div>
    <div class="g-box2">
        <form class="form" action="" method="post" id="renew_pass">
            <div class="error-box" id="pass_error"></div>
            <div class="field">
                <label for="old_pass"><h4>旧密码:</h4></label>
                <input type="password" name="old_pass" id="old_pass"/>
            </div>
            <div class="field">
                <label for="new_pass"><h4>新密码:</h4></label>
                <input type="password" name="new_pass" id="new_pass" maxlength="30"/>
            </div>
            <div class="field">
                <label for="repeat_pass"><h4>重复密码:</h4></label>
                <input type="password" name="new_pass" id="repeat_pass" maxlength="30"/>
            </div>
            <input type="submit" value="提交" class="button"/>
        </form>
    </div>
</div>

    <?php
/**
 * Created by JetBrains PhpStorm.
 * User: usbuild
 * Date: 12-11-5
 * Time: 下午4:35
 */