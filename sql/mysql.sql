# phpMyAdmin MySQL-Dump
# version 2.2.5
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
# --------------------------------------------------------
#
# Table structure for table `tinyevent`
#
CREATE TABLE tinyevent (
    id    INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    pub   INT(1)          NOT NULL DEFAULT '0',
    cat   INT(5) UNSIGNED NOT NULL DEFAULT '1',
    date  INT(10)         NOT NULL DEFAULT '0',
    date2 INT(10)                  DEFAULT NULL,
    event TEXT            NOT NULL,
    info  TEXT,
    PRIMARY KEY (id)
)
    ENGINE = ISAM;
