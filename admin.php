<?php

/*
 * @version $Id: admin.php 30 2017-05-01 15:01:00Z hi $
 *
 */

/*
 * hi_FancyBox for CMSimple - module admin
 *
 * Admin-interface for configuring the plugin
 * via the standard-functions of pluginloader.
 *
 * @author Holger Irmler
 * @link http://CMSimple.HolgerIrmler.de
 * @version 4.1
 * @date: 2017-05-01
 * @build: 2017050101
 */

if ((!function_exists('sv')) || preg_match('/admin.php/i', sv('PHP_SELF')))
    die('Access denied');

define('HI_FANCYBOX_MAIN', '4.1 - 2017-05-01');
define('HI_FANCYBOX_ADMIN', '4.1');

/*
 * Register the plugin menu items.
 */
if (function_exists('XH_registerStandardPluginMenuItems')) {
    XH_registerStandardPluginMenuItems(false);
}

/*
 * Handle the administration.
 */
if (function_exists('XH_wantsPluginAdministration') && XH_wantsPluginAdministration('hi_fancybox') || isset($hi_fancybox) && $hi_fancybox == 'true') {
    $o .= print_plugin_admin('off');
    switch ($admin) {
        case '':
            $o .= hi_fancybox_info();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'hi_fancybox');
    }
}

function hi_fancybox_className($class = NULL) {
    return substr($class, ($pos = strpos($class, '.')) !== false ? $pos + 1 : 0);
}

function hi_fancybox_info() {
    global $plugin_cf, $plugin_tx;

    $t = '<h1>hi_FancyBox</h1>' . "\n";
    $t .= '<br>' . "\n";
    $t .= '<strong>Version: </strong>' . HI_FANCYBOX_MAIN . '<br>' . "\n";
    $t .= '&copy;2011 - 2017 Holger Irmler<br>' . "\n";
    $t .= 'Email: <a href="mailto:CMSimple@HolgerIrmler.de">CMSimple@HolgerIrmler.de</a><br>' . "\n";
    $t .= 'Website: <a href="http://cmsimple.holgerirmler.de" target="_blank">http://CMSimple.HolgerIrmler.de</a><br>' . "\n";
    $t .= '<br>' . "\n";
    $t .= 'If you like this plugin, or using it in a commercial scope,<br>' . "\n";
    $t .= 'consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=2888355" target="_blank">donating a few bucks to me via PayPal</a>.<br>' . "\n";
    $t .= '<br>' . "\n";
    $t .= '<hr size="1">' . "\n";
    $t .= '<br>' . "\n";
    $t .= $plugin_tx['hi_fancybox']['usage'] . '<br>' . "\n";
    $t .= $plugin_tx['hi_fancybox']['usage2'] . '<br>' . "\n";
    $t .= '<b>' . hi_fancybox_className($plugin_cf['hi_fancybox']['class_single']) . '</b> ' . $plugin_tx['hi_fancybox']['class1'] . '<br>' . "\n";
    $t .= '<b>' . hi_fancybox_className($plugin_cf['hi_fancybox']['class_group']) . '</b> ' . $plugin_tx['hi_fancybox']['class2'] . '<br>' . "\n";
    $t .= '<b>' . hi_fancybox_className($plugin_cf['hi_fancybox']['class_iframe']) . '</b> ' . $plugin_tx['hi_fancybox']['class3'] . '<br>' . "\n";
    $t .= '<br>' . "\n";
    $t .= '<hr size="1">' . "\n";
    $t .= '<br>' . "\n";
    return $t;
}

?>