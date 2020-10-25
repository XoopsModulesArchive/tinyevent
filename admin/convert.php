<?php

require_once 'admin_header.php';
$result = $xoopsDB->queryF('SELECT id, date, date2, event FROM ' . $xoopsDB->prefix() . '_tinyevent LIMIT 0,1');
while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
    if (!mb_strpos($te_event['date'], '-')) {
        echo "<b>Table '" . $xoopsDB->prefix() . "_tinyevent' is already converted!</b>";

        exit;
    }
}
$result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix() . '_tinyevent ADD date_ INT(10) DEFAULT 0 NOT NULL AFTER date2, ADD date2_ INT(10) AFTER date_');
$result = $xoopsDB->queryF('SELECT id, date, date2, event FROM ' . $xoopsDB->prefix() . '_tinyevent');
while (false !== ($te_event = $xoopsDB->fetchArray($result))) {
    $timestamp = mktime(0, 0, 0, mb_substr($te_event['date'], 5, 2), mb_substr($te_event['date'], 8, 2), mb_substr($te_event['date'], 0, 4));

    $result2 = $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix() . '_tinyevent SET date_ = ' . $timestamp);

    echo '<b>Converted:</b> ' . formatTimestamp($timestamp) . ' - ' . $te_event['event'];
}
$result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix() . '_tinyevent DROP date, DROP date2');
$result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix() . '_tinyevent CHANGE date_ date INT(10) DEFAULT 0 NOT NULL, CHANGE date2_ date2 INT(10)');
