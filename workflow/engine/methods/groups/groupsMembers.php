<?php
/**
 * groupsMembers.php
 *
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2008 Colosa Inc.23
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * For more information, contact Colosa Inc, 2566 Le Jeune Rd.,
 * Coral Gables, FL, 33134, USA, or email info@colosa.com.
 */

$access = $RBAC->userCanAccess('PM_USERS');
if ($access != 1) {
    switch ($access) {
        case - 1:
            G::SendTemporalMessage('ID_USER_HAVENT_RIGHTS_PAGE', 'error', 'labels');
            G::header('location: ../login/login');
            die();
            break;
        case - 2:
            G::SendTemporalMessage('ID_USER_HAVENT_RIGHTS_SYSTEM', 'error', 'labels');
            G::header('location: ../login/login');
            die();
            break;
        default:
            G::SendTemporalMessage('ID_USER_HAVENT_RIGHTS_PAGE', 'error', 'labels');
            G::header('location: ../login/login');
            die();
            break;
    }
}

if (($RBAC_Response = $RBAC->userCanAccess("PM_USERS")) != 1) {
    return $RBAC_Response;
}

$G_MAIN_MENU = 'processmaker';
$G_SUB_MENU = 'users';
$G_ID_MENU_SELECTED = 'USERS';
$G_ID_SUB_MENU_SELECTED = 'GROUPS';

$G_PUBLISH = new Publisher();

$oHeadPublisher = headPublisher::getSingleton();

$oHeadPublisher->addExtJsScript('groups/groupsMembers', false); //adding a javascript file .js
$oHeadPublisher->addContent('groups/groupsMembers'); //adding a html file  .html.


$labels = G::getTranslations(array('ID_GROUPS','ID_GROUP_NAME','ID_BACK','ID_ASSIGN_ALL_MEMBERS','ID_REMOVE_ALL_MEMBERS','ID_MSG_AJAX_FAILURE','ID_PROCESSING','ID_ENTER_SEARCH_TERM','ID_FIRST_NAME','ID_LAST_NAME','ID_USER_NAME','ID_AVAILABLE_MEMBERS','ID_ASSIGNED_MEMBERS'));

$oGroup = new Groupwf();
$oGroup->load($_REQUEST['GRP_UID']);

$groups['GRP_UID'] = $_REQUEST['GRP_UID'];
$groups['GRP_TITLE'] = $oGroup->getGrpTitle();

//$oHeadPublisher->assign('TRANSLATIONS', $labels);
$oHeadPublisher->assign('GROUPS', $groups);
G::RenderPage('publish', 'extJs');
