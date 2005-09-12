#
# Table structure for table 'areas'
#

CREATE TABLE areas (
  id int(10) unsigned NOT NULL default '0',
  region_id int(10) unsigned NOT NULL default '0',
  name varchar(40) NOT NULL default '',
  ip_start int(10) unsigned NOT NULL default '0',
  ip_end int(10) unsigned NOT NULL default '0',
  info text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'dns_nameservers'
#

CREATE TABLE dns_nameservers (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  node_id int(10) unsigned NOT NULL default '0',
  name enum('ns0','ns1','ns2','ns3') NOT NULL default 'ns0',
  ip int(10) unsigned NOT NULL default '0',
  status enum('active','pending','rejected','invalid') NOT NULL default 'pending',
  delete_req enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (name,node_id)
) TYPE=MyISAM;



#
# Table structure for table 'dns_zones'
#

CREATE TABLE dns_zones (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  type enum('forward','reverse') NOT NULL default 'forward',
  name varchar(30) NOT NULL default '',
  node_id int(10) unsigned default '0',
  status enum('active','pending','rejected','invalid') NOT NULL default 'pending',
  info text,
  delete_req enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (name,type)
) TYPE=MyISAM;



#
# Table structure for table 'dns_zones_nameservers'
#

CREATE TABLE dns_zones_nameservers (
  id int(10) unsigned NOT NULL auto_increment,
  zone_id int(10) unsigned NOT NULL default '0',
  nameserver_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (zone_id,nameserver_id)
) TYPE=MyISAM;



#
# Table structure for table 'ip_addresses'
#

CREATE TABLE ip_addresses (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  hostname varchar(50) NOT NULL default '',
  ip int(10) unsigned NOT NULL default '0',
  mac varchar(17) default NULL,
  node_id int(10) unsigned NOT NULL default '0',
  type enum('router','server','pc','wireless-bridge','voip','camera','other') NOT NULL default 'pc',
  always_on enum('Y','N') NOT NULL default 'N',
  info text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'ip_ranges'
#

CREATE TABLE ip_ranges (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  node_id int(10) unsigned NOT NULL default '0',
  ip_start int(10) unsigned NOT NULL default '0',
  ip_end int(10) unsigned NOT NULL default '0',
  status enum('active','pending','rejected','invalid') NOT NULL default 'pending',
  info text,
  delete_req enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (node_id,ip_start,ip_end)
) TYPE=MyISAM;



#
# Table structure for table 'links'
#

CREATE TABLE links (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  node_id int(10) unsigned NOT NULL default '0',
  peer_node_id int(10) unsigned default NULL,
  peer_ap_id int(10) unsigned default NULL,
  type enum('p2p','ap','client') NOT NULL default 'p2p',
  ssid varchar(50) default NULL,
  protocol enum('IEEE 802.11b','IEEE 802.11g','IEEE 802.11a','other') default NULL,
  channel varchar(50) default NULL,
  status enum('active','inactive') NOT NULL default 'active',
  equipment text,
  info text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'nodes'
#

CREATE TABLE nodes (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  name varchar(50) NOT NULL default '',
  name_ns varchar(50) NOT NULL default '',
  area_id int(10) unsigned default '0',
  latitude float default NULL,
  longitude float default NULL,
  elevation int(10) unsigned default NULL,
  info text,
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (name_ns)
) TYPE=MyISAM;



#
# Table structure for table 'photos'
#

CREATE TABLE photos (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  node_id int(10) unsigned NOT NULL default '0',
  type enum('galery','view') NOT NULL default 'galery',
  view_point enum('N','NE','E','SE','S','SW','W','NW','PANORAMIC') default NULL,
  info text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'regions'
#

CREATE TABLE regions (
  id int(10) unsigned NOT NULL default '0',
  name varchar(40) NOT NULL default '',
  ip_start int(10) unsigned NOT NULL default '0',
  ip_end int(10) unsigned NOT NULL default '0',
  info text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'rights'
#

CREATE TABLE rights (
  id int(10) unsigned NOT NULL auto_increment,
  user_id int(10) unsigned NOT NULL default '0',
  type enum('blocked','admin','hostmaster') NOT NULL default 'blocked',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (type,user_id)
) TYPE=MyISAM;



#
# Table structure for table 'subnets'
#

CREATE TABLE subnets (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  node_id int(10) unsigned default NULL,
  ip_start int(10) unsigned NOT NULL default '0',
  ip_end int(10) unsigned NOT NULL default '0',
  type enum('local','link','client') NOT NULL default 'local',
  link_id int(10) unsigned default NULL,
  client_node_id int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'users'
#

CREATE TABLE users (
  id int(10) unsigned NOT NULL auto_increment,
  date_in datetime NOT NULL default '0000-00-00 00:00:00',
  username varchar(30) NOT NULL default '',
  password varchar(40) default NULL,
  surname varchar(30) default NULL,
  name varchar(30) default NULL,
  phone varchar(60) default NULL,
  email varchar(50) NOT NULL default '',
  info text,
  last_session datetime default NULL,
  last_visit datetime default NULL,
  status enum('activated','pending') NOT NULL default 'pending',
  account_code varchar(20) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (username),
  UNIQUE KEY unique_keys_2 (email)
) TYPE=MyISAM;



#
# Table structure for table 'users_nodes'
#

CREATE TABLE users_nodes (
  id int(10) unsigned NOT NULL auto_increment,
  user_id int(10) unsigned NOT NULL default '0',
  node_id int(10) unsigned NOT NULL default '0',
  owner enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_keys (node_id,user_id)
) TYPE=MyISAM;

