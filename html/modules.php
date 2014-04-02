<?php
defined('_JEXEC') or die;

// Basic
function modChrome_basic($module, &$params, &$attribs)
{
    if ($module->content) {
        echo $module->content;
    }
}

function modChrome_hero($module, &$params, &$attribs)
{
    if (!empty ($module->content)) : ?>
    <section class="hero" <?php if ($params->get('backgroundimage')) : ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?>>
    <div class="container module<?php echo $params->get('moduleclass_sfx'); ?> module-<?php echo $module->id; ?>">
        <div class="module-inner clearfix">
            <?php if ($module->showtitle) : ?>
            <div class="module-header">
                    <h1><?php echo $module->title; ?></h1>
            </div>
            <?php endif; ?>
            <?php echo $module->content; ?>
        </div>
    </div>
    </section>
    <?php endif;
}

function modChrome_nice($module, &$params, &$attribs)
{
    $headerLevel = $params->get('header_tag');
    if (!empty ($module->content)) : ?>
    <div class="module<?php echo $params->get('moduleclass_sfx'); ?> module-<?php echo $module->id; ?>">
        <div class="module-inner clearfix">
            <?php if ($module->showtitle) : ?>
            <div class="module-header">
                <<?php echo $headerLevel; ?>><?php echo $module->title; ?></<?php echo $headerLevel; ?>>
            </div>
            <?php endif; ?>
            <div class="module-content">
                <?php echo $module->content; ?>
            </div>
        </div>
    </div>
    <?php endif;
}

function modChrome_nicerounded($module, &$params, &$attribs)
{
    $headerLevel = $params->get('header_tag');
    if (!empty ($module->content)) : ?>
    <div class="module">
        <div>
            <div>
                <div>
    <div class="<?php echo $params->get('moduleclass_sfx'); ?> module-<?php echo $module->id; ?>">
        <div class="module-inner clearfix">
            <?php if ($module->showtitle) : ?>
            <div class="module-header">
                <<?php echo $headerLevel; ?>><?php echo $module->title; ?></<?php echo $headerLevel; ?>>
            </div>
            <?php endif; ?>
            <div class="module-content">
                <?php echo $module->content; ?>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;
}