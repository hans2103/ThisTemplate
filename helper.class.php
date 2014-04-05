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

        // remove RSForms css
        // it has been moved to less/extra
        unset($doc->_styleSheets[JPATH_SITE.'/components/com_rsform/assets/calendar/calendar.css']);
        unset($doc->_styleSheets[JPATH_SITE.'/components/com_rsform/assets/css/front.css']);

        // Google Fonts
        $doc->addStyleSheet('//fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,600,300,700');

        // Load LESS.js
        if ($cssmode == 'lessjs') {
            $doc->addStyleSheet($templateUrl.'/less/template.less');
            $doc->addScript($templateUrl.'/js/less.compiler.params.js');
            $doc->addScript('//cdnjs.cloudflare.com/ajax/libs/less.js/1.6.3/less.min.js');
            $doc->addScript('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js');

        // Automatically compile LESS using FOF
        } elseif ($cssmode == 'fofless') {
            jimport('fof.include');
            FOFTemplateUtils::addLESS('template://templates/'.$template->template.'/less/template.less');

        // Automatically compile LESS using http://leafo.net/lessphp
        } elseif ($cssmode == 'lessphp') {
            require_once $templateDir.'lib/lessc.inc.php';
            $less = new lessc;
            $less->checkedCompile($templateDir.'less/template.less', $templateDir.'less/compiled.css');
            $doc->addStyleSheet($templateUrl.'/css/compiled.css');

        // Automatically compile LESS using https://github.com/oyejorge/less.php
        } elseif ($cssmode == 'lessc') {
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

        // Load basic CSS
        } else {
            $doc->addStyleSheet($templateUrl.'/css/template.css');
        }
    }
}
