<?php

if (isset($argv[1])) {
	$conf_file = basename($argv[1]).'.conf';
} else {
	$conf_file = basename($_GET['zonefile']).'.conf';
}

if ( file_exists($conf_file) ) {
	include $conf_file;
} else {
	exit;
}
if (!isset($conf)) exit;

$mysql_link = mysql_connect($conf['db']['server'], $conf['db']['username'], $conf['db']['password']);

mysql_select_db($conf['db']['database'], $mysql_link);

function replace($array, $string) {
	$ret = $string;
	foreach ($array as $key => $value) {
		$ret = str_replace("##".$key."##", $value, $ret);
	}
	return $ret;
}

if ($conf['zone_type'] == 'forward') {
	
	$replace = array('NAMESERVERS' => '', 'ZONES' => '', 'NS-SUBDOMAIN' => '', 'SERIAL' => '');
	
	## NAMESERVERS
	$query = "SELECT dns_nameservers.name AS ns_num, dns_nameservers.ip AS ns_ip, nodes.name_ns AS name_ns
			  FROM dns_nameservers
			  INNER JOIN nodes ON nodes.id = dns_nameservers.node_id
			  WHERE dns_nameservers.status = 'active'
			  ORDER BY nodes.name_ns ASC, dns_nameservers.name ASC";
	$q = mysql_query($query, $mysql_link);
	while ($ret = mysql_fetch_assoc($q)) {
		$replace['NAMESERVERS'] .= $conf['notify']?
			long2ip($ret['ns_ip']).";\n":
			" NS ".$ret['ns_num'].".".$ret['name_ns'].$conf['ns_domain']."\n";
	}
	
	## ZONES
	$query = "SELECT dns_zones.name AS zone_name, dns_nameservers.name AS ns_num, nodes.name_ns AS name_ns
			  FROM dns_zones
			  INNER JOIN dns_zones_nameservers ON dns_zones.id = dns_zones_nameservers.zone_id
			  INNER JOIN dns_nameservers ON dns_zones_nameservers.nameserver_id = dns_nameservers.id
			  INNER JOIN nodes ON dns_nameservers.node_id = nodes.id
			  WHERE dns_nameservers.status = 'active' AND dns_zones.type = 'forward' AND dns_zones.status = 'active'
			  ORDER BY dns_zones.name ASC, dns_zones_nameservers.id ASC";
	$q = mysql_query($query, $mysql_link);
	echo mysql_error();
	while ($ret = mysql_fetch_assoc($q)) {
		$replace['ZONES'] .= $ret['zone_name']." NS ".$ret['ns_num'].".".$ret['name_ns'].$conf['ns_domain']."\n";
	}

	## NS-SUBDOMAIN
	$query = "SELECT dns_nameservers.ip AS ip, dns_nameservers.name AS ns_num, nodes.name_ns AS name_ns
			  FROM dns_nameservers
			  INNER JOIN nodes ON nodes.id = dns_nameservers.node_id
			  WHERE dns_nameservers.status = 'active'
			  ORDER BY nodes.name_ns ASC, dns_nameservers.name ASC";
	$q = mysql_query($query, $mysql_link);
	while ($ret = mysql_fetch_assoc($q)) {
		$replace['NS-SUBDOMAIN'] .= $ret['ns_num'].".".$ret['name_ns'].$conf['ns_domain']." A ".long2ip($ret['ip'])."\n";
		if ($ret['ns_num'] == 'ns0') {
			$replace['NS-SUBDOMAIN'] .= $ret['name_ns'].$conf['ns_domain']." CNAME ".$ret['ns_num'].".".$ret['name_ns'].$conf['ns_domain']."\n";	
		}
	}
	
	
} elseif ($conf['zone_type'] == 'reverse') {
	
	$replace = array('NAMESERVERS' => '', 'ZONES' => '', 'SERIAL' => '');

	## NAMESERVERS
	$query = "SELECT dns_nameservers.name AS ns_num, nodes.name_ns AS name_ns
			  FROM dns_nameservers
			  INNER JOIN nodes ON nodes.id = dns_nameservers.node_id
			  WHERE dns_nameservers.status = 'active'
			  ORDER BY nodes.name_ns ASC, dns_nameservers.name ASC";
	$q = mysql_query($query, $mysql_link);
	while ($ret = mysql_fetch_assoc($q)) {
		$replace['NAMESERVERS'] .= " NS ".$ret['ns_num'].".".$ret['name_ns'].$conf['ns_domain']."\n";
	}

	## ZONES
	$query = "SELECT dns_zones.name AS zone_name, dns_nameservers.name AS ns_num, nodes.name_ns AS name_ns
			  FROM dns_zones
			  INNER JOIN dns_zones_nameservers ON dns_zones.id = dns_zones_nameservers.zone_id
			  INNER JOIN dns_nameservers ON dns_zones_nameservers.nameserver_id = dns_nameservers.id
			  INNER JOIN nodes ON dns_nameservers.node_id = nodes.id
			  WHERE dns_nameservers.status = 'active' AND dns_zones.type = 'reverse' AND dns_zones.status = 'active'
			  ORDER BY dns_zones.name ASC, dns_zones_nameservers.id ASC";
	$q = mysql_query($query, $mysql_link);
	echo mysql_error();
	while ($ret = mysql_fetch_assoc($q)) {
		$replace['ZONES'] .= $ret['zone_name'].". NS ".$ret['ns_num'].".".$ret['name_ns'].$conf['ns_domain']."\n";
	}

}

## ECHO ZONE
echo replace($replace, file_get_contents($conf['shema']));

mysql_close($mysql_link);

?>
