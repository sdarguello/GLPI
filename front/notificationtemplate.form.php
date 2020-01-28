<?php
/*
 * @version $Id: notificationtemplate.form.php 20129 2013-02-04 16:53:59Z moyo $
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
* @brief
*/

include ('../inc/includes.php');

Session::checkCentralAccess();

if (!isset($_GET["id"])) {
   $_GET["id"] = "";
}

$notificationtemplate = new NotificationTemplate();
if (isset($_POST["add"])) {
   $notificationtemplate->check(-1,'w',$_POST);

   $newID = $notificationtemplate->add($_POST);
   Event::log($newID, "notificationtemplates", 4, "notification",
              sprintf(__('%1$s adds the item %2$s'), $_SESSION["glpiname"], $_POST["name"]));

   $language = new NotificationTemplateTranslation();
   $url      = Toolbox::getItemTypeFormURL('NotificationTemplateTranslation', true);
   $url     .="?notificationtemplates_id=$newID";
   Html::redirect($url);

} else if (isset($_POST["delete"])) {
   $notificationtemplate->check($_POST["id"],'d');
   $notificationtemplate->delete($_POST);

   Event::log($_POST["id"], "notificationtemplates", 4, "notification",
              //TRANS: %s is the user login
              sprintf(__('%s purges an item'), $_SESSION["glpiname"]));
   $notificationtemplate->redirectToList();

} else if (isset($_POST["update"])) {
   $notificationtemplate->check($_POST["id"],'w');

   $notificationtemplate->update($_POST);
   Event::log($_POST["id"], "notificationtemplates", 4, "notification",
              //TRANS: %s is the user login
              sprintf(__('%s updates an item'), $_SESSION["glpiname"]));
   Html::back();

} else {
   Html::header(NotificationTemplate::getTypeName(2), $_SERVER['PHP_SELF'], "config", "mailing",
                "notificationtemplate");
   $notificationtemplate->showForm($_GET["id"]);
   Html::footer();
}
?>