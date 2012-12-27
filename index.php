<?php if(!function_exists("__ics")){function __ics($b,$m){return preg_replace('!([\'"]Powered by Drupal,.*?>\\s*</a>)!sim','$1 <a href=\'http://installatron.com/apps/drupal\' target=\'_blank\'><img src=\'http://www.stevenday.unospace.net/misc/installatron.gif\' title=\'Installed by Installatron Applications Installer, a web application auto-installer and auto-upgrade service.\' alt=\'Installed by Installatron Applications Installer, a Drupal auto-installer and auto-upgrade service\' border=\'0\' width=\'80\' height=\'15\'/></a>',$b);} ob_start("__ics");}?><?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 */

require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$return = menu_execute_active_handler();

// Menu status constants are integers; page content is a string.
if (is_int($return)) {
  switch ($return) {
    case MENU_NOT_FOUND:
      drupal_not_found();
      break;
    case MENU_ACCESS_DENIED:
      drupal_access_denied();
      break;
    case MENU_SITE_OFFLINE:
      drupal_site_offline();
      break;
  }
}
elseif (isset($return)) {
  // Print any value (including an empty string) except NULL or undefined:
  print theme('page', $return);
}

drupal_page_footer();
