<div class="message">
    <?php if (isset($message)) echo $message;?>
</div>

<form action="<?=$this->createUrl('site/signup')?>" method="post">
    Email: <input type="text" name="email"/><br>
    昵称: <input type="text" name="name"/><br>
    Password: <input type="password" name="password"/><br>
    <input type="submit"/>
</form>