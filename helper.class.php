<?php
defined('_JEXEC') or die;

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

    static public function loadCss($template)
    {
        // Determine the variables
        $cssmode            = $template->params->get('cssmode', 'css');
        $templateUrl        = 'templates/'.$template->template;
        $templateDir        = JPATH_SITE.'/templates/'.$template->template.'/';
        $doc                = JFactory::getDocument();

        $versionLess        = '1.6.3';
        $versionBootstrap   = '3.2.0';

        // remove RSForms css
        // it has been moved to less/extra
        unset($doc->_styleSheets['/components/com_rsform/assets/calendar/calendar.css']);
        unset($doc->_styleSheets['/components/com_rsform/assets/css/front.css']);

        // Google Fonts
        $doc->addStyleSheet('//fonts.googleapis.com/css?family=Roboto:400,300,700');
        $doc->addStyleSheet('//fonts.googleapis.com/css?family=Roboto+Slab:400,300,700');
        $doc->addStyleSheet('//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300');

        switch($cssmode)
        {
            case 'lessjs':
                // Load LESS.js
                $doc->addStyleSheet($templateUrl.'/less/template.less','text/less');
                $doc->addScript($templateUrl.'/js/cloudflare/less.compiler.params.js'); // @todo: jisse: Why CloudFlare???
                $doc->addScript('//cdnjs.cloudflare.com/ajax/libs/less.js/' . $versionLess . '/less.min.js');
                unset($doc->_scripts[JPATH_SITE.'/media/jui/js/bootstrap.min.js']);
                $doc->addScript('//netdna.bootstrapcdn.com/bootstrap/' . $versionBootstrap . '/js/bootstrap.min.js');
                break;

            case 'fofless':
                // Automatically compile LESS using FOF
                jimport('fof.include');
                FOFTemplateUtils::addLESS('template://templates/'.$template->template.'/less/template.less');
                break;

            case 'lessphp':
                // Automatically compile LESS using http://leafo.net/lessphp
                require_once $templateDir.'lib/lessc.inc.php';
                $less = new lessc;
                $less->checkedCompile($templateDir.'less/template.less', $templateDir.'less/compiled.css');
                $doc->addStyleSheet($templateUrl.'/css/compiled.css');
                break;

            case 'lessc':
                // Automatically compile LESS using https://github.com/oyejorge/less.php
                $cssFile = $templateDir.'css/compiled.css';
                $lessFile = $templateDir.'less/template.less';
                if(filemtime($lessFile) > filemtime($cssFile)) {
                    require_once $templateDir.'lib/vendor/oyejorge/less.php/lessc.inc.php';
                    $parser = new Less_Parser();
                    $parser->parseFile($lessFile, JURI::root());
                    $css = $parser->getCss();
                    file_put_contents($cssFile, $css);
                }
                $doc->addStyleSheet($templateUrl.'/css/compiled.css');
                break;

            default:
                // Load basic CSS
                $doc->addStyleSheet($templateUrl.'/css/compiled.css');
        }
    }
}
