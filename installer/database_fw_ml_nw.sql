CREATE TABLE IF NOT EXISTS `PFW_config` (
  `name` varchar(200) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `PFW_config` (`name`, `value`) VALUES
('style', 'style.gvisions.bootstrap_blue'),
('debug', 'false'),
('user_group', '1'),
('moderator_group', '2'),
('admin_group', '3'),
('banned_group', '4'),
('sitetitle', 'gVisions'),
('site_online', 'true'),
('site_offline_reason', 'Entwicklermodus'),
('firstApp', 'com.gvisions.moonlight'),
('menuLoginUser', '5'),
('menuLogoutUser', '6');

CREATE TABLE IF NOT EXISTS `PFW_gmoonpages` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `titel` varchar(200) NOT NULL DEFAULT '',
  `delete` varchar(200) NOT NULL DEFAULT 'true',
  `text` longtext NOT NULL,
  `menu` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

INSERT INTO `PFW_gmoonpages` (`id`, `titel`, `delete`, `text`, `menu`) VALUES
(1, 'Startseite', 'true', '<h1>Willkommen auf deiner neuen Seite.</h1><br><a href="core/cp/index.php">Hier kommst du in dsa gCP</a>', '1');


CREATE TABLE IF NOT EXISTS `PFW_groups` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;




INSERT INTO `PFW_groups` (`id`, `name`, `desc`) VALUES
(4, 'Gesperrte Nutzer', 'Standardgruppe.'),
(1, 'Benutzer', 'Standardgruppe'),
(2, 'Moderatoren', 'Standardgruppe.'),
(3, 'Administratoren', 'Standardgruppe.');

CREATE TABLE IF NOT EXISTS `PFW_group_right` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `group` int(200) NOT NULL,
  `right` int(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

INSERT INTO `PFW_group_right` (`id`, `group`, `right`) VALUES
(8, 3, 1),
(7, 3, 2),
(6, 3, 3);

CREATE TABLE IF NOT EXISTS `PFW_hooks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `code` text NOT NULL,
  `regex` int(1) NOT NULL DEFAULT '1',
  `pattern` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;


INSERT INTO `PFW_hooks` (`id`, `name`, `code`, `regex`, `pattern`) VALUES
(2, 'banner', '', 0, ''),
(3, 'header', '<!--\r\nDiese Website wird mit dem gFramework betrieben. www.gvisions.de\r\n(c) 2008 - 2013\r\n\r\nThis website based on gFramework.\r\nwww.gvisions.de \r\n(c) 2008 - 2013\r\n-->\r\n', 0, ''),
(4, 'imprint', '', 0, '');

CREATE TABLE IF NOT EXISTS `PFW_menuentries` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `parent` int(99) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `link` text NOT NULL,
  `menu` int(200) NOT NULL DEFAULT '0',
  `reihe` varchar(10) NOT NULL DEFAULT '',
  `app` int(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

INSERT INTO `PFW_menuentries` (`id`, `parent`, `name`, `link`, `menu`, `reihe`, `app`) VALUES
(61, 0, 'Startseite', 'pageid=1', 1, '0', 41);

CREATE TABLE IF NOT EXISTS `PFW_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `PFW_menus` (`id`, `name`) VALUES
(1, 'Hauptmenu'),
(2, 'Usermenu'),
(3, 'Administration'),
(5, 'Eingeloggte Nutzer'),
(6, 'Uneingeloggter Nutzer');

CREATE TABLE IF NOT EXISTS `PFW_plugins` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `activate` varchar(200) NOT NULL DEFAULT 'true',
  `desc` text NOT NULL,
  `com_id` varchar(200) NOT NULL,
  `version` varchar(20) NOT NULL,
  `path` varchar(200) NOT NULL COMMENT 'von root an zB root./apps/.../',
  `updateServer` varchar(9999) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

INSERT INTO `PFW_plugins` (`id`, `name`, `activate`, `desc`, `com_id`, `version`, `path`, `updateServer`) VALUES
(1, 'gFramework', 'true', 'gFramework. Grundcore des Systems.', 'com.gvisions.framework', '0.3.1', '/www/htdocs/w0098483/gvisions/gFramework/apps/com.gvisions.framework/', '1'),
(41, 'gMoon!ight', 'true', 'Content Management System', 'com.gvisions.moonlight', '0.3', '/www/htdocs/w0098483/gvisions/gFramework//apps/com.gvisions.moonlight', '1');

CREATE TABLE IF NOT EXISTS `PFW_plugin_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(20) NOT NULL,
  `linkname` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `appname` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `PFW_plugin_links` (`id`, `appid`, `linkname`, `link`, `appname`) VALUES
(1, 1, 'Login', 'login', 'gFramework'),
(2, 1, 'Registration', 'regist', 'gFramework');

CREATE TABLE IF NOT EXISTS `PFW_rights` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `name` varchar(200) NOT NULL,
  `group` varchar(200) NOT NULL COMMENT 'Gruppiert Rechte, zB Allgemein, News, Forum',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `PFW_rights` (`id`, `value`, `desc`, `name`, `group`) VALUES
(1, 'acp', 'Berechtigt Nutzer zum prinzipellen einloggen ins gCP. Ohne dieses Recht kann der Nutzer keine gCP Seite aufrufen.', 'gCP', 'gCP'),
(2, 'install', 'Berechtigt den Nutzer neue Plugins zu installieren und Updates durchzuführen für alle Plugins und das gFramework.<br>Erfodert das Recht: gCP', 'Installation/Update', 'gCP'),
(3, 'system', 'Berechtigt den Nutzer Systemeinstellungen im gCP vorzunehmen.<br>Erfodert das Recht: gCP', 'System/Verwaltung', 'gCP');

CREATE TABLE IF NOT EXISTS `PFW_styles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `path` varchar(500) NOT NULL,
  `downloadfile` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `author` varchar(200) NOT NULL,
  `version` varchar(200) NOT NULL,
  `desc` text NOT NULL,
  `com_id` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

INSERT INTO `PFW_styles` (`id`, `path`, `downloadfile`, `name`, `author`, `version`, `desc`, `com_id`) VALUES
(26, '', '', 'gVisions Bootstrap', 'gVisions', '1.0', '', 'style.gvisions.bootstrap_blue');

CREATE TABLE IF NOT EXISTS `PFW_updateserver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `PFW_updateserver` (`id`, `url`, `name`) VALUES
(1, 'http://update.gvisions.de/', 'gVisions Server');

CREATE TABLE IF NOT EXISTS `PFW_user` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `mail` varchar(200) NOT NULL DEFAULT '',
  `group` varchar(200) NOT NULL DEFAULT '',
  `avatar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;


