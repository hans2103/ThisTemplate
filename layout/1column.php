<?php
defined('_JEXEC') or die;
?>
<div class="col-sm-<?php echo $grid; ?>">
    <?php if($this->countModules('content-top')) : ?>
        <jdoc:include type="modules" name="content-top" style="standard" />
    <?php endif; ?>
 
    <div class="content">
        <jdoc:include type="message" />
        <jdoc:include type="component" />
    </div>
 
    <?php if($this->countModules('content-bottom')) : ?>
    <jdoc:include type="modules" name="content-bottom" style="standard" />
    <?php endif; ?>
</div>
