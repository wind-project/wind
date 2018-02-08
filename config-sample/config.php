<?php

$config = array(
	
	'db' => array(
		'server' => "server.example.org",
		'username' => "youruser",
		'password' => "yourpassword",
		'database' => "yourdatabase",
		'version' => 5.0		//Ex. 4.0, 4.1, 5
		),
		
	'site' => array(
		'domain' => 'server.example.org',
		'url' => 'http://server.example.org/'
		),
	'community' => array(
		'name' => 'Anonymous Wireless Community',
		'short_name' => 'AWC'
	),
	'cookies' => array(
		'expire' => (60 * 60 * 24 * 30)
		),

	'message' => array(
		'delay' => 5
		),

	'templates' => array(
		'path' => ROOT_PATH.'templates/',
		'compiled_path' => ROOT_PATH.'templates/_compiled/',
		'default' => 'basic'
		),
		
	'language' => array(
		'default' => 'greek',
		'enabled' => array(
			'greek' => TRUE,
			'english' => TRUE,
			'dutch' => TRUE)
		),
		
	'smarty' => array(
		'class' => '/usr/share/php/smarty/libs/Smarty.class.php'
		),
		
	'constructor' => array(
		'max_rows' => 50
		),
	
	'dns' => array(
                'root_zone' => 'yourdomain',
                'ns_zone' => 'ns.yourdomain',
                'reverse_zone' => 'in-addr.arpa',
                'reverse_zone_v6' => 'ip6.arpa',
                'forward_zone_schema' => ROOT_PATH.'./tools/dnszones-poller/yourdomain.schema',
                'reverse_zone_schema' => ROOT_PATH.'./tools/dnszones-poller/10.in-addr.arpa.schema',
                'reverse_zone_schema_v6' => ROOT_PATH.'./tools/dnszones-poller/ip6.arpa.schema',
		),

    	'ipv6_ula' => array( // IPv6 ULA network for auto IPv4 to IPv6 /32 network conversion
                'enabled' => FALSE,
		'v6net' => 'fdd4:9370:',
		),
    
	'folders' => array(
		'photos' => ROOT_PATH.'files/photos/'
		),
	
	'mail' => array(
		'smtp' => '', // if not set default used from php.ini file
		'smtp_port' => '25',
		'from' => 'hostmaster@server.example.org',
		'from_name' => 'WiND Hostmaster'
		),
	
	'srtm' => array(
		'path' => ROOT_PATH.'files/srtm/'
		),
		
	'map' => array(
		'server' => 'maps.google.com',
		'maps_available' => array(
                        'satellite' => true,
                        'normal' => true,
                        'hybrid' => true,
						'physical' => true,

						//Sample scripts for custom image map server can be found in the tools subdirectory
                        /*'custom_maps' => array(
                              0 => array(
                                      'url' => 'http://server.example.org/maps/index.php?', 
                                      'name' => 'Custom1',
                                      'coordinates_type' => 'map'
                                      ),
                                1 => array(
                                        'url' => 'http://server.example.org/maps/index.php?',
                                        'name' => 'Custom2',
                                        'coordinates_type' => 'satellite'
                                        ),
                                ),*/
                        
                        'default' => 'hybrid'
                        ),
		'bounds' => array(
			'min_latitude' => 35, // MINLAT_GPS_COORDINATE,
			'min_longitude' => 17, // MINLON_GPS_COORDINATE,
			'max_latitude' => 42, // MAXLAT_GPS_COORDINATE,
			'max_longitude' => 27 // MAXLON_GPS_COORDINATE
			)
		),
	
	'debug' => array(
		'enabled' => FALSE
		)
);
