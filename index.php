<?php

/*
 * @version $Id: index.php 28 2017-05-01 12:39:45Z hi $
 *
 */

/*
 * hi_FancyBox for CMSimple - main module
 *
 * A simple plugin to include FancyBox (http://fancybox.net)
 * and apply it to predefined css-classes
 *
 * @author Holger Irmler
 * @link http://CMSimple.HolgerIrmler.de
 * @version 4.1
 * @date: 2017-05-01
 * @build: 2017050101
 */

if ((!function_exists('sv')) || preg_match('#hi_fancybox' . DIRECTORY_SEPARATOR . 'index.php#i', sv('PHP_SELF')))
    die('Access denied');

function fancybox() {
    global $bjs, $hjs, $o, $plugin_cf, $plugin_tx, $pth;
    $fcbJs = '';

//Read settings for FancyBox from plugin_cf
    $fcbSettings = '';
    foreach ($plugin_cf['hi_fancybox'] as $key => $val) {
        if (substr($key, 0, 4) == 'fcb_') {
            $val == '' ? $val = 'false' : $val;
            $fcbSettings .= substr($key, 4) . ': ' . $val . ',';
        }
    }
    
    $onComplete = "fancyboxNavHide();";
    $onClosed = '';
    
    if ($plugin_cf['hi_fancybox']['activate_touchsupport']) {
        $onComplete = "window.addEventListener('orientationchange', "
                . "fcbOrientationChanged);"
                . $onComplete;
        $onClosed = "window.removeEventListener('orientationchange', "
                . "fcbOrientationChanged);";
    
        $fcbJs .= "\n" .
                '<script type="text/javascript">
                    /* <![CDATA[ */
                    var fcbOrientationChanged = function () {
                        $.fancybox.refresh();
                    };
                    /* ]]> */
		</script>' . "\n";
    } 
    
    $fcbSettings .=
            "'onComplete' : function() { "
            . $onComplete
            . " },";
    $fcbSettings .=
            "'onClosed' : function() { "
            . $onClosed
            . " },";
    //remove last comma
    $fcbSettings = substr($fcbSettings, 0, -1);


//Write the Script-tags to head section
//include jQuery-Plugin for CMSimple
    if (!file_exists($pth['folder']['plugins'] . 'jquery/jquery.inc.php')) {
        $o .= '<div class="cmsimplecore_warning">' .
                $plugin_tx['hi_fancybox']['jquery_missing'] .
                '</div>';
        //drop the rest of the plugin-code
        return($o);
    } else {
        //load inculde-file from jQuery-plugin
        include_once($pth['folder']['plugins'] . 'jquery/jquery.inc.php');
        //include jQuery to the <head>
        include_jQuery();
        //and the plugins...
        include_jQueryPlugin('fancybox', $pth['folder']['base'] . 'plugins/hi_fancybox/libs/fancybox/jquery.fancybox.min.js');
        //stylesheet
        $hjs .= "\n" . tag('link rel="stylesheet" type="text/css" media="screen" href="' . $pth['folder']['base'] . 'plugins/hi_fancybox/libs/fancybox/jquery.fancybox.min.css"');
        $hjs .= "\n";
        //include_jQueryPlugin('easing', $pth['folder']['base'] . 'plugins/hi_fancybox/libs/fancybox/fancybox-1.3.4/jquery.easing-1.3.pack.js');
        if ($plugin_cf['hi_fancybox']['activate_mousewheel']) {
            include_jQueryPlugin('mousewheel', $pth['folder']['base'] . 'plugins/hi_fancybox/libs/fancybox/jquery.mousewheel-3.1.2.min.js');
        }
        if ($plugin_cf['hi_fancybox']['activate_touchsupport']) {
            include_jQueryPlugin('jquery.mobile.touch', $pth['folder']['base'] . 'plugins/hi_fancybox/libs/fancybox/jquery.mobile.custom.min.js');
            include_jQueryPlugin('fancybox.touch', $pth['folder']['base'] . 'plugins/hi_fancybox/libs/fancybox/fancybox.touch.min.js');
        }
        
        //apply fancybox
        $plugin_cf['hi_fancybox']['nav_hide_title'] == "" ? $hideTitle = "false" : $hideTitle = "true";
        $fcbJs .= "\n" .
                '<script type="text/javascript">
                    /* <![CDATA[ */
                    jQuery(document).ready(function($){
                        $("' . $plugin_cf['hi_fancybox']['class_single'] . '").fancybox({' . $fcbSettings . '});
                        $("' . $plugin_cf['hi_fancybox']['class_group'] . '").attr(\'rel\', \'gallery\').fancybox({' . $fcbSettings . '});
                        $("' . $plugin_cf['hi_fancybox']['class_iframe'] . '").fancybox({' . $fcbSettings . ', autoscale: false, type: \'iframe\'});
                        $("#gallery_main a[rel^=\'fancybox\']").fancybox({' . $fcbSettings . ', type: \'image\'}); //for lb_Gallery
                        var fcbtimer = false;
                        function fancyboxNavHide() {
                            var duration = '. $plugin_cf['hi_fancybox']['nav_duration_hide'] .';
                            var hideTitle = '. $hideTitle .';
                            clearTimeout(fcbtimer);
                            $(\'span#fancybox-left-ico\').addClass(\'fancybox-left-ico-show\');
                            $(\'#fancybox-right-ico\').addClass(\'fancybox-right-ico-show\');
                            $(\'#fancybox-title\').show();
                            fcbtimer = setTimeout(function () {
                                $(\'span#fancybox-left-ico\').removeClass(\'fancybox-left-ico-show\');
                                $(\'span#fancybox-right-ico\').removeClass(\'fancybox-right-ico-show\');
                                if (hideTitle) {
                                    $(\'div#fancybox-title.fancybox-title-over\').fadeOut(\'fast\');
                                }
                            }, duration);
                        }
                        $(\'#fancybox-wrap\').on(\'click\', function () {
                            fancyboxNavHide();
                        });
                    });
                    /* ]]> */
		</script>' . "\n";

        if (isset($bjs)) {
            $bjs .= $fcbJs;
        } else {
            $hjs .= $fcbJs;
        }
    }
}

if ($plugin_cf['hi_fancybox']['activate_global'] && !$edit) {
    fancybox();
}