<?php
/*
 * @version $Id: pluginimage.send.php 20129 2013-02-04 16:53:59Z moyo $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2013 by the INDEPNET Development Team.

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
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/** @file
* @brief   Purpose of file: Send image generated by a plugin to browser

   Arguments :
   - plugin : name of the plugin, also the subdir in files/_plugins
   - name : of the image in the files/_plugins/xxxx dir
   - clean : delete the image after send it

*/

include ('../inc/includes.php');

if (!isset($_GET["name"]) || !isset($_GET["plugin"])) {
   Event::log("-1", "system", 2, "security",
              //TRANS: %s is user name
              sprintf(__('%s makes a bad usage.'), $_SESSION["glpiname"]));
   die("security");
}

if ((basename($_GET["name"]) != $_GET["name"])
    || (basename($_GET["plugin"]) != $_GET["plugin"])) {

   Event::log("-1", "system", 1, "security",
              sprintf(__('%s tries to use a non standard path.'), $_SESSION["glpiname"]));
   die("security");
}
$Path = GLPI_PLUGIN_DOC_DIR."/".$_GET["plugin"]."/";

// Now send the file with header() magic
header("Expires: Sun, 30 Jan 1966 06:30:00 GMT");
header('Pragma: private'); /// IE BUG + SSL
header('Cache-control: private, must-revalidate'); /// IE BUG + SSL
header('Content-disposition: filename="' . $_GET["name"] . '"');
header("Content-type: image/png");

if (file_exists($Path.$_GET["name"])) {
   readfile($Path.$_GET["name"]);
   if (isset($_GET["clean"])) {
      unlink($Path.$_GET["name"]);
   }
} else {
   readfile($CFG_GLPI['root_doc'] . "/pics/warning.png");
}
?>