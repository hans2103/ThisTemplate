<?php
// no direct access
defined('_JEXEC') or die;

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

class ThisTemplateHelper 
{
    static public function isHome() 
    {
        // Fetch the active menu-item
        $menu = JFactory::getApplication()->getMenu();
        $active = $menu->getActive();

        // Return whether this active menu-item is home or not
        return (boolean)$active->home;
    }
}

if(ThisTemplateHelper::isHome()) { 
    $siteHome = "home";
} else {
    $siteHome = "sub";
}

// add remove css
unset($doc->_styleSheets[$this->baseurl.'/components/com_rsform/assets/calendar/calendar.css']);
unset($doc->_styleSheets[$this->baseurl.'/components/com_rsform/assets/css/front.css']);
$doc->addStyleSheet('//fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,600,300,700');
if (true) {
    $doc->addStyleSheet($template.'/css/template.css');
} else {
    $doc->addStyleSheetLess($template.'/less/template.less');
    $doc->addScript($template.'/js/cloudflare/less.compiler.js');
    $doc->addScript('//cdnjs.cloudflare.com/ajax/libs/less.js/1.6.3/less.min.js');
}
$doc->addScript('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js');
$doc->addScript($template.'/js/application.js');
if($browser->getBrowser() == 'msie' && $browser->getMajor() < 9 ) {
    $stylelink = '<!--[if lt IE 9]>' ."\n";
    $stylelink .= '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>' ."\n";
    $stylelink .= '<![endif]-->' ."\n";
    $doc->addCustomTag($stylelink);
}