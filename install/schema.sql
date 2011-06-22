
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `region_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `ip_start` int(10) NOT NULL default '0',
  `ip_end` int(10) NOT NULL default '0',
  `info` text,
  PRIMARY KEY  (`id`),
  KEY `region_id` (`region_id`),
  KEY `name` (`name`),
  KEY `ip_start` (`ip_start`),
  KEY `ip_end` (`ip_end`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dns_nameservers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `node_id` int(10) unsigned NOT NULL default '0',
  `name` enum('ns0','ns1','ns2','ns3') NOT NULL default 'ns0',
  `ip` int(10) NOT NULL default '0',
  `status` enum('waiting','active','pending','rejected','invalid') NOT NULL default 'waiting',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`name`,`node_id`),
  KEY `date_in` (`date_in`),
  KEY `node_id` (`node_id`),
  KEY `ip` (`ip`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dns_zones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` enum('forward','reverse') NOT NULL default 'forward',
  `name` varchar(30) NOT NULL default '',
  `node_id` int(10) unsigned default '0',
  `status` enum('waiting','active','pending','rejected','invalid') NOT NULL default 'waiting',
  `info` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`name`,`type`),
  KEY `type` (`type`),
  KEY `date_in` (`date_in`),
  KEY `node_id` (`node_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dns_zones_nameservers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `zone_id` int(10) unsigned NOT NULL default '0',
  `nameserver_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`zone_id`,`nameserver_id`),
  KEY `nameserver_id` (`nameserver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ip_addresses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `hostname` varchar(50) NOT NULL default '',
  `ip` int(10) NOT NULL default '0',
  `mac` varchar(17) default NULL,
  `node_id` int(10) unsigned NOT NULL default '0',
  `type` enum('router','server','pc','wireless-bridge','voip','camera','other') NOT NULL default 'pc',
  `always_on` enum('Y','N') NOT NULL default 'N',
  `info` text,
  PRIMARY KEY  (`id`),
  KEY `ip` (`ip`),
  KEY `node_id` (`node_id`),
  KEY `hostname` (`hostname`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ip_ranges` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `node_id` int(10) unsigned NOT NULL default '0',
  `ip_start` int(10) NOT NULL default '0',
  `ip_end` int(10) NOT NULL default '0',
  `status` enum('waiting','active','pending','rejected','invalid') NOT NULL default 'waiting',
  `info` text,
  `delete_req` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`node_id`,`ip_start`,`ip_end`),
  KEY `date_in` (`date_in`),
  KEY `ip_start` (`ip_start`),
  KEY `ip_end` (`ip_end`),
  KEY `status` (`status`),
  KEY `delete_req` (`delete_req`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `node_id` int(10) unsigned NOT NULL default '0',
  `peer_node_id` int(10) unsigned default NULL,
  `peer_ap_id` int(10) unsigned default NULL,
  `type` enum('p2p','ap','client') NOT NULL default 'p2p',
  `ssid` varchar(50) default NULL,
  `protocol` enum('IEEE 802.11b','IEEE 802.11g','IEEE 802.11a','IEEE 802.11n','IEEE 802.3i (Ethernet)','IEEE 802.3u (Fast Ethernet)','IEEE 802.3ab (Gigabit Ethernet)','other') default NULL,
  `channel` varchar(50) default NULL,
  `status` enum('active','inactive') NOT NULL default 'active',
  `equipment` text,
  `info` text,
  PRIMARY KEY  (`id`),
  KEY `node_id` (`node_id`,`type`,`status`),
  KEY `peer_node_id` (`peer_node_id`,`type`,`status`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `peer_ap_id` (`peer_ap_id`,`type`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(50) NOT NULL default '',
  `name_ns` varchar(50) NOT NULL default '',
  `area_id` int(10) unsigned default '0',
  `latitude` float default NULL,
  `longitude` float default NULL,
  `elevation` int(10) unsigned default NULL,
  `info` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`name_ns`),
  KEY `date_in` (`date_in`),
  KEY `name` (`name`),
  KEY `area_id` (`area_id`),
  KEY `latitude` (`latitude`),
  KEY `longitude` (`longitude`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;

CREATE TABLE IF NOT EXISTS `nodes_services` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `node_id` int(10) unsigned NOT NULL default '0',
  `service_id` int(10) unsigned NOT NULL default '0',
  `ip_id` int(10) unsigned default '0',
  `url` varchar(255) default NULL,
  `info` text,
  `status` enum('active','inactive') NOT NULL default 'active',
  `protocol` enum('tcp','udp') default NULL,
  `port` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `date_in` (`date_in`),
  KEY `node_id` (`node_id`),
  KEY `service_id` (`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `node_id` int(10) unsigned NOT NULL default '0',
  `type` enum('galery','view') NOT NULL default 'galery',
  `view_point` enum('N','NE','E','SE','S','SW','W','NW','PANORAMIC') default NULL,
  `info` text,
  PRIMARY KEY  (`id`),
  KEY `date_in` (`date_in`),
  KEY `node_id` (`node_id`),
  KEY `type` (`type`),
  KEY `view_point` (`view_point`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  `ip_start` int(10) NOT NULL default '0',
  `ip_end` int(10) NOT NULL default '0',
  `info` text,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `ip_start` (`ip_start`),
  KEY `ip_end` (`ip_end`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `type` enum('blocked','admin','hostmaster') NOT NULL default 'blocked',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`type`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `protocol` enum('tcp','udp') default NULL,
  `port` int(10) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `subnets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `node_id` int(10) unsigned default NULL,
  `ip_start` int(10) NOT NULL default '0',
  `ip_end` int(10) NOT NULL default '0',
  `type` enum('local','link','client') NOT NULL default 'local',
  `link_id` int(10) unsigned default NULL,
  `client_node_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `node_id` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `username` varchar(30) NOT NULL default '',
  `password` varchar(40) default NULL,
  `surname` varchar(30) default NULL,
  `name` varchar(30) default NULL,
  `phone` varchar(60) default NULL,
  `email` varchar(50) NOT NULL default '',
  `info` text,
  `last_session` datetime default NULL,
  `last_visit` datetime default NULL,
  `status` enum('activated','pending') NOT NULL default 'pending',
  `account_code` varchar(20) default NULL,
  `language` varchar(30) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `date_in` (`date_in`),
  KEY `password` (`password`),
  KEY `surname` (`surname`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_nodes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `node_id` int(10) unsigned NOT NULL default '0',
  `owner` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_keys` (`node_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
