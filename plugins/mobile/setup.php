<?php
/*
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2010 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

// Init the hooks of the plugins -Needed

function plugin_init_mobile() {
   global $PLUGIN_HOOKS, $LANG;
 
   Plugin::registerClass('PluginMobileCommon');

	$PLUGIN_HOOKS['csrf_compliant']['mobile'] = true;   

   $PLUGIN_HOOKS['helpdesk_menu_entry']['mobile'] = "index.php";

   $PLUGIN_HOOKS['config_page']['mobile'] = 'index.php';


   $menu_entry  = 'index.php';

/*   if ((
      isset($_SESSION['glpiactiveprofile'])
      && $_SESSION['glpiactiveprofile']['config'] != "w"
   ) || (
      isset($_SESSION['glpi_plugin_mobile_profile'])
      && $_SESSION['glpi_plugin_mobile_profile']['mobile_user'] == ''
   )) $menu_entry  = false;
*/
   $PLUGIN_HOOKS['helpdesk_menu_entry']['mobile'] = $menu_entry;   
   $PLUGIN_HOOKS['menu_entry']['mobile'] = $menu_entry;


   $PLUGIN_HOOKS['headings']['mobile'] = 'plugin_get_headings_mobile';
   $PLUGIN_HOOKS['headings_action']['mobile'] = 'plugin_headings_actions_mobile';

   $PLUGIN_HOOKS['change_profile']['mobile'] = array('PluginMobileProfile','changeProfile');

   $PLUGIN_HOOKS['redirect_page']['mobile'] = 'index.php';

   $plug = new Plugin;
   if ($plug->isInstalled('mobile') && $plug->isActivated('mobile')) {
      require_once GLPI_ROOT."/plugins/mobile/inc/common.function.php";
      checkParams();
      if (isNavigatorMobile()) redirectMobile();
   }

}


// Get the name and the version of the plugin - Needed
function plugin_version_mobile() {

   return array('name'           => 'Mobile',
                'version'        => '1.1.0',
                'author'         => '<a href=\'mailto:adelaunay@teclib.com\'>Alexandre DELAUNAY</a>',
                'license'        => 'GPLv2+',
                'homepage'       => 'http://www.teclib.com/',
                'minGlpiVersion' => '0.84');
}


// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_mobile_check_prerequisites() {

   if (GLPI_VERSION >= 0.84) {
      return true;
   } else {
      echo "GLPI version not compatible need 0.84";
   }
}


// Check configuration process for plugin : need to return true if succeeded
// Can display a message only if failure and $verbose is true
function plugin_mobile_check_config($verbose=false) {
   global $LANG;

   if (true) { // Your configuration check
      return true;
   }
   if ($verbose) {
      echo $LANG['plugins'][2];
   }
   return false;
}


?>
