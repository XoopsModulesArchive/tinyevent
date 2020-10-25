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
$modversion['name'] = _TE_MOD_NAME;
$modversion['version'] = '1.01';
$modversion['description'] = _TE_MOD_DESC;
$modversion['credits'] = 'New Versions can be found at http://www.myxoopscube.org';
$modversion['author'] = 'Tobias Liegl';
$modversion['help'] = '';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 1;
$modversion['image'] = 'images/te_slogo.png';
$modversion['dirname'] = 'tinyevent';
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_TE_SMNAME1;
$modversion['sub'][1]['url'] = 'submit.php';
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'tinyevent';
// Templates
//$modversion['templates'][1]['file'] = 'tinyevent_index.html';
//$modversion['templates'][1]['description'] = 'TinyEvent main Screen';
// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';
// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'event_search';
// Blocks
$modversion['blocks'][1]['file'] = 'te_nextevents.php';
$modversion['blocks'][1]['name'] = _MI_TE_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows next events';
$modversion['blocks'][1]['show_func'] = 'tiny_nextn';
$modversion['blocks'][1]['edit_func'] = 'numEvents_edit';
$modversion['blocks'][1]['options'] = '1';
$modversion['blocks'][1]['template'] = 'tinyevent_block_next.html';
$modversion['config'][1]['name'] = 'numevents';
$modversion['config'][1]['title'] = '_MI_TE_NUMEVENTS';
$modversion['config'][1]['description'] = '_MI_TE_NUMEVENTSDSC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 2;
