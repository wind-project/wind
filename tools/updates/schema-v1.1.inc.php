<?php
/*
 * WiND - Wireless Nodes Database
*
* Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as
* published by the Free Software Foundation, either version 3 of the
* License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


$update = new DBUpdateDescriptor(new SchemaVersion(1,0), new SchemaVersion(1,1));

/******************************************
 *            Database Updates            */
$tb = $update->newTable('update_log');
$tb->addColumn('version_major', 'int unsigned', array(
		'not_null' => true,
		'pk' => true));
$tb->addColumn('version_minor', 'int unsigned', array(
		'not_null' => true,
		'pk' => true));
$tb->addColumn('applied_date', 'TIMESTAMP', array(
		'not_null' => true,
		'default' => 'CURRENT_TIMESTAMP'));

/******************************************
 *         IPv6 database changes          */

// TABLE ipv6_node_repos
$tb = $update->newTable('ipv6_node_repos');
$tb->addColumn('id', 'int unsigned', array(
		'not_null' => true,
		'ai' => true,
		'pk' => true));
$tb->addColumn('area_id', 'int unsigned', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));
$tb->addColumn('node_id', 'int unsigned', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));
$tb->addColumn('v6net', 'varbinary(16)', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));

// TABLE ipv6_area_repos
$tb = $update->newTable('ipv6_area_repos');
$tb->addColumn('id', 'int unsigned', array(
		'not_null' => true,
		'ai' => true,
		'pk' => true));
$tb->addColumn('area_id', 'int unsigned', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));
$tb->addColumn('region_id', 'int unsigned', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));
$tb->addColumn('v6net', 'varbinary(16)', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));

// TABLE ip_ranges_v6
$tb = $update->newTable('ip_ranges_v6');
$tb->addColumn('id', 'int unsigned', array(
		'not_null' => true,
		'ai' => true,
		'pk' => true));
$tb->addColumn('date_in', 'datetime', array(
		'not_null' => true,
		'default' => "'0000-00-00 00:00:00'"));
$tb->addColumn('node_id', 'int unsigned', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));
$tb->addColumn('v6net_id', 'int', array(
		'not_null' => true,
		'default' => '0',
		'unique' => true));
$tb->addColumn('status', "enum('waiting','active','pending','rejected','invalid')", array(
		'not_null' => true,
		'default' => "'waiting'"));
$tb->addColumn('info', 'text');
$tb->addColumn('delete_req', "enum('Y','N')", array(
		'not_null' => true,
		'default' => "'N'"));

// Table nodesettingschanges
$tb = $update->newTable('nodesettingschanges');
$tb->addColumn('id', 'int unsigned', array(
		'not_null' => true,
		'ai' => true,
		'pk' => true));
$tb->addColumn('node_id', 'int unsigned', array(
		'not_null' => true,
		'default' => '0',
		'pk' => true));
$tb->addColumn('uid', 'int', array(
		'unique' => true,
		'not_null' => true));
$tb->addColumn('dateline', 'varchar(30)', array(
		'default' => NULL));
$tb->addColumn('changemade', 'text', array(
		'fk' => true,
		'not_null' => true));
$tb->addColumn('changemenu', "enum('routerOS version upgrade/downgrade','groups','users','other','script','ip firewall other','ip firewall nat','ip firewall filter','wireless','snmp','radius','partitions','ipv6','ppp','INTERFACE','driver','led','user','system','special-login','routing','queue','port','mpls','log','ip','file','HARDWARE','certificate')", array(
		'unique' => true,
		'not_null' => true));
$tb->addColumn('reason', "enum('other','bug fix','critical-problem','imporovement','termination')", array(
		'not_null' => true));
$tb->addColumn('comment', 'text');

// MODIFY areas
$update->newColumn('areas', 'v6net', 'varbinary(16)', array(
		'default' => '0',
		'unique' => true));
$update->newColumn('areas', 'v6prefix', 'smallint', array(
		'default' => '0'));

// MODIFY regions
$update->newColumn('regions', 'v6net', 'varbinary(16)', array(
		'default' => '0'));
$update->newColumn('regions', 'v6prefix', 'smallint', array(
		'default' => '0'));

/******************************************
 *         Links Extra Info               */

// MODIFY links
$update->newColumn('links', 'due_date', 'DATETIME', array(
		'default' => "'0000-00-00 00:00:00'"));
$update->newColumn('links', 'frequency', "enum('2412','2417','2422','2427','2432','2437','2442','2447','2452','2457','2462','2467','2472','2484','4915','4920','4925','4935','4940','4945','4960','4980','5035','5040','5045','5055','5060','5080','5170','5180','5190','5200','5210','5220','5230','5240','5260','5280','5300','5320','5500','5520','5540','5560','5580','5600','5620','5640','5660','5680','5700','5745','5765','5785','5805','5825')", array(
		'not_null' => false,
		'default' => "'5500'"));
$update->modifyColumn('links', 'status', "enum('active','inactive','pending')", array(
		'not_null' => false,
		'default' => "'active'"));
$update->modifyColumn('links', 'type', "enum('p2p','ap','client','free')", array(
		'not_null' => false,
		'default' => "'p2p'"));

// MODIFY nodes
$update->newColumn('nodes', 'due_date', 'DATETIME', array(
		'default' => "'0000-00-00 00:00:00'"));
$update->newColumn('nodes', 'last_change', 'DATETIME', array(
		'default' => "'0000-00-00 00:00:00'"));
$update->newColumn('nodes', 'status', "enum('active','inactive','pending','deleted')", array(
		'default' => "'active'"));


return $update;
