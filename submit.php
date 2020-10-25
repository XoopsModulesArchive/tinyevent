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
include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
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
$myts = MyTextSanitizer::getInstance();
global $op;
switch ($op) {
    case 'preview':
        break;
    case 'add':
        $form_event = $myts->addSlashes($form_event);
        $form_info = $myts->addSlashes($form_info);
        $done = true;
        if (empty($form_repeat)) {
            $eventdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear);

            $eventdate2 = (empty($autoyear2)) ? null : mktime($autohour2, $automin2, 0, $automonth2, $autoday2, $autoyear2);

            $q = 'INSERT INTO ' . $xoopsDB->prefix() . "_tinyevent (date, date2, event, info) VALUES ('" . $eventdate . "', '" . $eventdate2 . "', '" . $form_event . "', '" . $form_info . "')";

            $done = $xoopsDB->queryF($q);
        } else {
            for ($i = 0; $i < $form_repeat; $i++) {
                $eventdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear) + ($i * 86400);

                $eventdate2 = (empty($autoyear2)) ? null : mktime($autohour2, $automin2, 0, $automonth2, $autoday2, $autoyear2) + ($i * 86400);

                $q = 'INSERT INTO ' . $xoopsDB->prefix() . "_tinyevent (date, date2, event, info) VALUES ('" . $eventdate . "', '" . $eventdate2 . "', '" . $form_event . "', '" . $form_info . "')";

                $done = ($done && $xoopsDB->queryF($q));
            }
        }
        if ($done) {
            te_submit_message(_TE_EDIT_DONE, 0, '');
        } else {
            te_submit_message(_TE_EDIT_DBERROR, 1, '');
        }
        //te_submit_event();
        break;
    default:
        te_submit_event();
        break;
}
require XOOPS_ROOT_PATH . '/footer.php';
/************************************************************/
/* Functions  */
/************************************************************/
function te_submit_event()
{
    global $xoopsConfig, $autoday, $automonth, $autohour, $automin, $autoday2, $autohour2, $automin2, $event, $info;

    $arr_date = getdate(time());

    $automonth = $arr_date['mon'];

    $autoyear = $arr_date['year'];

    $arr_date2 = getdate(time());

    $automonth2 = $arr_date2['mon'];

    $autoyear2 = '';

    $repeat = true;

    $content = "<table border='0' cellpadding='0' cellspacing='1' width='100%' class='outer'>";

    $content .= "<form name='Add Content' action='submit.php' method='post'>";

    $content .= "<th colspan='4'>" . _TE_ADD_HEADER . '</th>';

    include 'include/form.inc.php';

    $content .= "<tr>
<td align='right' class='even'><input type='hidden' value='add' name='op'></td>
<td class='odd'><input type='submit' name='add' tabindex='5' value='" . _TE_ADD_SUBMIT_ADD . "'> <input type='reset' tabindex='6' value='" . _TE_ADD_SUBMIT_RESET . "'></td>
</tr></form></table>";

    echo $content;
}

function te_submit_message($message_text, $error_color, $additional_text)
{
    if (0 == $error_color) {
        //Good News

        echo '<center><br><h4>' . $message_text . '</h4><br>' . $additional_text . '</center>';
    } else {
        //Bad News

        echo "<center><br><font color='red'><h4>" . $message_text . '</h4><br></font>' . $additional_text . '</center>';
    }
}
