<?php
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System //
// Copyright (c) 2000 xoopscube.org //
// <http://br.xoopscube.org> //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 2 of the License, or //
// (at your option) any later version.  //
//   //
// You may not change or alter any portion of this comment or credits //
// of supporting developers from this source code or any supporting //
// source code which is considered copyrighted (c) material of the //
// original comment or credit authors.  //
//   //
// This program is distributed in the hope that it will be useful, //
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the //
// GNU General Public License for more details. //
//   //
// You should have received a copy of the GNU General Public License //
// along with this program; if not, write to the Free Software //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Tobias Liegl (AKA CHAPI)  //
// Site: http://www.chapi.de  //
// Project: The XOOPS Project  //
// ------------------------------------------------------------------------- //
require_once 'admin_header.php';
if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        $$k = $v;
    }
}
if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        $$k = $v;
    }
}
/*********************************************************/
/* Tiny Event Calender - Admin */
/*********************************************************/
xoops_cp_header();
$myts = MyTextSanitizer::getInstance();
echo '<br>';
global $op;
switch ($op) {
    case 'save':
        te_admin_save($id);
        break;
    case 'savedb':
        $form_event = $myts->addSlashes($form_event);
        $form_info = $myts->addSlashes($form_info);
        $eventdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear);
        $eventdate2 = (empty($autoyear2)) ? null : mktime($autohour2, $automin2, 0, $automonth2, $autoday2, $autoyear2);
        $q = 'UPDATE ' . $xoopsDB->prefix() . "_tinyevent SET pub=1, date='" . $eventdate . "', date2='" . $eventdate2 . "', event='" . $form_event . "', info='" . $form_info . "' WHERE id='" . $form_id . "'";
        if ($xoopsDB->queryF($q)) {
            te_admin_message(_TE_EDIT_DONE, 0, '');
        } else {
            te_admin_message(_TE_EDIT_DBERROR, 1, '');
        }
        te_admin_list();
        te_admin_add();
        break;
    case 'edit':
        te_admin_edit($id);
        break;
    case 'editdb':
        $form_event = $myts->addSlashes($form_event);
        $form_info = $myts->addSlashes($form_info);
        $eventdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear);
        $eventdate2 = (empty($autoyear2)) ? null : mktime($autohour2, $automin2, 0, $automonth2, $autoday2, $autoyear2);
        $q = 'UPDATE ' . $xoopsDB->prefix() . "_tinyevent SET date='" . $eventdate . "', date2='" . $eventdate2 . "', event='" . $form_event . "', info='" . $form_info . "' WHERE id='" . $form_id . "'";
        if ($xoopsDB->queryF($q)) {
            te_admin_message(_TE_EDIT_DONE, 0, '');
        } else {
            te_admin_message(_TE_EDIT_DBERROR, 1, '');
        }
        te_admin_list();
        te_admin_add();
        break;
    case 'del':
        if ($xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix() . '_tinyevent WHERE id=' . $id . '')) {
            te_admin_message(_TE_DEL_OK, 0, '');
        } else {
            te_admin_message(_TE_EDIT_DBERROR, 1, '');
        }
        te_admin_list();
        te_admin_add();
        break;
    case 'delconfirm':
        OpenTable();
        $result = $xoopsDB->queryF('SELECT id, date, event FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE id='" . $id . "'", 1);
        $te_event = $xoopsDB->fetchArray($result);
        echo '<center><b>' . _TE_DEL_REALLY . '</b><br><br>' . $te_event['id'] . ' <b>|</b> ' . formatTimestamp($te_event['date']) . ' <b>|</b> ' . $te_event['event'] . "<br><br><a href='./index.php?op=del&id=" . $id . "'><b>" . _TE_DELETE . '</b></a><center>';
        CloseTable();
        break;
    case 'add':
        $form_event = $myts->addSlashes($form_event);
        $form_info = $myts->addSlashes($form_info);
        $done = true;
        if (empty($form_repeat)) {
            $eventdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear);

            $eventdate2 = (empty($autoyear2)) ? null : mktime($autohour2, $automin2, 0, $automonth2, $autoday2, $autoyear2);

            $q = 'INSERT INTO ' . $xoopsDB->prefix() . "_tinyevent (pub, date, date2, event, info) VALUES ('1', '" . $eventdate . "', '" . $eventdate2 . "', '" . $form_event . "', '" . $form_info . "')";

            $done = $xoopsDB->queryF($q);
        } else {
            for ($i = 0; $i < $form_repeat; $i++) {
                $eventdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear) + ($i * 86400);

                $eventdate2 = (empty($autoyear2)) ? null : mktime($autohour2, $automin2, 0, $automonth2, $autoday2, $autoyear2) + ($i * 86400);

                $q = 'INSERT INTO ' . $xoopsDB->prefix() . "_tinyevent (pub, date, date2, event, info) VALUES ('1', '" . $eventdate . "', '" . $eventdate2 . "', '" . $form_event . "', '" . $form_info . "')";

                $done = ($done && $xoopsDB->queryF($q));
            }
        }
        if ($done) {
            te_admin_message(_TE_ADD_DONE, 0, '');
        } else {
            te_admin_message(_TE_EDIT_DBERROR, 1, '');
        }
        te_admin_list();
        te_admin_add();
        break;
    case 'published':
        te_admin_published();
        break;
    case 'createdb':
        te_createdb();
        break;
    default:
        te_admin_list();
        te_admin_add();
        break;
}
include 'admin_footer.php';
/************************************************************/
/* Functions  */
/************************************************************/
function te_admin_published()
{
    global $xoopsDB, $xoopsConfig;

    OpenTable();

    echo "<table border=0 cellpadding=2 cellspacing=2 width='100%'><tr><td colspan=8><div align='center'><b>" . _TE_LIST_HEADER . '</b><br><br>' . _TE_MENUE_PUBLISHED . '</div></td></tr></table>';

    CloseTable();

    OpenTable();

    // Published Events

    echo "<table border=0 cellpadding=2 cellspacing=2 width='100%'><tr><td colspan=8><div align='center'>
<b>" . _TE_PUBLIC_HEADER . '</b></div></td></tr>
<tr>
<td><i>' . _TE_ID . '</i></td>
<td><i>' . _TE_DATE . '</i></td>
<td><i>' . _TE_DATE2 . '</i></td> 
<td><i>' . _TE_EVENT . '</i></td>
<td><i>' . _TE_EDIT . '</i></td>
<td><i>' . _TE_DELETE . '</i></td>
</tr>';

    // get all rows from db

    $result = $xoopsDB->queryF('SELECT id, date, date2, event FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE pub='1'");

    while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
        $date = formatTimestamp($te_event['date']);

        $date2 = (empty($te_event['date2'])) ? '' : $date2 = formatTimestamp($te_event['date2']);

        echo '<tr><td>' . $te_event['id'] . '</td>
<td>' . $date . '</td>
<td>' . $date2 . '</td>
<td>' . $te_event['event'] . "</td>
<td><a href='./index.php?op=edit&id=" . $te_event['id'] . "'>" . _TE_EDIT . "</a></td>
<td><a href='./index.php?op=delconfirm&id=" . $te_event['id'] . "'>" . _TE_DELETE . '</a></td></tr>';
    }

    echo '</table>';

    CloseTable();
}

function te_admin_list()
{
    global $xoopsDB, $xoopsConfig;

    OpenTable();

    echo "<table border=0 cellpadding=2 cellspacing=2 width='100%'><tr><td colspan=8><div align='center'><b>" . _TE_LIST_HEADER . '</b><br><br>' . _TE_MENUE . '</div></td></tr></table>';

    CloseTable();

    OpenTable();

    // Submitted Events

    echo "<table border=0 cellpadding=2 cellspacing=2 width='100%'><tr><td colspan=8><div align='center'>
<b>" . _TE_NEW_HEADER . '</b></div></td></tr>
<tr>
<td><i>' . _TE_ID . '</i></td>
<td><i>' . _TE_DATE . '</i></td>
<td><i>' . _TE_DATE2 . '</i></td>
<td><i>' . _TE_EVENT . '</i></td>
<td><i>' . _TE_SAVE . '</i></td>
<td><i>' . _TE_DELETE . '</i></td>
</tr>';

    // get all rows from db

    $result = $xoopsDB->queryF('SELECT id, date, date2, event FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE pub='0'");

    while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
        $date = formatTimestamp($te_event['date']);

        $date2 = (empty($te_event['date2'])) ? '' : $date2 = formatTimestamp($te_event['date2']);

        echo '<tr><td>' . $te_event['id'] . '</td>
<td>' . $date . '</td>
<td>' . $date2 . '</td>
<td>' . $te_event['event'] . "</td>
<td><a href='./index.php?op=save&id=" . $te_event['id'] . "'>" . _TE_SAVE . "</a></td>
<td><a href='./index.php?op=delconfirm&id=" . $te_event['id'] . "'>" . _TE_DELETE . '</a></td></tr>';
    }

    echo '</table>';

    CloseTable();
}

function te_admin_add()
{
    global $xoopsConfig, $autoday, $automonth, $autohour, $automin, $autoday2, $autohour2, $automin2, $event, $info;

    $arr_date = getdate(time());

    $automonth = $arr_date['mon'];

    $autoyear = $arr_date['year'];

    $arr_date2 = getdate(time());

    $automonth2 = $arr_date2['mon'];

    $autoyear2 = '';

    $repeat = true;

    OpenTable();

    $content = "<form name='Add Content' action='index.php' method='post'><div align='center'>
<h4>" . _TE_ADD_HEADER . "</h4>
</div><table border='0' cellpadding='2' cellspacing='2' width='100%'>";

    include '../include/form.inc.php';

    echo $content;

    echo "<tr height='10'>
<td align='right' height='10'></td>
<td height='10'><input type='hidden' value='add' name='op'></td>
</tr>
<tr>
<td align='right'></td>
<td><input type='submit' name='add' tabindex='5' value='" . _TE_ADD_SUBMIT_ADD . "'> <input type='reset' tabindex='6' value='" . _TE_ADD_SUBMIT_RESET . "'></td>
</tr></table></form>";

    CloseTable();
}

function te_admin_edit($id)
{
    global $xoopsConfig, $xoopsDB;

    $result = $xoopsDB->queryF('SELECT date, date2, event, info FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE id='" . $id . "'");

    $te_event = $xoopsDB->fetchArray($result);

    $arr_date = getdate($te_event['date']);

    $automonth = $arr_date['mon'];

    $autoday = $arr_date['mday'];

    $autoyear = (empty($te_event['date'])) ? '' : $arr_date['year'];

    $autohour = $arr_date['hours'];

    $automin = $arr_date['minutes'];

    $arr_date2 = getdate($te_event['date2']);

    $automonth2 = $arr_date2['mon'];

    $autoday2 = $arr_date2['mday'];

    $autoyear2 = (empty($te_event['date2'])) ? '' : $arr_date['year'];

    $autohour2 = $arr_date2['hours'];

    $automin2 = $arr_date2['minutes'];

    $event = $te_event['event'];

    $info = $te_event['info'];

    $repeat = false;

    OpenTable();

    $content = "<form name='Edit Content' action='index.php' method='post'><div align='center'>
<h4>" . _TE_EDIT_HEADER . "</h4>
</div><table border='0' cellpadding='2' cellspacing='2' width='100%'>
<tr>
<td align='right'>" . _TE_ID . ":</td>
<td><input type='text' value='" . $id . "' name='form_id' size='3' readonly> </td>
</tr>";

    include '../include/form.inc.php';

    echo $content;

    echo "<tr height='10'>
<td align='right' height='10'></td>
<td height='10'><input type='hidden' value='editdb' name='op'></td>
</tr>
<tr>
<td align='right'></td>
<td><input type='submit' name='add' tabindex='7' value='" . _TE_SUBMIT_UPD . "'> <input type='reset' tabindex='8' value='" . _TE_ADD_SUBMIT_RESET . "'></td>
</tr></table></form>";

    CloseTable();
}

function te_admin_save($id)
{
    global $xoopsConfig, $xoopsDB;

    $result = $xoopsDB->queryF('SELECT date, date2, event, info FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE id='" . $id . "'");

    $te_event = $xoopsDB->fetchArray($result);

    $result = $xoopsDB->queryF('SELECT date, date2, event, info FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE id='" . $id . "'");

    $te_event = $xoopsDB->fetchArray($result);

    $arr_date = getdate($te_event['date']);

    $automonth = $arr_date['mon'];

    $autoday = $arr_date['mday'];

    $autoyear = (empty($te_event['date'])) ? '' : $arr_date['year'];

    $autohour = $arr_date['hours'];

    $automin = $arr_date['minutes'];

    $arr_date2 = getdate($te_event['date2']);

    $automonth2 = $arr_date2['mon'];

    $autoday2 = $arr_date2['mday'];

    $autoyear2 = (empty($te_event['date2'])) ? '' : $arr_date['year'];

    $autohour2 = $arr_date2['hours'];

    $automin2 = $arr_date2['minutes'];

    $event = $te_event['event'];

    $info = $te_event['info'];

    $repeat = false;

    OpenTable();

    $content = "<form name='Edit Content' action='index.php' method='post'><div align='center'>
<h4>" . _TE_SAVE_HEADER . "</h4>
</div><table border='0' cellpadding='2' cellspacing='2' width='100%'>
<tr>
<td align='right'>" . _TE_ID . ":</td>
<td><input type='text' value='" . $id . "' name='form_id' size='3' readonly> </td>
</tr>";

    include '../include/form.inc.php';

    echo $content;

    echo "<tr height='10'>
<td align='right' height='10'></td>
<td height='10'><input type='hidden' value='savedb' name='op'></td>
</tr>
<tr>
<td align='right'></td>
<td><input type='submit' name='add' tabindex='5' value='" . _TE_SUBMIT_SAVE . "'> <input type='reset' tabindex='6' value='" . _TE_ADD_SUBMIT_RESET . "'></td>
</tr></table></form>";

    CloseTable();
}

function te_admin_message($message_text, $error_color, $additional_text)
{
    OpenTable();

    if (0 == $error_color) {
        //Good News

        echo '<center><br><h4>' . $message_text . '</h4><br>' . $additional_text . '</center>';
    } else {
        //Bad News

        echo "<center><br><font color='red'><h4>" . $message_text . '</h4><br></font>' . $additional_text . '</center>';
    }

    CloseTable();
}
