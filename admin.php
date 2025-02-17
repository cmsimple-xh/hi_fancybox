<?php

/*
 * hi_FancyBox for CMSimple - main module
 *
 * A simple plugin to include FancyBox (http://fancybox.net)
 * and apply it to predefined css-classes
 *
 * @author Holger Irmler
 * @link http://CMSimple.HolgerIrmler.de
 *
 * @copyright 2025 The CMSimple_XH developers <https://www.cmsimple-xh.org/?The_Team>
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 *
 * @license    GNU GPLv3 - http://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @version 4.2
 * @date: 2025-02-17
 * @build: 2025021701
 */

if ((!function_exists('sv')) || preg_match('/admin.php/i', sv('PHP_SELF')))
    die('Access denied');

define('HI_FANCYBOX_MAIN', '4.2 - 2025-02-17');
define('HI_FANCYBOX_ADMIN', '4.2');

/*
 * Register the plugin menu items.
 */
if (function_exists('XH_registerStandardPluginMenuItems')) {
    XH_registerStandardPluginMenuItems(true);
}

/*
 * Handle the administration.
 */
if (function_exists('XH_wantsPluginAdministration') && XH_wantsPluginAdministration('hi_fancybox') || isset($hi_fancybox) && $hi_fancybox == 'true') {
    $o .= print_plugin_admin('on');
    switch ($admin) {
        case '':
        case 'plugin_main':
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
    $t .= '&copy;2011 - 2024 Holger Irmler<br>' . "\n";
    $t .= '<a href="http://cmsimple.holgerirmler.de" target="_blank">http://CMSimple.HolgerIrmler.de</a><br>' . "\n";
    $t .= '&copy;2025 CMSimple_XH developers<br>' . "\n";
    $t .= '<a href="https://www.cmsimple-xh.org/?The_Team" target="_blank">https://www.cmsimple-xh.org/?The_Team</a><br>' . "\n";
    $t .= '<br>' . "\n";
    $t .= 'This plugin is published under <a target="_blank" href="https://www.gnu.org/licenses/">GNU General Public License</a>.<br>' . "\n";
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
