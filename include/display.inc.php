<?php

function display_list()
{
    echo (string)$content;

    //themecenterposts($title, $content, FALSE);
}

function display_event($content)
{
    echo (string)$content;

    //themecenterposts($title, $content, FALSE);
}

function display_print_event($title, $content, $id)
{
    global $xoopsConfig, $xoopsModule;

    echo "
<html>\n
<head><title>" . $xoopsConfig['sitename'] . "</title></head>\n
<body bgcolor=FFFFFF text=000000>\n
<table border=0><tr><td>\n
<table border=0 width=640 cellpadding=0 cellspacing=1 bgcolor=000000><tr><td>\n
<table border=0 width=640 cellpadding=20 cellspacing=1 bgcolor=FFFFFF><tr><td>\n
<center>\n
<img src='" . XOOPS_URL . "/images/logo.gif' border='0' alt=''><br><br>\n
<h3>$title</h3><br>\n
</center>\n
" . $content . "\n
<br><br>\n
</td></tr></table>\n
</td></tr></table>\n
<br><br><center>\n";

    printf(_TE_COMESFROM, $xoopsConfig['sitename']);

    echo '
<br><a href=' . XOOPS_URL . '>' . XOOPS_URL . "</a><br><br>\n
" . _TE_URLFORTHIS . "<br>\n
<a href='" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/index.php?op=show&id=$id'>" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/index.php?op=show&id=$id</a>\n
</td></tr></table>\n
</body>\n
</html>";
}

function display_print_list($title, $content)
{
    global $xoopsConfig, $xoopsModule;

    echo "
<html>\n
<head><title>" . $xoopsConfig['sitename'] . "</title></head>\n
<body bgcolor=FFFFFF text=000000>\n
<table border=0><tr><td>\n
<table border=0 width=640 cellpadding=0 cellspacing=1 bgcolor=000000><tr><td>\n
<table border=0 width=640 cellpadding=20 cellspacing=1 bgcolor=FFFFFF><tr><td>\n
<center>\n
<img src='" . XOOPS_URL . "/images/logo.gif' border='0' alt=''><br><br>\n
<h3>$title</h3><br>\n
</center>\n
" . $content . "\n
<br><br>\n
</td></tr></table>\n
</td></tr></table>\n
<br><br><center>\n";

    printf(_TE_COMESFROM, $xoopsConfig['sitename']);

    echo '
<br><a href=' . XOOPS_URL . '>' . XOOPS_URL . "</a><br><br>\n
" . _TE_URLFORTHIS . "<br>\n
<a href='" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/index.php'>" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/index.php</a>\n
</td></tr></table>\n
</body>\n
</html>";
}
