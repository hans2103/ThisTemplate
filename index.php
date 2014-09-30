<?php
defined('_JEXEC') or die;

// Load This Template Helper
include_once JPATH_THEMES.'/'.$this->template.'/helper.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie10 lt-ie9 lt-ie8" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie10 lt-ie9" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 9]> <html class="no-js lt-ie10" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if !IE]><!--> <html class="no-js" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <!--<![endif]-->
<head>
<jdoc:include type="head" />
</head>

<body class="<?php echo $siteHome ; ?>-page <?php echo $option . " view-" . $view . " itemid-" . $itemid . "";?>" itemscope itemtype="http://schema.org/WebPage">

<?php 
    if (!empty($analyticsData) && $analyticsData['position'] == 'after_body_start') {
        echo $analyticsData['script'];
    }
?>

    <header class="navbar navbar-default navbar-fixed-top mh-docs-nav" id="top" role="banner">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".mh-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php echo $logo; ?>
        </div>
        <nav class="collapse navbar-collapse mh-navbar-collapse" role="navigation">
          <?php if ($this->countModules('menu')): ?>
          <jdoc:include type="modules" name="menu" style="none" />
          <?php endif; ?>
        </nav>
      </div>
    </header>

    <?php if ($this->countModules('carousel')): ?>
    <div class="fullscreenbanner-container revolution">
        <div class="fullscreenbanner revslider-initialised tp-simpleresponsive">
            <jdoc:include type="modules" name="carousel" style="standard" />
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->countModules('strapline')): ?>
    <div class="strapline">
        <div class="strapline">
            <jdoc:include type="modules" name="strapline" style="standard" />
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->countModules('top')): ?>
    <div class="light-wrapper">
        <div class="container inner">
            <jdoc:include type="modules" name="top" style="none" />
        </div>
    </div>
    <?php endif; ?>

    <div class="container inner">
        <div class="row">
            <?php if ($this->countModules('left')): ?>
            <aside class="col-md-<?php echo $gridSidebar; ?>">
                <section class="sidebar left-sidebar">
                    <jdoc:include type="modules" name="left" style="standard" />
                </section>
            </aside>
            <?php endif; ?>

            <?php if (!$isFrontpage || $frontpageshow): ?>
            <div class="col-md-<?php echo $span;?>">
                <jdoc:include type="message" />
                <jdoc:include type="component" />
            </div>
            <?php endif; ?>

            <?php if ($this->countModules('right')) : ?>
            <aside class="col-md-<?php echo $gridSidebar; ?> <?php if($offset) { echo 'col-md-offset-' . $gridSidebarOffset; } ?>">
                <section class="sidebar right-sidebar">
                    <jdoc:include type="modules" name="right" style="standard" />
                </section>
            </aside>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($this->countModules('middle')): ?>
    <div class="black-wrapper inner">
        <div class="container">
            <jdoc:include type="modules" name="middle" style="none" />
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->countModules('bottom1')): ?>
    <div class="light-wrapper">
        <div class="container inner">
            <jdoc:include type="modules" name="bottom1" style="none" />
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->countModules('bottom2')): ?>
    <div class="black-wrapper">
        <div class="inner">
            <jdoc:include type="modules" name="bottom2" style="none" />
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->countModules('footer1')): ?>
    <div class="light-wrapper">
        <div class="container inner">
            <jdoc:include type="modules" name="footer1" style="none" />
        </div>
    </div>
    <?php endif; ?>

    <div class="clear"></div>
<main id="content-wrapper">

</main>


    <footer id="footer" class="footer-wrapper">
        <?php if ($this->countModules('contact')): ?>
        <div class="container footer-contact">
            <jdoc:include type="modules" name="contact" style="none" />
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('contact')): ?>
        <div class="container footer-nav">
            <jdoc:include type="modules" name="contact" style="none" />
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('copyright')): ?>
        <div class="container footer-copyright">
            <div class="row">
                <div class="col-xs-4 col-xs-centered text-xs-center">
                    bla
                </div>
                <div class="col-xs-8 col-xs-centered text-xs-center">
                    <jdoc:include type="modules" name="copyright" style="none" />
                </div>
        </div>
        <?php endif; ?>
    </footer>

    <?php if ($totop) : ?>
    <a href="#" class="go-top">Back to Top <i class="fa fa-arrow-circle-up"></i></a>
    <?php endif; ?>
</div>


<?php if ($this->countModules('debug')): ?>
    <jdoc:include type="modules" name="debug" style="none" />
<?php endif; ?>

<?php 
    if (!empty($analyticsData) && $analyticsData['position'] == 'before_body_end') {
        echo $analyticsData['script'];
    }
?>

</body>
</html>
