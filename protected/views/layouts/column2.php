<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="left-side">
    <div id="content">
        <?php echo $content; ?>
    </div>
    <!-- content -->
</div>
<div class="right-side last">
    <div id="sidebar">
        <?php if (isset($this->sidebar)) echo $this->sidebar;?>
    </div>
    <!-- sidebar -->
</div>
<?php $this->endContent(); ?>