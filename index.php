<?php
defined('_JEXEC') or die;

// Load This Template Helper
include_once JPATH_THEMES . '/' . $this->template . '/helper.php';
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

<body class="<?php echo $siteHome ; ?>-page <?php echo $option . " view-" . $view . " itemid-" . $itemid . "";?>">

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P3MMH8"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-P3MMH8');</script>
<!-- End Google Tag Manager -->

<header class="navbar navbar-default navbar-fixed-top" id="top" role="banner">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="../" class="navbar-brand"><img src="/images/logo-miraokuls-spektaokul.png" alt="Miraokuls Spektaokul"></a>
        </div>
        <nav class="collapse navbar-collapse bs-navbar-collapse" id="navigation" role="navigation">
            <jdoc:include type="modules" name="menu" style="basic" />
        </nav>
    </div>
</header>

<?php if($this->countModules('hero')) : ?>
<jdoc:include type="modules" name="hero" style="hero" />
<?php endif; ?>

<?php if($this->countModules('toneel')) : ?>
<section class="toneel-row"
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="toneel" style="nice" />
        </div>
    </div>
</section>
<?php endif; ?>


<?php if($this->countModules('toneel1')) : ?>
<section class="toneel-row"
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="toneel1" style="nice" />
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($this->countModules('programma')) : ?>
<section class="programma-row">
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="programma" style="nice" />
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($this->countModules('herinneringen-submit or herinneringen-bekijken')) : ?>
<section class="herinnering-row">
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="herinneringen-submit" style="nice" />
            <jdoc:include type="modules" name="herinneringen-bekijken" style="standard" />
        </div>
    </div>
</section>
<?php endif; ?>

<section class="content-row">
    <div class="container<?php echo ThisTemplateHelper::isHome() ? '-fluid' : '';?>">
        <div class="row">
            <div class="col-sm-<?php echo $this->countModules('sidebar-a') ? '8' : '16'; ?><?php echo ThisTemplateHelper::isHome() ? ' border-right' : ''; ?>">
                <?php if($this->countModules('content-top')) : ?>
                <jdoc:include type="modules" name="content-top" style="standard" />
                <?php endif; ?>
                
                <jdoc:include type="message" />
                <jdoc:include type="component" />
                
                <?php if($this->countModules('content-bottom')) : ?>
                <jdoc:include type="modules" name="content-bottom" style="standard" />
                <?php endif; ?>
            </div>
            <?php if($this->countModules('sidebar-a')) : ?>
            <div class="col-sm-8">
                <jdoc:include type="modules" name="sidebar-a" style="nice" />
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if($this->countModules('doneer')) : ?>
<section class="doneer-row">
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="doneer" style="nicerounded" />
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($this->countModules('bottom')) : ?>
<section class="bottom-row">
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="bottom" style="standard" />
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($this->countModules('footer')) : ?>
<footer class="footer-row" role="contentinfo">
    <div class="container-fluid">
        <div class="row">
            <jdoc:include type="modules" name="footer" style="nice" />
        </div>
    </div>
</footer>
<?php endif; ?>

</body>
</html>