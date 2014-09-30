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

// Detecting Active Variables
$option                 = $app->input->getCmd('option', '');
$view                   = $app->input->getCmd('view', '');
$layout                 = $app->input->getCmd('layout', '');
$task                   = $app->input->getCmd('task', '');
$itemid                 = $app->input->getCmd('Itemid', '');

$grid                   = 12;
$gridSidebar            = 3;
$gridSidebarPos         = 'left';
$gridSidebarOffset      = 1;

// Instantiate the helper class
$helper = new ThisTemplateHelper();

// Include adjust meta tags in HEAD
$helper->adjustHead($this);

// Include CSS
$helper->loadCss($this);

// Include Analytics
$analyticsData = $helper->getAnalytics($this);

// Logo
$logo = $helper->getLogo($this);

// Load SVG Injection
if ($this->params->get('svginjection'))
{
    $helper->getSVGInjector($this);
}






// Determine home
if($helper->isHome()) { 
    $siteHome = "home";
} else {
    $siteHome = "sub";
}

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
if ($this->countModules('left')) $SidebarA = true;
if (!empty($active) && $active->home == true) $SidebarA = false;


// Check upon the current page layout
$pagelayout = $this->params->get('pagelayout', '1column');
if($SidebarA == true) $pagelayout = '2column-left';


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

