<?php
// no direct access
defined('_JEXEC') or die;

// Include the helper-class
include_once dirname(__FILE__).'/helper.class.php';

// Browser detection
jimport('joomla.environment.browser');

// Variables
$app                    = JFactory::getApplication();
$doc                    = JFactory::getDocument();
$user                   = JFactory::getUser();
$browser                = JBrowser::getInstance();
$config                 = JFactory::getConfig();
$template               = 'templates/' . $this->template;
$logo_image             = $this->params->get('logoFile');
$site_title             = $config->get('sitename');
$site_desc              = $this->params->get('sitedescription');
$analytics              = $this->params->get('analytics');
$analyticsId            = $this->params->get('analyticsid');

// get html head data
$head                   = $doc->getHeadData();
// remove deprecated meta-data (html5)
unset($head['metaTags']['http-equiv']);
unset($head['metaTags']['standard']['title']);
unset($head['metaTags']['standard']['rights']);
unset($head['metaTags']['standard']['language']);
// Robots if you wish 
//unset($head['metaTags']['standard']['robots']);
$doc->setHeadData($head);

// New meta
$doc->setMetadata( 'X-UA-Compatible', 'IE=edge,chrome=1' );
$doc->setMetadata( 'viewport', 'width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes' );
$doc->setMetadata( 'HandheldFriendly', 'true' );
$doc->setMetadata( 'apple-mobile-web-app-capable', 'yes' );
$doc->setMetadata( 'copyright', $site_title );
//Yandex and Google Webmaster-tools if you wish
//$doc->setMetadata('yandex-verification', 'xxxxxxxxxxxxxxxx');
//$doc->setMetadata('google-verification', 'xxxxxxxxxxxxxxxx');

// Remove or rewrite
//$doc->setGenerator('');
$doc->setGenerator($site_title);

// Detecting Active Variables
$option                 = $app->input->getCmd('option', '');
$view                   = $app->input->getCmd('view', '');
$layout                 = $app->input->getCmd('layout', '');
$task                   = $app->input->getCmd('task', '');
$itemid                 = $app->input->getCmd('Itemid', '');
$sitename               = $app->getCfg('sitename');

$grid                   = 12;
$gridSidebar            = 3;
$gridSidebarPos         = 'left';
$gridSidebarOffset      = 1;


// To enable use of site configuration
$pageParams             = $app->getParams();

// Determine home (@todo: What is this, Hans?)
if(ThisTemplateHelper::isHome()) { 
    $siteHome = "home";
} else {
    $siteHome = "sub";
}

// Include CSS
ThisTemplateHelper::loadCss($this);

// Add scripts
$doc->addScript($template.'/js/application.js');
if($browser->getBrowser() == 'msie' && $browser->getMajor() < 9 ) {
    $stylelink = '<!--[if lt IE 9]>' ."\n";
    $stylelink .= '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>' ."\n";
    $stylelink .= '<![endif]-->' ."\n";
    $doc->addCustomTag($stylelink);
}

// Determine whether to show sidebar-A (@todo: Jisse, clean up this mess)
$SidebarA = false;
//$SidebarAMageBridgePages = array('customer', 'membership', 'software', 'sales');
//hideLeftMageBridgePages = array('customer/account/login');
//$hideLeftMenuItems = array(11, 185, 282, 308, 316, 332, 348, 353, 354, 355, 362, 380);
if ($this->countModules('left')) $SidebarA = true;
//if ($this->countModules('left-usermenu') && JFactory::getUser()->guest == 0) $SidebarA = true;
//if (JRequest::getCmd('option') == 'com_magebridge' && $magebridge->isPage($SidebarAMageBridgePages) == false) $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_magebridge' && $magebridge->isPage($hideLeftMageBridgePages)) $SidebarA = false;
if (!empty($active) && $active->home == true) $SidebarA = false;
//if (in_array(JRequest::getCmd('Itemid'), $hideLeftMenuItems)) $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_search') $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_kunena') $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_simplelists' && JRequest::getInt('category_id') == 239) $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_products' && JRequest::getCmd('view') == 'extension') $SidebarA = true;
//if (JRequest::getCmd('option') == 'com_products' && JRequest::getCmd('view') == 'extensions') $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_products' && JRequest::getCmd('view') == 'services') $SidebarA = false;
//if (JRequest::getCmd('option') == 'com_products' && JRequest::getCmd('view') == 'platform') $SidebarA = false;

// Check upon the current page layout
$pagelayout = $this->params->get('pagelayout', '1column');
if($SidebarA == true) $pagelayout = '2column-left';




// Favicon
if ($this->params->get('templateFavicon'))
{
  $this->addFavicon(JURI::root() . $this->params->get('templateFavicon'));
}

// Logo
if ($logo_image)
{
  // Custom logo image
  $logo = '<a href="' . $this->baseurl . '/" class="navbar-brand"><img src="' . JURI::root() . $logo_image . '" alt="' . $sitename . '" /></a>';
}
elseif (($site_title) && ($site_desc))
{
  // Title and description
  $logo = '<a href="' . $this->baseurl . '/" class="navbar-brand">' . htmlspecialchars($site_title) . '<span class="site-description">' . htmlspecialchars($site_desc) . '</span></a>';
}
elseif (($site_title) && (!$site_desc))
{
    // Title only
    $logo = '<a href="' . $this->baseurl . '/" class="navbar-brand">' . htmlspecialchars($site_title) . '</a>';
}
else
{
  // Load default template logo
  $logo = '<a href="' . $this->baseurl . '/" class="navbar-brand"><img src="' . JURI::root() . 'templates/' . $this->template . '/images/logo.png" alt="' . $sitename . '" /></a>';
}


// Width calculations
$span = '';

if ($this->countModules('left') && $this->countModules('right'))
{
	$span = ($grid - ( $gridSidebar + $gridSidebar ));
}
elseif ($this->countModules('left') && !$this->countModules('right'))
{
	$span = ($grid - $gridSidebar - $gridSidebarOffset);
	$offset = $gridSidebarOffset;

}
elseif (!$this->countModules('left') && $this->countModules('right'))
{
	$span = ($grid - $gridSidebar - $gridSidebarOffset);
	$offset = $gridSidebarOffset;
}
else
{
	$span = $grid;
}

// Analytics
switch ($analytics) {
    case 0:
        break;
    case 1:
        // Google Analytics - load in head
        if($analyticsId) {
            $analyticsScript = "

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '" . $analyticsId . "']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
";
            $doc->addScriptDeclaration($analyticsScript);
        }
        break;
    case 2:
        // Universal Google Universal Analytics - load in head
        if($analyticsId) {
            $analyticsScript = "

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '" . $analyticsId . "', 'auto');
  ga('send', 'pageview');
";
            $doc->addScriptDeclaration($analyticsScript);
        }
        break;
    case 3:
        // Google Analytics - load in head
        $isAnalyticsGTM = true;
        if($analyticsId) {
            $analyticsScript = "<!-- Google Tag Manager -->
<noscript><iframe src=\"//www.googletagmanager.com/ns.html?id=" . $analyticsId . "\"
height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','" . $analyticsId . "');</script>
<!-- End Google Tag Manager -->

";
        }
        break;
}