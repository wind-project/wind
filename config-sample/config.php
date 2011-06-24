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
			'english' => TRUE)
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
		'forward_zone_schema' => ROOT_PATH.'tools/dnszones-poller/yourdomain.schema',
		'reverse_zone_schema' => ROOT_PATH.'tools/dnszones-poller/10.in-addr.arpa.schema'
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
		
	'gmap' => array(
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
		'api' => '3.5',
		'keys' => array( // Domains must be as in $_SERVER['SERVER_NAME'] variable
			// 'server.example.org/path' => 'example_key'
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
