<?php
defined('_JEXEC') or die;
?>
<div class="<?php echo 'col-sm-'.($grid - $gridSidebar).' col-sm-push-'.$gridSidebar; ?><?php echo $helper->isHome() ? ' border-right' : ''; ?>">
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
<aside id="left" class="<?php echo 'col-sm-'.($gridSidebar).' col-sm-pull-'.($grid - $gridSidebar); ?>">
    <jdoc:include type="modules" name="left" style="nice" />
    <jdoc:include type="modules" name="left-usermenu" style="nice" />
</aside>
