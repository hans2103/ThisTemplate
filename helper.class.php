<?php
defined('_JEXEC') or die;

class ThisTemplateHelper 
{
    public function getDocument()
    {
        return JFactory::getDocument();
    }

    public function adjustHead($template)
    {
        // Determine the variables
        $doc                = $this->getDocument();
        $head               = $doc->getHeadData();
        $site_title         = $template->params->get('sitetitle');

        // remove deprecated meta-data (html5)
        //unset($head['metaTags']['http-equiv']);
        //unset($head['metaTags']['standard']['title']);
        //unset($head['metaTags']['standard']['rights']);
        //unset($head['metaTags']['standard']['language']);

        // Robots if you wish 
        //unset($head['metaTags']['standard']['robots']);

        $doc->setHeadData($head);

        // New meta
        //$doc->setMetadata( 'X-UA-Compatible', 'IE=edge,chrome=1' );
        //$doc->setMetadata( 'viewport', 'width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes' );
        //$doc->setMetadata( 'HandheldFriendly', 'true' );
        //$doc->setMetadata( 'apple-mobile-web-app-capable', 'yes' );
        //$doc->setMetadata( 'copyright', $site_title );

        //Yandex and Google Webmaster-tools if you wish
        //$doc->setMetadata('yandex-verification', 'xxxxxxxxxxxxxxxx');
        //$doc->setMetadata('google-verification', 'xxxxxxxxxxxxxxxx');

        // Remove or rewrite
        //$doc->setGenerator('');
        $doc->setGenerator($site_title);
    }

    public function isHome()
    {
        // Fetch the active menu-item
        $menu = JFactory::getApplication()->getMenu();
        $active = $menu->getActive();

        // Return whether this active menu-item is home or not
        return (boolean)$active->home;
    }

    public function loadCss($template)
    {
        // Determine the variables
        $doc                = JFactory::getDocument();
        $cssmode            = $template->params->get('cssmode', 'css');
        $templateUrl        = 'templates/'.$template->template;
        $templateDir        = JPATH_SITE.'/templates/'.$template->template.'/';

        $versionLess        = '1.6.3';
        $versionBootstrap   = '3.2.0';

        // remove RSForms css
        // it has been moved to less/extra
        unset($doc->_styleSheets['/components/com_rsform/assets/calendar/calendar.css']);
        unset($doc->_styleSheets['/components/com_rsform/assets/css/front.css']);

        // Google Fonts
        $doc->addStyleSheet('//fonts.googleapis.com/css?family=Open+Sans:400,300,700');

        switch($cssmode)
        {
            case 'lessjs':
                // Load LESS.js
                $doc->addStyleSheet($templateUrl.'/less/template.less','text/less');
                $doc->addScript($templateUrl.'/js/less.compiler.params.js');
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

    public function getAnalytics($template)
    {
        // Determine the variables
        $doc                = JFactory::getDocument();
        $analytics          = $template->params->get('analytics',0);
        $analyticsId        = $template->params->get('analyticsid');

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
                    return array('script' => $analyticsScript, 'position' => 'after_body_start');
                }
                break;
        }
    }

    public function getLogo($template)
    {
        // Determine the variables
        $sitebrand          = $template->params->get('sitebrand',0);
        $site_title         = $template->params->get('sitetitle');
        $site_tagline       = $template->params->get('sitetagline');
        $site_logo          = $template->params->get('sitelogo');
        $site_logosvg       = $template->params->get('sitelogosvg');
        $site_url           = JURI::root();

        // Site Logo
        switch ($sitebrand) {
            case 0:
                break;
            case 1:
                // using an image
                if ($site_logo AND $site_title)
                {
                    $logo = '<a href="' . $site_url . '/" class="navbar-brand"><img src="' . JURI::root() . $site_logo . '" alt="' . htmlspecialchars($site_title) . '" /></a>';
                    return $logo;
                }
                break;
            case 2:
                // using an SVG image
                if ($site_logosvg AND $site_title)
                    {
                        $logo = '<a href="' . $site_url . '/" class="navbar-brand"><img src="' . JURI::root() . 'images/' . $site_logosvg . '" alt="' . htmlspecialchars($site_title) . '" class="inject-me" /></a>';
                        // using SVGInjector to inject the image
                        $this->getSVGInjector($template);
                        return $logo;
                    }
                break;
            case 3:
                // using the title
                if ($site_title)
                {
                    $logo .= '<a href="' . $site_url . '/" class="navbar-brand">' . htmlspecialchars($site_title) . '</a>';
                    return $logo;
                }
                break;
            case 4:
                // using the title and the tag line
                if ($site_title AND $site_tagline)
                {
                    $logo .= '<a href="' . $site_url . '/" class="navbar-brand">' . htmlspecialchars($site_title) . '<small>' . htmlspecialchars($site_tagline) . '</small></a>';
                    return $logo;
                }
                break;
            case 5:
                // using the tag line
                if ($site_tagline)
                {
                    $logo .= '<span class="navbar-brand">' . htmlspecialchars($site_tagline) . '</span>';
                    return $logo;
                }
                break;
        }
    }

    public function getSVGInjector($template)
    {
        // Determine the variables
        $doc                = $this->getDocument();
        $templateUrl        = 'templates/'.$template->template;

        $doc->addScript($templateUrl.'js/svg-injector/svg-injector.min.js');
    }
}
