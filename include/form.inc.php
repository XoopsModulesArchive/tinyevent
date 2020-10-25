<?php

$content .= "<tr>
<td class='even'>" . _TE_DATE . ":</td>
<td class='odd'>";
$xday = 1;
$content .= _TE_DAYC . " <select name='autoday'>\n";
while ($xday <= 31) {
    if ($xday == $autoday) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xday . "' " . $sel . '>' . $xday . "</option>\n";

    $xday++;
}
$content .= "</select>&nbsp;\n";
$xmonth = 1;
$content .= _TE_MONTHC . " <select name='automonth'>\n";
while ($xmonth <= 12) {
    if ($xmonth == $automonth) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xmonth . "' " . $sel . '>' . $xmonth . "</option>\n";

    $xmonth++;
}
$content .= "</select>&nbsp;\n";
$content .= _TE_YEARC . " <input type='text' name='autoyear' value='";
if (isset($autoyear)) {
    $content .= $autoyear;
}
$content .= "' size='5' maxlength='4'>\n";
$content .= '&nbsp;' . _TE_TIMEC . " <select name='autohour'>\n";
$xhour = 0;
$cero = '0';
while ($xhour <= 23) {
    $dummy = $xhour;

    if ($xhour < 10) {
        $xhour = "$cero$xhour";
    }

    if ($xhour == $autohour) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xhour . "' " . $sel . '>' . $xhour . "</option>\n";

    $xhour = $dummy;

    $xhour++;
}
$content .= "</select>\n";
$content .= " : <select name='automin'>\n";
$xmin = 0;
while ($xmin <= 59) {
    if ((0 == $xmin) or (5 == $xmin)) {
        $xmin = "0$xmin";
    }

    if ($xmin == $automin) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xmin . "' " . $sel . '>' . $xmin . "</option>\n";

    $xmin += 5;
}
$content .= "</select>\n";
$content .= " : 00</td>\n";
$content .= "</tr>
<tr>
<td class='even'>" . _TE_DATE2 . ":</td>
<td class='odd'>";
$xday = 1;
$content .= _TE_DAYC . " <select name='autoday2'>\n";
while ($xday <= 31) {
    if ($xday == $autoday2) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xday . "' " . $sel . '>' . $xday . "</option>\n";

    $xday++;
}
$content .= "</select>&nbsp;\n";
$xmonth = 1;
$content .= _TE_MONTHC . " <select name='automonth2'>\n";
while ($xmonth <= 12) {
    if ($xmonth == $automonth2) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xmonth . "' " . $sel . '>' . $xmonth . "</option>\n";

    $xmonth++;
}
$content .= "</select>&nbsp;\n";
$content .= _TE_YEARC . " <input type='text' name='autoyear2' value='";
if (isset($autoyear2)) {
    $content .= $autoyear2;
}
$content .= "' size='5' maxlength='4'>\n";
$content .= '&nbsp;' . _TE_TIMEC . " <select name='autohour2'>\n";
$xhour = 0;
$cero = '0';
while ($xhour <= 23) {
    $dummy = $xhour;

    if ($xhour < 10) {
        $xhour = "$cero$xhour";
    }

    if ($xhour == $autohour2) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xhour . "' " . $sel . '>' . $xhour . "</option>\n";

    $xhour = $dummy;

    $xhour++;
}
$content .= "</select>\n";
$content .= " : <select name='automin2'>\n";
$xmin = 0;
while ($xmin <= 59) {
    if ((0 == $xmin) or (5 == $xmin)) {
        $xmin = "0$xmin";
    }

    if ($xmin == $automin2) {
        $sel = 'selected';
    } else {
        $sel = '';
    }

    $content .= "<option value='" . $xmin . "' " . $sel . '>' . $xmin . "</option>\n";

    $xmin += 5;
}
$content .= "</select>\n";
$content .= " : 00</td>\n";
$content .= "</tr><tr><td class='even'></td><td class='odd'>" . _TE_DATE_DESC . '</td></tr>';
if ($repeat) {
    $content .= "</tr>
<tr><td class='even'>" . _TE_REPEATINFO . ":</td><td class='odd'>
<input type=input name=form_repeat value='' size='2' maxlength='2'>&nbsp;" . _TE_REPEATINFO2 . '</td></tr>';
}
$content .= "<tr>
<td class='even'>" . _TE_EVENT . ":</td>
<td class='odd'><input type='text' name='form_event' value='$event' size='50' maxlength='200' tabindex='3'></td>
</tr>";
$content .= "<tr>
<td class='even'>" . _TE_INFO . ":</td>
<td class='odd'><textarea name='form_info' size='100' tabindex='4' wrap='virtual' cols='50' rows='10'>$info</textarea>
</td></tr>";
