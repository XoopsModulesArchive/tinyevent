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
include 'include/display.inc.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
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
/************************************************************/
/* Functions  */
/************************************************************/
global $op;
switch ($op) {
    case 'print':
        print_event($id);
        break;
    case 'printlist':
        print_list();
        break;
    case 'show':
        require XOOPS_ROOT_PATH . '/header.php';
        show_event($id);
        require XOOPS_ROOT_PATH . '/footer.php';
        break;
    default:
        require XOOPS_ROOT_PATH . '/header.php';
        show_list();
        require XOOPS_ROOT_PATH . '/footer.php';
        break;
}
function show_list()
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $content = "<table border='0' cellpadding='0' cellspacing='1' width='100%' class='outer'>";

    $content .= "<th colspan='4'>" . _TE_TITLE . '</th>';

    $content .= "<tr class='even'><td colspan='2' width='35%'><b>" . _TE_THEDATE . '</b></td><td><b>' . _TE_EVENT . '</b></td><td><b>' . _TE_MORE . '</b></td></tr>';

    //query Database (returns an array)

    $result = $xoopsDB->queryF('SELECT id, date, date2, event, info FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE pub='1' ORDER BY date");

    while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
        $event = htmlspecialchars($te_event['event'], ENT_QUOTES | ENT_HTML5);

        $date2 = (empty($te_event['date2'])) ? '' : $date2 = formatTimestamp($te_event['date2'], 's');

        $content .= "<tr class='odd'><td>" . formatTimestamp($te_event['date'], 's') . '</td>';

        $content .= '<td>' . $date2 . '</td>';

        if ('' != $te_event['info']) {
            $content .= "<td><a href='index.php?op=show&id=" . $te_event['id'] . "'>" . $event . '</a></td>';
        } else {
            $content .= '<td>' . $te_event['event'] . '</td>';
        }

        if ('' != $te_event['info']) {
            $content .= "<td><a href='index.php?op=show&id=" . $te_event['id'] . "'>" . _TE_MORE2 . '</a></td></tr>';
        } else {
            $content .= '<td>&nbsp;</td></tr>';
        }
    }

    $content .= '</table>';

    $content .= "<br><div align='right'><a href='index.php?op=printlist'><img src='" . XOOPS_URL . "/modules/news/images/print.gif' border='0' alt='" . _TE_PRINTERPAGE . "'></a></div>";

    display_event($content);
}

function show_event($id)
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $content = "<table border='0' cellpadding='0' cellspacing='1' width='100%' class='outer'>";

    $content .= "<th colspan='2'>" . _TE_TITLE . '</th>';

    //query Database (returns an array)

    $result = $xoopsDB->queryF('SELECT id, date, date2, event, info FROM ' . $xoopsDB->prefix() . '_tinyevent WHERE id=' . $id . '');

    while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
        $event = htmlspecialchars($te_event['event'], ENT_QUOTES | ENT_HTML5);

        $info = $myts->displayTarea($te_event['info']);

        $content .= "<tr><td class='even'><b>" . _TE_DATE . '</b></td>';

        $content .= "<td class='odd'>" . formatTimestamp($te_event['date']) . '</td></tr>';

        if (!empty($te_event['date2'])) {
            $content .= "<tr><td class='even'><b>" . _TE_DATE2 . '</b></td>';

            $content .= "<td class='odd'>" . formatTimestamp($te_event['date2']) . '</td></tr>';
        }

        $content .= "<tr><td class='even'><b>" . _TE_EVENT . "&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td class='odd'>" . $event . '</td></tr>' . "<tr><td valign='top' class='even'><b>" . _TE_INFO . "</b></td><td width='100%' class='odd'>" . $info . '</td></tr>';
    }

    $content .= "<td colspan='2' class='foot'><a href='index.php'>" . _TE_BACK . '</a></td></table>';

    $content .= "<br><div align='right'><a href='index.php?op=print&id=$id'><img src='" . XOOPS_URL . "/modules/news/images/print.gif' border='0' alt='" . _TE_PRINTERPAGE . "'></a></div>";

    display_event($content);
}

function print_list()
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $title = _TE_TITLE;

    $content = "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";

    //query Database (returns an array)

    $result = $xoopsDB->queryF('SELECT id, date, date2, event, info FROM ' . $xoopsDB->prefix() . "_tinyevent WHERE pub='1' ORDER BY date");

    while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
        $event = htmlspecialchars($te_event['event'], ENT_QUOTES | ENT_HTML5);

        $content .= '<tr><td>' . formatTimestamp($te_event['date'], 's') . '</td>';

        if ('' != $te_event['info']) {
            $content .= "<td><a href='index.php?op=show&id=" . $te_event['id'] . "'>" . $event . '</a></td></tr>';
        } else {
            $content .= '<td>' . $te_event['event'] . '</td></tr>';
        }

        $content .= '<tr><td>&nbsp;</td></tr>';
    }

    $content .= '</table>';

    display_print_list($title, $content);
}

function print_event($id)
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $title = _TE_TITLE;

    $content = "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";

    //query Database (returns an array)

    $result = $xoopsDB->queryF('SELECT id, date, date2, event, info FROM ' . $xoopsDB->prefix() . '_tinyevent WHERE id=' . $id . '');

    while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
        $event = htmlspecialchars($te_event['event'], ENT_QUOTES | ENT_HTML5);

        $info = $myts->displayTarea($te_event['info']);

        $content .= '<tr><td><b>' . _TE_DATE . '</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';

        $content .= '<td>' . formatTimestamp($te_event['date']) . '</td></tr>';

        if (!empty($te_event['date2'])) {
            $content .= '<tr><td><b>' . _TE_DATE2 . '</b></td><td></td>';

            $content .= '<td>' . formatTimestamp($te_event['date2']) . '</td></tr>';
        }

        $content .= '<tr><td>&nbsp;</td></tr><tr><td><b>' . _TE_EVENT . '</b></td><td></td><td>' . $event . '</td></tr>' . "<tr><td>&nbsp;</td></tr><tr><td valign='top'><b>" . _TE_INFO . "</b></td><td></td><td width='100%'>" . $info . '</td></tr>';
    }

    $content .= '</table>';

    display_print_event($title, $content, $id);
}
