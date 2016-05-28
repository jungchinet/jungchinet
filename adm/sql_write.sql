## MySQL dump 10.11
##
## Host: localhost    Database: gnuboard4
## ######################################################
## Server version	5.0.37-log

##
## Table structure for table `__TABLE_NAME__`
##

CREATE TABLE `__TABLE_NAME__` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL default '0',
  `wr_reply` varchar(10) NOT NULL default '',
  `wr_parent` int(11) NOT NULL default '0',
  `wr_is_comment` tinyint(4) NOT NULL default '0',
  `wr_comment` int(11) NOT NULL default '0',
  `wr_comment_reply` varchar(5) NOT NULL default '',
  `ca_name` varchar(255) NOT NULL default '',
  `wr_option` set('html1','html2','secret','mail') NOT NULL default '',
  `wr_subject` varchar(255) NOT NULL default '',
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL default '0',
  `wr_link2_hit` int(11) NOT NULL default '0',
  `wr_hit` int(11) NOT NULL default '0',
  `wr_good` int(11) NOT NULL default '0',
  `wr_nogood` int(11) NOT NULL default '0',
  `mb_id` varchar(255) NOT NULL default '',
  `wr_password` varchar(255) NOT NULL default '',
  `wr_name` varchar(255) NOT NULL default '',
  `wr_email` varchar(255) NOT NULL default '',
  `wr_homepage` varchar(255) NOT NULL default '',
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_singo` tinyint(4) NOT NULL default '0',
  `wr_last` varchar(19) NOT NULL default '',
  `wr_ip` varchar(255) NOT NULL default '',
  `wr_1` varchar(255) NOT NULL default '',
  `wr_2` varchar(255) NOT NULL default '',
  `wr_3` varchar(255) NOT NULL default '',
  `wr_4` varchar(255) NOT NULL default '',
  `wr_5` varchar(255) NOT NULL default '',
  `wr_6` varchar(255) NOT NULL default '',
  `wr_7` varchar(255) NOT NULL default '',
  `wr_8` varchar(255) NOT NULL default '',
  `wr_9` varchar(255) NOT NULL default '',
  `wr_10` varchar(255) NOT NULL default '',
  `wr_file_count` TINYINT(4) UNSIGNED NOT NULL default '0',
  `wr_ccl` varchar(12) NOT NULL default '',
  `wr_related` varchar(255) NOT NULL default '',
  `wr_imagesize` int(11) NOT NULL default '0',
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`),
  KEY `list_index` (`wr_is_comment`,`wr_num` ,`wr_reply`),
  KEY `comment_index` (`wr_is_comment`,`wr_parent`,`wr_comment`,`wr_comment_reply`),
  KEY `mb_id` (`mb_id`),
  KEY `ca_name` (`ca_name`),
  KEY `write_idx` (`wr_parent`,`mb_id`,`wr_is_comment`)
);

## Dump completed on 2007-12-04  6:29:36
