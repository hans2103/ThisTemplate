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
$template               = 'templates/' . $this->template;

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
$doc->setMetadata('X-UA-Compatible', 'IE=edge,chrome=1');
$doc->setMetadata('viewport', 'width=device-width, initial-scale=1.0');
// Copyrights
$doc->setMetadata('Author', 'Oeteldonksche Club van 1882');
$doc->setMetadata('copyright', htmlspecialchars($app->getCfg('sitename')));
//Yandex and Google Webmaster-tools if you wish
//$doc->setMetadata('yandex-verification', 'xxxxxxxxxxxxxxxx');
//$doc->setMetadata('google-verification', 'xxxxxxxxxxxxxxxx');

// Remove or rewrite
//$doc->setGenerator('');
$doc->setGenerator('Miraokuls Spektaokul');

// Detecting Active Variables
$option                 = $app->input->getCmd('option', '');
$view                   = $app->input->getCmd('view', '');
$layout                 = $app->input->getCmd('layout', '');
$task                   = $app->input->getCmd('task', '');
$itemid                 = $app->input->getCmd('Itemid', '');
$sitename               = $app->getCfg('sitename');

// To enable use of site configuration
$pageParams             = $app->getParams();

if(ThisTemplateHelper::isHome()) { 
    $siteHome = "home";
} else {
    $siteHome = "sub";
}

// Include CSS
ThisTemplateHelper::loadCss($this);



$doc->addScript($template.'/js/application.js');
if($browser->getBrowser() == 'msie' && $browser->getMajor() < 9 ) {
    $stylelink = '<!--[if lt IE 9]>' ."\n";
    $stylelink .= '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>' ."\n";
    $stylelink .= '<![endif]-->' ."\n";
    $doc->addCustomTag($stylelink);
}