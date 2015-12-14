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

setlocale(LC_ALL, 'en_US.utf8', 'Dutch');

$lang = array(

	'charset' => 'utf-8',
	'iso639' => 'en',
	'mysql_charset' => 'utf8',

	'site_title' => "WiND - Wireless Nodes Database",
	'title_small' => "WiND",	

	'forward_text' => "Klik hier om door te gaan naar de volgende pagina...",
	
	'delete_request' => "Verwijderen aanvragen",
	
	'delete' => "Verwijderen",
	'home' => "Home",
	'edit_profile' => "Gebruikers profiel",
	'edit_node' => "Node wijzigen",
	'logout' => "Uitloggen",
	'login' => "Inloggen",
	'register' => "Registreren",
	'password_recover' => "Wachtwoord opvragen",
	'password_change' => "Wachtwoord wijzigen",
        'node_los_view' => 'Line of Sight (LOS) Gereedschap',
        'node_plot_ap_list' => "Lijst topologie alle AP knooppunten",
        'node_plot_list' => "Lijst topologie alle knooppunten",
	'all_nodes' => "Netwerk nodes",
	'all_zones' => "DNS zones",
	'all_ranges' => "IP adressen",
	'user_info' => "Gebruiker informatie",
	'users_info' => "Gebruikers informatie",
	'username' => "Gebruikersnaam",
	'password' => 'Wachtwoord',
	'registered_since' => "Geregistreerd",
	'name' => "Voornaam",
	'surname' => "Achternaam",
	'last_visit' => "Laatste bezoek",
	'mynodes' => "Mijn nodes",
	'node_add' => "Node toevoegen",
	'admin_panel' => "Administratie",
	'nodes' => "Nodes",
	'users' => "Gebruikers",
	'hostmaster_panel' => "Beheerder",
	'ip_ranges' => "IP C-Classes",
        'ip_ranges_v6' => "IPv6 Networks",
	'dns_zones' => "DNS zones",
	'dns_nameservers' => "Nameservers (NS)",
	'waiting' => "wachtende",
	'for_deletion' => "te verwijderen",
	'welcome' => "Welkom",
	'gearth_download' => "Google Earth bestand downloaden",
	'google_earth' => "Google Earth",
	'nodes_search' => "Zoeken naar nodes",
	'nodes_found' => "Nodes gevonden",
	'users_search' => "Zoeken naar gebruikers",
	'users_found' => "Gebruikers gevonden",
	'dns_zones_search' => "Zoeken naar DNS zones",
	'dns_zones_found' => "DNS zones gevonden",
	'not_found' => "Geen gegevens gevonden",	
	'all_services' => "Netwerk diensten",
	'active_services' => "Actieve diensten",
	'services_search' => "Zoeken naar diensten",
	'services_found' => "Diensten gevonden",
	'services_categories' => "Diensten categorieen",
	'services_categories_add' => "Dienst categorie toevoegen",
	'services_categories_edit' => "Dienst categorie wijzigen",
	'nodesettingschanges_add' => "Add Change Log for this Node",
	'nodesettingschanges' => "ChangeLog",
	'services_edit' => "Dienst bewerken",
	'services_add' => "Dienst toevoegen",
	'services' => "Diensten",
	'user_add' => "Nieuwe gebruiker",
	'user_edit' => "Gebruiker profiel",
	'node' => "Node",
	'node_info' => "Node informatie",
	'node_view' => "Node bekijken",
	'node_delete' => "Node verwijderen",
	'ip_range_request' => "IP C-Class aanvraag",
	'ip_range_request_for_node' => "IP C-Class aanvraag voor node",
        'ip_range_v6_request' => "IPv6 Range Request",
	'ip_range_v6_request_for_node' => "IPv6 Range Request for node",
	'dnszone_request_forward' => "DNS zone aanvraag (forward)",
	'dnszone_request_reverse' => "DNS zone aanvraag (reverse)",
	'dnszone_edit' => "Wijzig DNS zone",
	'nameserver_add' => "Toevoegen nameserver (NS)",
	'nameserver_edit' => "Wijzigen nameserver (NS)",
	'link_edit' => "Wijzigen verbinding",
	'link_add' => "Toevoegen verbinding",
	'links' => "Verbindingen",
	'ap' => "Access Point",
	'aps' => "Access Points",
	'aps_abbr' => "APs",
	'free' => 'Free',
	'aps_search' => "Zoeken naar Access Points",
	'aps_found' => "Access Points gevonden",
	'subnet_edit' => "Subnet wijzigingen",
	'subnet_add' => "Subnet toevoegen",
	'subnets' => "Subnetten",
	'ip_address_edit' => "IP adres wijzigen",
	'ip_address_add' => "IP adres toevoegen",
	'ip_addresses' => "IP adressen",
	'myview' => "Nodes Bekijken",
	'ip_ranges_search' => "IP Netwerk zoeken",
	'ip_ranges_found' => "IP Netwerk gevonden",
	'dns_nameservers_search' => "DNS nameservers zoeken",
	'dns_nameservers_found' => "DNS nameservers gevonden",
	'ip_range_edit' => "IP C-Class wijzigen",
	'send_mail' => "Stuur een bericht",
	'to' => "Naar",
	'subject' => "Onderwerp",
	'body' => "Bericht",
	'mailto_all' => "Beheerder & Co-beheerders",
	'mailto_owner' => "Beheerder",
	'mailto_custom' => "Anders",
	'ip_ranges_allocation' => "Gereserveerde IP reeksen",
	'ip_ranges_search' => "IP Netwerk zoeken",
	'change' => "Wijzigen",
	'submit' => "OK",
	'add' => "Toevoegen",
	'remove' => "Verwijderen",
	'update' => "Updaten",
	'search' => "Zoeken",
	'plot' => "Line of sight (LOS)",
	'mynetwork' => "Node subnetwerk",
	'new_window' => "Nieuw Window",
	'node_plot_link' => "Line of sight (LOS) met andere nodes",
	'nodes_plot_link' => "Line of sight (LOS) van de nodes",
	'nodes_plot_link_info' => "Choose above the nodes for which you want to plot the line of sight (LOS).",
	'distance' => "Distance",
	'azimuth' => "Azimuth",
	'elevation' => "Elevation",
	'fsl' => "Free space loss",
	'tilt' => "Tilt",
	'clients' => "Clients",
	'compare_equal' => "Gelijk aan",
	'compare_greater' => "Groter dan",
	'compare_less' => "Kleiner dan",
	'compare_greater_equal' => "Groter of gelijk aan",
	'compare_less_equal' => "Kleiner of gelijk aan",
	'compare_starts_with' => "Start vanaf",
	'compare_ends_with' => "Eindigd",
	'compare_contains' => "Bevat",
	'zone_forward' => "Forward DNS zone",
	'zone_reverse' => "Reverse DNS zone",
	'contact' => "Bericht",
	'contact_node' => "Bericht node beheerder(s)",
	'from' => "Van",
	'send' => "Verzenden",
	'node_page' => "Node Pagina",
	'yes' => "Ja",
	'no' => "Nee",
	'backbone' => "Backbone",
	'backbones_abbr' => "BBs",
	'unlinked' => "Niet verbonden",
	'find_coordinates' => "Zoek coordinaten",
	'select_the_coordinates' => "Selecteer coordinaten",
	'quick_search' => "Snel zoeken",
	'statistics' => "Statistieken",
	'active_nodes' => "Actieve nodes",
	'backbone_nodes' => "Backbone nodes",
	'null' => "(null)",
	'default' => 'Standaard',
	'logged' => 'Ingelogd als',
	'regions' => 'Regio',
	'region_add' => 'Regio toevoegen',
	'region_edit' => 'Regio bewerken',
	'areas' => 'Gebied',
	'area_add' => 'Gebied toevoegen',
	'area_edit' => 'Gebied bewerken',

	'db' => array(
		'users__username' => 'Gebruikersnaam',
		'users__password' => 'Wachtwoord',
		'users__password_c' => 'Bevestig wachtwoord',
		'users__surname' => 'Achternaam',
		'users__name' => 'Voornaam',
		'users__email' => 'E-mail adres',
		'users__phone' => 'Telefoonnummer',
		'users__info' => 'Informatie',
		'users__status' => 'Registratie',
		'users__status-pending' => 'In afwachting',
		'users__status-activated' => 'Gactiveerd',
		'users__language' => 'Taal',
		'fullname' => 'Volledigenaam',
		
		'nodes__id' => 'Node ID',
		'nodes__name' => 'Node naam',
		'nodes__date_in' => 'Aangemaakt',
                'nodes__due_date' => 'Installation Due Date',
		'nodes__last_change' => 'Last Changed',
		'nodes__area_id' => 'Gebied',
		'nodes__latitude' => 'Geografische breedte',
		'nodes__longitude' => 'Geografisch lengte',
		'nodes__elevation' => 'Gebouw hoogte (m)',
		'nodes__info' => 'Informatie',
                'nodes__status' => 'Status',
		'nodes__status-active' => 'Active',
		'nodes__status-inactive' => 'Inactive',
                'nodes__status-pending' => 'Pending',
                'nodes__status-deleted' => 'Deleted',            
		'nodes__name_ns' => 'Nameserver prefix',
		
		'users_nodes__owner' => 'Privilege',
		'users_nodes__owner-Y' => 'Beheerder',
		'users_nodes__owner-N' => 'Co-Beheerder',
		'users_nodes__user_id' => 'Co-Beheerders',
		'users_nodes__node_id' => 'Node co-beheerder',
		'user_id_owner' => 'Beheerder',
		'node_id_owner' => 'Node Beheerders',

		'areas__id' => 'Gebied',
		'areas__region_id' => 'Omgeving',
		'areas__name' => 'Gebied',
		'areas__ip_start' => 'Start IP',
		'areas__ip_end' => 'Eind IP',
                'areas__v6net' => 'IPv6 Network',
                'areas__v6prefix' => 'IPv6 Prefix',
		'areas__info' => 'Informatie',

		'regions__id' => 'Regio',
		'regions__name' => 'Regio',
		'regions__ip_start' => 'Start IP',
		'regions__ip_end' => 'Eind IP',
                'regions__v6net' => 'IPv6 Network',
                'regions__v6prefix' => 'IPv6 Prefix',
		'regions__info' => 'Informatie',

		'ip_ranges__date_in' => 'Datum',
		'ip_ranges__ip_start' => 'Begin',
		'ip_ranges__ip_end' => 'Eind',
		'ip_ranges__status' => 'Status',
		'ip_ranges__status-waiting' => 'Wacht op controle',
		'ip_ranges__status-pending' => 'In afwachting',
		'ip_ranges__status-active' => 'Actief',
		'ip_ranges__status-rejected' => 'Afgewezen',
		'ip_ranges__status-invalid' => 'Niet juist',
		'ip_ranges__info' => 'Informatie',
		'ip_ranges__delete_req' => 'Verwijder aanvraag',
		'ip_ranges__delete_req-Y' => 'Ja',
		'ip_ranges__delete_req-N' => 'Nee',
		'ip_range' => 'C Class',
		'ip' => 'IP adres',

               'ip_ranges_v6__date_in' => 'Date',
		'ip_ranges_v6__v6net' => 'IPv6 Net',
		'ip_ranges_v6__ip_end' => 'Up to',
		'ip_ranges_v6__status' => 'Status',
		'ip_ranges_v6__status-waiting' => 'Waiting check',
		'ip_ranges_v6__status-pending' => 'Pending',
		'ip_ranges_v6__status-active' => 'Active',
		'ip_ranges_v6__status-rejected' => 'Rejected',
		'ip_ranges_v6__status-invalid' => 'Invalid',
		'ip_ranges_v6__info' => 'IPv6 Info',
		'ip_ranges_v6__delete_req' => 'Delete request',
		'ip_ranges_v6__delete_req-Y' => 'YES',
		'ip_ranges_v6__delete_req-N' => 'NO',
		'ip_range_v6' => 'IPv6 Net',
                'ipv6' => 'IPv6 Net',
                'v6net' => 'IPv6 Net',
            
		'dns_zones__date_in' => 'Datum',
		'dns_zones__name' => 'Zone naam',
		'dns_zones__type' => 'Zone type',
		'dns_zones__type-forward' => 'Forward',
		'dns_zones__type-reverse' => 'Reverse',
		'dns_zones__status' => 'Status',
		'dns_zones__status-waiting' => 'Wacht op controle',
		'dns_zones__status-pending' => 'In afwachting',
		'dns_zones__status-active' => 'Actief',
		'dns_zones__status-rejected' => 'Afgewezen',
		'dns_zones__status-invalid' => 'Niet juist',
		'dns_zones__info' => 'Informatie',

		'schema' => "Schema",

		'dns_zones_nameservers__nameserver_id' => 'Responsible Nameservers (NS)',

		'dns_nameservers__date_in' => 'Datum',
		'dns_nameservers__name' => 'Nameserver naam',
		'dns_nameservers__ip' => 'IP adres',
		'dns_nameservers__status' => 'Status',
		'dns_nameservers__status-waiting' => 'Wacht op controle',
		'dns_nameservers__status-pending' => 'In afwachting',
		'dns_nameservers__status-active' => 'Actief',
		'dns_nameservers__status-rejected' => 'Afgewezen',
		'dns_nameservers__status-invalid' => 'Niet juist',

		'links__date_in' => 'Aangemaakt',
                'links__due_date' => 'Due Date',
		'links__peer_node_id' => 'Peer node',
		'links__peer_ap_id' => 'Access point',
		'links__type' => 'Verbinding type',
		'links__type-p2p' => 'Backbone',
		'links__type-ap' => 'Access Point',
		'links__type-client' => 'Client',
		'links__type-free' => 'Free',
		'links__ssid' => 'SSID',
		'links__protocol' => 'Protocol',
		'links__protocol-other' => 'Anders',
		'links__channel' => 'Kanaal',
                'links__frequency' => 'Frequency (Mhz)',
		'links__status' => 'Status',
		'links__status-active' => 'Actief',
		'links__status-inactive' => 'Niet actief',
                'links__status-pending' => 'Pending',
		'links__equipment' => 'Apparatuur',
		'links__info' => 'Informatie',
		'peer' => 'Peer',
		'total_active_peers' => 'Actieve verbindingen',
		'total_active_p2p' => 'Actieve backbone verbindingen',
		'total_active_aps' => 'Actieve access points',
		'total_active_clients' => 'Actieve clients',
		'has_ap' => 'Heeft een Access Point',

		'subnets__ip_start' => 'Begin IP',
		'subnets__ip_end' => 'Eind IP',
		'subnets__type' => 'Subnet type',
		'subnets__type-local' => 'Thuis netwerk (LAN)',
		'subnets__type-link' => 'Verbinding',
		'subnets__type-client' => 'Client of Access Point',
		'subnets__link_id' => 'Verbinding',
		'subnets__client_node_id' => 'Client',
		'subnet' => 'Subnet',

		'ip_addresses__date_in' => 'Toegevoegd',
		'ip_addresses__hostname' => 'Hostname',
		'ip_addresses__ip' => 'IP adres',
		'ip_addresses__mac' => 'MAC adres',
		'ip_addresses__type' => 'Apparaat type',
		'ip_addresses__type-router' => 'Router',
		'ip_addresses__type-server' => 'Server',
		'ip_addresses__type-pc' => 'Computer',
		'ip_addresses__type-wireless-bridge' => 'Wifi apparaat',
		'ip_addresses__type-voip' => 'VoIP apparaat',
		'ip_addresses__type-camera' => 'Webcam',
		'ip_addresses__type-other' => 'Anders',
		'ip_addresses__always_on' => 'Altijd aanwezig (24/7)',
		'ip_addresses__always_on-Y' => 'Ja',
		'ip_addresses__always_on-N' => 'Nee',
		'ip_addresses__info' => 'Informatie',

		'services__title' => 'Categorie',
		'services__protocol' => 'Protocol',
		'services__protocol-tcp' => 'TCP',
		'services__protocol-udp' => 'UDP',
		'services__port' => 'Poort',

		'nodes_services__node_id' => 'Node',
		'nodes_services__service_id' => 'Categorie',
		'nodes_services__date_in' => 'Toegevoegd',
		'nodes_services__ip_id' => 'IP Adres',
		'nodes_services__url' => 'URL',
		'nodes_services__status' => 'Status',
		'nodes_services__status-active' => 'Actief',
		'nodes_services__status-inactive' => 'Niet actief',
		'nodes_services__info' => 'Informatie',
		'nodes_services__protocol' => 'Protocol',
		'nodes_services__protocol-tcp' => 'TCP',
		'nodes_services__protocol-udp' => 'UDP',
		'nodes_services__port' => 'Poort',

		'node_settings_changes__id' => 'id',
	     	'node_settings_changes__node_id' => 'nodeid',
		'node_settings_changes__uid' => 'uid',
		'node_settings_changes__changemenu' => 'Section Changed',
		'node_settings_changes__changemade' => 'Last Change',
		'node_settings_changes__reason' => 'Change Reason',
		'node_settings_changes__comment' => 'Comment',
		'node_settings_changes__dateline' => 'Date and Time',
		
		'photos__date_in' => 'Datum',
		'photos__view_point' => 'Aspect',
		'photos__view_point-N' => 'Noord',
		'photos__view_point-NE' => 'Noord-oost',
		'photos__view_point-E' => 'Oost',
		'photos__view_point-SE' => 'Zuid-oost',
		'photos__view_point-S' => 'Zuid',
		'photos__view_point-SW' => 'Zuid-west',
		'photos__view_point-W' => 'West',
		'photos__view_point-NW' => 'Noord-west',
		'photos__view_point-PANORAMIC' => 'Panorama',
		'photos__info' => 'Informatie',
		'photo' => 'Foto',

		'rights__type' => 'Privilege',
		'rights__type-blocked' => 'Geblokkeerd',
		'rights__type-admin' => 'Beheerder',
		'rights__type-hostmaster' => 'Hostmaster'
	),
	
	'message' => array(
		'info' => array(
			'insert_success' => array(
				'title' => "Toevoegen",
				'body' => "Toevoegen is gelukt."
			),
			'edit_success' => array(
				'title' => "Wijzigen",
				'body' => "Wijzigen is gelukt."
			),
			'delete_success' => array(
				'title' => "Verwijderen",
				'body' => "Verwijderen is gelukt."
			),
			'update_success' => array(
				'title' => "Informatie bewerken",
				'body' => "Informatie bewerken is gelukt."
			),
			'request_range_success' => array(
				'title' => "Aanvraag IP C-Class",
				'body' => "Uw aanvraag voor een IP C-Klasse is met succes in de wachtrij geplaats. Binnenkort zal het beheerders team antwoord sturen naar uw e-mail adres. U kunt de status van uw IP-C-Klasse aanvraag bekijken in uw node pagina.."
			),
			'request_dnszone_success' => array(
				'title' => "Aanvraag DNS zone",
				'body' => "Uw aanvraag voor een DNS zone is met succes in de wachtrij geplaats. Binnenkort zal het beheerders team antwoord sturen naar uw e-mail adres. U kunt de status van uw DNS zone aanvraag bekijken in uw node pagina.."
			),
			'request_dnsnameserver_success' => array(
				'title' => "Aanvraag DNS nameserver",
				'body' => "Uw aanvraag voor een DNS nameserver is met succes in de wachtrij geplaats. Binnenkort zal het beheerders team antwoord sturen naar uw e-mail adres. U kunt de status van uw DNS nameserver aanvraag bekijken in uw node pagina.."
			),
			'signup_success' => array(
				'title' => "Registratie aanvraag is afgerond",
				'body' => "Uw inschrijving is succesvol afgerond. Om uw account te activeren, klikt u op de URL die is verzonden naar uw e-mail adres."
			),
			'login_success' => array(
				'title' => "Aanmelden gelukt",
				'body' => "U bent aangemeld in het systeem."
			),
			'restore_success' => array(
				'title' => "Wachtwoord herstel is afgerond",
				'body' => "Het herstel van uw wachtwoord is geslaagd. Om uw wachtwoord te herstellen, klikt u op de URL die is verzonden naar uw e-mail adres."
			),
			'password_restored' => array(
				'title' => "Wachtwoord gewijzigd",
				'body' => "Je wachtwoord is met succes gewijzigd. U kunt nu inloggen met uw nieuwe wachtwoord."
			),	
			'logout_success' => array(
				'title' => "Afmelden",
				'body' => "U bent afgemeld uit het systeem."
			),
			'activation_required' => array(
				'title' => "Account registratie activeren",
				'body' => "Uw account is niet geactiveerd. Om uw account te activeren, klik op de activatie URL die is verzonden naar uw e-mail adres."
			),
			'activation_success' => array(
				'title' => "Account registratie geactiveerd",
				'body' => "Uw account is succesvol geactiveerd. U kunt zich nu aanmelden in het systeem met uw gebruikersnaam en wachtwoord."
			),
			'message_sent' => array(
				'title' => "Bericht is verzonden",
				'body' => "Uw bericht is succesvol verstuurd. Mogelijk antwoord zal verzonden worden door de beheerder(s) van de Node, aan uw e-mail account gedefinieerd in uw profiel."
			),
		),
		'error' => array(
			'no_privilege' => array(
					'title' => "Geen toegang",
					'body' => "U heeft geen toegang om deze pagina te bekijken."
			),
			'activation_failed' => array(
					'title' => "Account registratie",
					'body' => "Het activeren van uw registratie aanvraag is mislukt."
			),
			'database_error' => array(
				'title' => "Database fout",
				'body' => "Er is een database fout opgetreden. Stuur indien mogelijk een fout rapport van de fout naar de beheerder(s)."
			),
			'not_logged_in' => array(
				'title' => "Niet Ingelogd",
				'body' => "Deze functie vereist dat u bent ingelogd in het systeem. Als u nog niet aangemeld voor het systeem, kunt u dit doen bij de registreren optie op de begin pagina."
			),
			'login_failed' => array(
				'title' => "Aanmeldings fout",
				'body' => "De opgegeven aanmeld informatie is niet juist. Controleer of u de juiste gebruikers naam en wachtwoord gebruikt."
			),
			'password_not_match' => array(
				'title' => "Wachtwoord fout",
				'body' => "U heeft niet hetzelfde wachtwoord opgeven in beide wachtwoord velden."
			),
			'password_not_valid' => array(
				'title' => "Password fout",
				'body' => "U mag geen leeg wachtwoord veld invoeren."
			),
			'fields_required' => array(
				'title' => "Verplicht",
				'body' => "Het is verplicht dat u iets vult in de volgende velden:\n##fields_required##"
			),
			'duplicate_entry' => array(
				'title' => "Uw aanvraag is al aanwezig",
				'body' => "De volgende gegevens zijn reeds aanwezig:\n##duplicate_entries##"
			),
			'upload_file_failed' => array(
				'title' => "Versturen van Bestand",
				'body' => "Het versturen van uw bestand is mislukt. Voor meer informatie kunt u contact opnemen met de systeem beheerder(s)."
			),
			'nodes_field_name' => array(
				'title' => 'Wijzigen node naam',
				'body' => 'Wijzigen van de node naam is niet toegestaan.'
			),
			'nodes_no_area_id' => array(
				'title' => 'Gebied is fout',
				'body' => 'U heeft niet het gebied ingevult van uw node. Om in aanmerking te komen van een IP C-Class, moet er een gebied zijn ingevuld van uw node.'
			),
			'subnet_backbone_no_ip_range' => array(
				'title' => 'Toevoegen van subnet aan een link',
				'body' => 'Dit subnet behoort niet tot een van de IP-C-Klassen die zijn toegewezen aan uw node. Als dit subnet behoort tot de IP-C-klasse van de peer node, zal dit moeten worden ingediend bij beheerder(s) van de peer node.'
			),
			'schema_files_missing' => array(
				'title' => 'Schema bestanden ontbreken',
				'body' => 'Neem a.u.b. contact op met de systeem beheerder(s) om dit probleem te laten oplossen.'
			),
			'node_not_found' => array(
				'title' => 'De node is niet gevonden.',
				'body' => 'De node die u op zoek bent, bestaat niet. Controleer of u de juiste gegevens verstrekt en probeer het opnieuw. Als u zeker weet dat u de juiste gegevens heeft ingegeven, is het mogelijk dat de node is verwijderd of dat de gebruiker zijn / haar account nog niet heeft geactiveerd.'
			),
			'zone_invalid_name' => array(
				'title' => 'Onjuiste zone name',
				'body' => 'The naam van de zone bevat ongeldige karakters.'
			),
			'zone_out_of_range' => array(
				'title' => 'Zone name niet in de C-Class',
				'body' => 'De naam van de zone komt niet overeen met de aanwezige IP C-Classes dat zijn toegewezen aan uw node.'
			),
			'zone_reserved_name' => array(
				'title' => 'Zone name gereserveerd',
				'body' => 'De naam van de zone is reeds gereserveerd in het systeem.'
			),
			'generic' => array(
				'title' => "Algemene fout",
				'body' => "Er is een algemene fout opgetreden. Stuur indien mogelijk een fout rapport van de fout     naar de beheerder(s)."
			)
		)
	),
		
	'email' => array(
		'user_activation' => array(
			'subject' => "Account Activeren: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\nAccount Activeren ##username##\n\nKlik hier: ##act_link##"
		),

		'user_restore' => array(
			'subject' => "Wachtwoord opvragen: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nWachtwoord opvragen voor account ##username##\n\nKlik hier: ##act_link##"
		),

		'user_change_email' => array(
			'subject' => "E-mail adres gewijzigd: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nE-mail adres gewijzigd voor account ##username##\n\nKlik hier: ##act_link##"
		),

		'node_contact' => array(
			'subject_prefix' => "WiND: ",
			'subject_suffix' => "",
			'body_prefix' => "Contact met beheerder(s) van node ##node_name## (###node_id##).\nGebruiker ##username##Heeft onderstaande bericht gestuurd\nvia de applicatie WiND - Wireless Nodes Database:\n-------------------------------------------------------------------\n\n",
			'body_suffix' => "\n\n-------------------------------------------------------------------\nAntwoord op dit bericht om in contact te komen met de verzender.\nWiND - Wireless Nodes Database\n-------------------------------------------------------------------"
		),

		'range' => array(
			'pending' => array(
				'subject' => "##range##: In afwachting ",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nBovenstaande IP C-Class is aangevraagd met de status 'In afwachting'.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'active' => array(
				'subject' => "##range##: Geactiveerd",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nBovenstaande IP C-Class aanvragen zijn geactiveerd.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'rejected' => array(
				'subject' => "##range##: Afgewezen",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nBovenstaande IP C-Class aanvragen zijn afgewezen.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'invalid' => array(
				'subject' => "##range##: Onjuist",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nBovenstaande IP C-Class aanvragen zijn onjuist.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			)
		),
		
		'zone' => array(
			'pending' => array(
				'subject' => "##zone##: In afwachting",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nBovenstaande DNS zone aanvraag heeft de status 'In afwachting'.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'active' => array(
				'subject' => "##zone##: Geactiveerd",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nBovenstaande DNS zone is geactiveerd.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'rejected' => array(
				'subject' => "##zone##: Afgewezen",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nBovenstaande DNS zone aanvraag is afgewezen.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'invalid' => array(
				'subject' => "##zone##: Onjuist",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nBovenstaande DNS zone aanvraag is onjuist.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			)
		)
	),
	
	'help' => array(
		'dnszones' => array(
			'title' => 'DNS zones',
			'body' => 'Op deze pagina kunt u zoeken naar DNS-zones van het netwerk door het invullen van de betreffende velden. De resultaten worden weergegeven in de navolgende tabel. Bovendien kunt u kiezen voor een node voor het bekijken hiervan.'
		),
		
		'services' => array(
			'title' => 'Diensten',
			'body' => 'Op deze pagina kunt u zoeken naar netwerkdiensten door het invullen van de betreffende velden. De resultaten worden weergegeven in de navolgende tabel. Bovendien kunt u kiezen voor een dienst of een node voor het bekijken hiervan..'
		),
		
		'node_editor_add' => array(
			'title' => 'Node toevoeren',
			'body' => 'Op deze pagina kunt u een node toevoegen. Zorg er voor dat de juiste informatie wordt ingevoerd.'
		),
		'node_editor' => array(
			'title' => 'Node beheer',
			'body' => 'Op deze pagina kunt u volledig beheer doen over uw node. Zorg ervoor dat u nauwkeurige gegevens invult. Er is een Help-gedeelte voor elke pagina.'
		),
		'node_editor_range' => array(
			'title' => 'Aanvraag IP C-Class',
			'body' => 'Omschrijf duidelijk de reden van uw aanvraag in het veld "Informatie".'
		),
        'node_editor_range_v6' => array(
			'title' => 'IPv6 Net request',
			'body' => 'Describe clearly the reason for your request in the field "Info".'
		),
		'node_editor_dnszone_request_reverse' => array(
			'title' => 'Aanvraag DNS zone',
			'body' => 'Omschrijf duidelijk de reden van uw aanvraag in het veld "Informatie".'
		),
		'node_editor_dnszone_request_forward' => array(
			'title' => 'Aanvraag DNS zone',
			'body' => 'Omschrijf duidelijk de reden van uw aanvraag in het veld "Informatie".'
		),
		'node_editor_dnszone_edit' => array(
			'title' => 'Wijzigen DNS zone',
			'body' => 'Op deze pagina kunt u de nameservers (NS) toevoegen die verantwoordelijk zijn voor de zone'
		),
		'node_editor_dnsnameserver_add' => array(
			'title' => 'Toevoegen nameserver (NS)',
			'body' => 'Voer de naam en het IP adres in van de nameserver.'
		),
		'node_editor_dnsnameserver_edit' => array(
			'title' => 'Wijzigen Nameserver (NS)',
			'body' => 'Op deze pagina kunt u de naam van uw nameserver (NS wijzigen). Je kan niet het IP-adres van de nameserver wijzigen. In plaats daarvan, kunt u verzoeken sturen om de nameserver en het vragen voor het toevoeging van een nieuwe nameserver met het nieuwe IP-adres.'
		),
		'node_editor_link_add' => array(
			'title' => 'Toevoegen verbinding',
			'body' => 'Op deze pagina kunt u een link van je node met een ander node toevoegen. Vul duidelijk en nauwkeurig zoveel mogelijk velden in.'
		),
		'node_editor_link_edit' => array(
			'title' => 'Wijzigen verbinding',
			'body' => 'Op deze pagina kunt u een link van je node met een ander node wijzigen. Vul duidelijk en nauwkeurig zoveel mogelijk velden in.'
		),
		'node_editor_subnet_add' => array(
			'title' => 'Toevoegen subnet',
			'body' => 'Op deze pagina kunt u een subnet voor uw node toevoegen. Als het subnet wordt gebruikt in een verbinding met een andere node, moet bij een van de C-IP Classes die zijn toegewezen aan een van de twee nodes en kan worden toegevoegd door de eigenaar van de IP C-Klasse de bij het subnet behoort. Voor uw netwerk, kunt u zoveel subnetten toevoegen als u wenst die niet behoren tot een van de IP-C-Klassen die zijn toegewezen aan uw node.'
		),
		'node_editor_subnet_edit' => array(
			'title' => 'Wijzigingen subnet',
			'body' => 'Op deze pagina kunt een een subnet wijzigen van uw node.'
		),
		'node_editor_ipaddr_add' => array(
			'title' => 'Toevoegen IP adres',
			'body' => 'Op deze pagina kunt u een IP-adres voor uw node toevoegen. Het veld Hostnaam beschrijft het apparaat dat bij het betreffende IP-adres behoort en moet hetzelfde zijn voor alle IP-adressen van dat apparaat'

		),
		'node_editor_ipaddr_edit' => array(
			'title' => 'Wijzigen IP adres',
			'body' => 'In deze pagina kunt u toevoegen of een IP-adres bewerken voor uw node. Het \'Hostname\' veld beschrijft het apparaat dat bij het betreffende IP-adres behoort en moet hetzelfde zijn voor alle IP-adressen van dat apparaat'
		),
		
		'node_editor_services_add' => array(
			'title' => 'Toevoegen dienst',
			'body' => 'Op deze pagina kunt u een dienst van uw node toevoegen. Het veld IP-adres dient een IP-adres te bevatten waar de dienst naar luistert. Het URL-veld moet een link bevatten naar de dienst of een link naar een pagina over de dienst. Het protocol en de poort veld moeten het protocol bevatten (dwz TCP, UDP) en het poort-nummer waar de dienst gebruik van maakt'
		),
		'node_editor_services_edit' => array(
			'title' => 'Wijzigen diensten ',
			'body' => 'Op deze pagina kunt u een dienst van uw node wijzigen. Het veld IP-adres dient een IP-adres te bevatten waar de dienst naar luistert. Het URL-veld moet een link bevatten naar de dienst of een link naar een pagina over de dienst. Het protocol en de poort veld moeten het protocol bevatten (dwz TCP, UDP) en het poort-nummer waar de dienst gebruik van maakt'
		),
		'admin_services' => array(
			'title' => 'Diensten beheer',
			'body' => 'Op deze pagina kunt u toevoegen, bewerken of verwijderen van een dienst categorie. Vanuit de Bewerken <<Berwerken diensten >> link kan je alle netwerkdiensten en bewerken.'
		),
		
		'nodes_search' => array(
			'title' => 'Netwerk nodes',
			'body' => 'In deze pagina kunt u zoeken naar netwerk node door het invullen van de overeenkomende velden. De resultaten worden weergegeven in de navolgende tabel. Bovendien kunt u kiezen voor een node voor het bekijken hiervan.'
		),
		'ranges_allocation' => array(
			'title' => 'Gereserbeerde IP reeksen',
			'body' => 'Op deze pagina kunt u het totaal aantal IP reeksen zien zijn uitgegeven voor elke gebied.'
		),
		'ranges_search' => array(
			'title' => 'Zoeken naar IP C-Classes',
			'body' => 'Op deze pagina kunt u zoeken naar IP-C-Klassen die zijn toegewezen aan nodes. De resultaten worden weergegeven in de volgende tabel. Bovendien kunt u kiezen voor een node voor het bekijken hiervan'
		),
		'users_restore_password_recover' => array(
			'title' => 'Wachtwoord opvragen.',
			'body' => 'Op deze pagina kunt u uw verloren wachtwoord voor uw account opvragen. Vul de velden van het formulier in en u zult een e-mail ontvangen met verdere instructies.'
		),
		'users_restore_password_change' => array(
			'title' => 'Wijzigen wachtwoord',
			'body' => 'Op deze pagina kunt u het wachtwoord van uw account wijzigen. Na het succesvolle indienen van een nieuw wachtwoord in het onderstaande formulier, kunt u direct inloggen op uw account met uw nieuwe wachtwoord'
		),
		'users_add' => array(
			'title' => 'Nieuwe gebruiker',
			'body' => 'Vul uw gegevens in onderstaand formulier in. Om uw e-mailadres te verifieren en uw account te activeren, wordt een e-mail verzonden naar uw e-mailadres met gedetailleerde instructies. U kunt inloggen op uw account nadat u deze heeft geactiveerd.'
		),
		'users_edit' => array(
			'title' => 'Gebruikers gegevens',
			'body' => 'Op deze pagina kunt u uw gegevens wijzigen. Als u uw e-mail adres wijzigd, zal er een e-mail worden verzonden naar uw nieuwe adres met gedetailleerde instructies over hoe u uw account opnieuw kunt activeren.'
		),
		'node_contact' => array(
			'title' => 'Stuur een bericht',
			'body' => 'Op deze pagina kunt u een bericht sturen naar de beheerder(s) van de node. Uw e-mailadres zal in uw bericht worden meegezonden, zodat u een antwoord kan krijgen van de ontvanger(s). Elk antwoord op uw bericht wordt verzonden naar uw e-mail adres en zal het e-mailadres van de afzender(s) bevatten, zodat u weer kunt reageren op mailtjes.'

		)
	),
	
	'languages' => array(
		'dutch' => 'Dutch',
		'english' => 'English',
		'greek' => 'Greek'
	)

);

?>
