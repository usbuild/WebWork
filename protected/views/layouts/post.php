<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="pb-main">
    <div id="content">
        <?php echo $content; ?>
    </div>
    <!-- content -->
</div>
<div class="pb-aside">
    <?php if (isset($this->sidebar)) echo $this->sidebar;?>
    <!-- sidebar -->
</div>
<?php $this->endContent(); ?>