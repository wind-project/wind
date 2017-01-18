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

setlocale(LC_ALL, 'en_US.utf8', 'english');

$lang = array(

	'charset' => 'utf-8',
	'iso639' => 'en',
	'mysql_charset' => 'utf8',

	'site_title' => "WiND - Wireless Nodes Database",
	'title_small' => "WiND",	

	'forward_text' => "Click here to go directly to the next page...",
	'delete_request' => "Delete Request",
	'location' => 'Location',
	'delete' => "Delete",
	'home' => "Home",
	'edit_profile' => "User profile",
	'edit_node' => "Node edit",
	'logout' => "Logout",
	'login' => "Login",
	'register' => "Register",
	'password_recover' => "Recover Password",
	'password_change' => "Change Password",
	'all_nodes' => "Network Nodes",
	'all_zones' => "DNS Zones",
	'all_ranges' => "IP Addressing",
	'user_info' => "User info",
	'users_info' => "Users info",
	'username' => "Username",
	'password' => "Password",
	'network' => 'Network',
	'rememberme' => "Keep me logged in",
	'registered_since' => "Registered",
	'name' => "First Name",
	'surname' => "Last Name",
	'last_visit' => "Last visit",
	'mynodes' => "My nodes",
	'node_add' => "Add node",
	'admin_panel' => "Administration",
	'nodes' => "Nodes",
	'users' => "Users",
	'hostmaster_panel' => "Hostmaster",
	'ip_ranges' => "IP C-Classes",
        'ip_ranges_v6' => "IPv6 Networks",
	'dns_zones' => "DNS zones",
	'dns_nameservers' => "Nameservers (NS)",
	'waiting' => "waiting",
	'for_deletion' => "to delete",
	'welcome' => "Welcome",
	'gearth_download' => "Google Earth file download",
	'google_earth' => "Google Earth",
	'nodes_search' => "Search for nodes",
	'nodes_found' => "Nodes found",
	'users_search' => "Search for users",
	'users_found' => "Users found",
	'dns_zones_search' => "Search for DNS zones",
	'dns_zones_found' => "DNS zones found",
	'not_found' => "No results found",	
	'all_services' => "Network services",
	'active_services' => "Active services",
	'services_search' => "Search services",
	'services_found' => "Services found",
	'services_categories' => "Services categories",
	'services_categories_add' => "Add service category",
	'services_categories_edit' => "Edit service category",
	'nodesettingschanges_add' => "Add Change Log for this Node",
	'nodesettingschanges' => "ChangeLog",
	'services_edit' => "Edit service",
	'services_add' => "Add service",
	'services' => "Services",
	'user_add' => "New user",
	'user_edit' => "User profile",
	'node' => "Node",
	'node_info' => "Node info",
	'node_view' => "Node view",
	'node_delete' => "Delete node",
	'ip_range_request' => "IP C-Class request",
	'ip_range_request_for_node' => "IP C-Class request for node",
        'ip_range_v6_request' => "IPv6 Range Request",
	'ip_range_v6_request_for_node' => "IPv6 Range Request for node",
	'dnszone_request_forward' => "DNS zone request (forward)",
	'dnszone_request_reverse' => "DNS zone requset (reverse)",
	'dnszone_edit' => "Edit DNS zone",
	'nameserver_add' => "Add nameserver (NS)",
	'nameserver_edit' => "Edit nameserver (NS)",
	'link_edit' => "Edit link",
	'link_add' => "Add link",
	'links' => "Links",
	'ap' => "Access Point",
	'aps' => "Access Points",
	'aps_abbr' => "APs",
	'free' => "Free",
	'aps_search' => "Search for Access Points",
	'aps_found' => "Access Points found",
	'subnet_edit' => "Edit subnet",
	'subnet_add' => "Add subnet",
	'subnets' => "Subnets",
	'ip_address_edit' => "Edit IP address",
	'ip_address_add' => "Add IP address",
	'ip_addresses' => "IP addresses",
        'ip_cname_edit' => "Edit CNAME",
        'ip_cname_add' => "Add CNAME",
        'ip_cnames' => "CNAMEs",
	'myview' => "Node's View",
	'ip_ranges_search' => "Search for IP Networks",
	'ip_ranges_found' => "IP Networks found",
	'dns_nameservers_search' => "Search for DNS nameservers",
	'dns_nameservers_found' => "DNS nameservers found",
	'ip_range_edit' => "Edit IP C-Class",
	'send_mail' => "Send message",
	'to' => "To",
	'subject' => "Subject",
	'body' => "Message",
	'mailto_all' => "Administrator & Coadministrators",
	'mailto_owner' => "Administrator",
	'mailto_custom' => "Other",
	'ip_ranges_allocation' => "IP ranges allocation",
	'ip_ranges_search' => "Search for IP Networks",
	'change' => "Change",
	'submit' => "OK",
	'cancel' => 'Cancel',
	'add' => "Add",
	'remove' => "Remove",
	'update' => "Update",
	'search' => "Search",
	'plot' => "Line of sight (LOS)",
	'mynetwork' => "Node subnetwork",
	'new_window' => "New Window",
	'node_plot_link' => "Line of sight (LOS) with other nodes",
	'nodes_plot_link' => "Line of sight (LOS) of nodes",
	'nodes_plot_link_info' => "Choose above the nodes for which you want to plot the line of sight (LOS).",
	'distance' => "Distance",
	'azimuth' => "Azimuth",
	'elevation' => "Elevation",
	'fsl' => "Free space loss",
	'tilt' => "Tilt",
	'clients' => "Clients",
	'compare_equal' => "Equal to",
	'compare_greater' => "Greater than",
	'compare_less' => "Less than",
	'compare_greater_equal' => "Greater than or equal to",
	'compare_less_equal' => "Less than or equal to",
	'compare_starts_with' => "Starts from",
	'compare_ends_with' => "Ends at",
	'compare_contains' => "Contains",
	'zone_forward' => "Forward DNS zone",
	'zone_reverse' => "Reverse DNS zone",
	'contact' => "Contact",
	'contact_node' => "Contact node administrator(s)",
	'from' => "From",
	'send' => "Send",
	'node_page' => "Node Page",
	'yes' => "Yes",
	'no' => "No",
	'backbone' => "Backbone",
	'backbones_abbr' => "BBs",
	'unlinked' => "Not linked",
	'find_coordinates' => "Find coordinates",
	'select_the_coordinates' => "Select coordinates",
	'coordinates', 'Coordinates',
	'quick_search' => "Quick Search",
	'statistics' => "Statistics",
	'active_nodes' => "Active nodes",
	'backbone_nodes' => "Backbone nodes",
	'null' => "(null)",
	'default' => 'Default',
	'logged' => 'Logged in as',
	'regions' => 'Districts',
	'region_add' => 'Add district',
	'region_edit' => 'Edit district',
	'areas' => 'Areas',
	'area_add' => 'Add area',
	'area_edit' => 'Edit area',

	'db' => array(
		'users__username' => 'User Name',
		'users__password' => 'Password',
		'users__password_c' => 'Confirm password',
		'users__surname' => 'Last Name',
		'users__name' => 'First Name',
		'users__email' => 'E-mail',
		'users__phone' => 'Phone Number',
		'users__info' => 'Info',
		'users__status' => 'Registration',
		'users__status-pending' => 'Pending',
		'users__status-activated' => 'Activated',
		'users__language' => 'Language',
		'fullname' => 'Full Name',
		
		'nodes__id' => 'Node ID',
		'nodes__name' => 'Node name',
		'nodes__date_in' => 'Created',
		'nodes__due_date' => 'Installation Due Date',
		'nodes__last_change' => 'Last Changed',
		'nodes__area_id' => 'Area',
		'nodes__latitude' => 'Geographical latitude',
		'nodes__longitude' => 'Geographical longitude',
		'nodes__elevation' => 'Building height (m)',
		'nodes__info' => 'Info',
		'nodes__status' => 'Status',
		'nodes__status-active' => 'Active',
		'nodes__status-inactive' => 'Inactive',
		'nodes__status-pending' => 'Pending',
		'nodes__status-deleted' => 'Deleted',
		'nodes__name_ns' => 'Nameserver prefix',
		
		'users_nodes__owner' => 'Privilege',
		'users_nodes__owner-Y' => 'Administrator',
		'users_nodes__owner-N' => 'Coadministrator',
		'users_nodes__user_id' => 'Coadministrators',
		'users_nodes__node_id' => 'Nodes coadministration',
		'user_id_owner' => 'Administrator',
		'node_id_owner' => 'Nodes administration',

		'areas__id' => 'Area',
		'areas__region_id' => 'District',
		'areas__name' => 'Area',
		'areas__ip_start' => 'IP from',
		'areas__ip_end' => 'IP up to',
                'areas__v6net' => 'IPv6 Network',
                'areas__v6prefix' => 'IPv6 Prefix',
		'areas__info' => 'Info',

		'regions__id' => 'District',
		'regions__name' => 'District',
		'regions__ip_start' => 'IP from',
		'regions__ip_end' => 'IP up to',
                'regions__v6net' => 'IPv6 Network',
                'regions__v6prefix' => 'IPv6 Prefix',
		'regions__info' => 'Info',

		'ip_ranges__date_in' => 'Date',
		'ip_ranges__ip_start' => 'From',
		'ip_ranges__ip_end' => 'Up to',
		'ip_ranges__status' => 'Status',
		'ip_ranges__status-waiting' => 'Waiting check',
		'ip_ranges__status-pending' => 'Pending',
		'ip_ranges__status-active' => 'Active',
		'ip_ranges__status-rejected' => 'Rejected',
		'ip_ranges__status-invalid' => 'Invalid',
		'ip_ranges__info' => 'Info',
		'ip_ranges__delete_req' => 'Delete request',
		'ip_ranges__delete_req-Y' => 'YES',
		'ip_ranges__delete_req-N' => 'NO',
		'ip_range' => 'C Class',
		'ip' => 'IP address',

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
            
		'dns_zones__date_in' => 'Date',
		'dns_zones__name' => 'Zone name',
		'dns_zones__type' => 'Zone type',
		'dns_zones__type-forward' => 'Forward',
		'dns_zones__type-reverse' => 'Reverse',
		'dns_zones__status' => 'Status',
		'dns_zones__status-waiting' => 'Waiting check',
		'dns_zones__status-pending' => 'Pending',
		'dns_zones__status-active' => 'Active',
		'dns_zones__status-rejected' => 'Rejected',
		'dns_zones__status-invalid' => 'Invalid',
		'dns_zones__info' => 'Info',

		'schema' => "Schema",

		'dns_zones_nameservers__nameserver_id' => 'Responsible Nameservers (NS)',

		'dns_nameservers__date_in' => 'Date',
		'dns_nameservers__name' => 'Nameserver name',
		'dns_nameservers__ip' => 'IP address',
		'dns_nameservers__status' => 'Status',
		'dns_nameservers__status-waiting' => 'Waiting check',
		'dns_nameservers__status-pending' => 'Pending',
		'dns_nameservers__status-active' => 'Active',
		'dns_nameservers__status-rejected' => 'Rejected',
		'dns_nameservers__status-invalid' => 'Invalid',

		'links__date_in' => 'Created',
                'links__due_date' => 'Due Date',
		'links__peer_node_id' => 'Peer node',
		'links__peer_ap_id' => 'Access point',
		'links__type' => 'Link type',
		'links__type-p2p' => 'Backbone',
		'links__type-ap' => 'Access Point',
		'links__type-client' => 'Client',
		'links__type-free' => 'Free',
		'links__ssid' => 'SSID',
		'links__protocol' => 'Protocol',
		'links__protocol-other' => 'Other',
		'links__channel' => 'Channel',
                'links__frequency' => 'Frequency (Mhz)',
		'links__status' => 'Status',
		'links__status-active' => 'Active',
		'links__status-inactive' => 'Inactive',
                'links__status-pending' => 'Pending',
		'links__equipment' => 'Equipment',
		'links__info' => 'Info',
		'peer' => 'Peer',
		'total_active_peers' => 'Active peers',
		'total_active_p2p' => 'Active backbone links',
		'total_active_aps' => 'Active access points',
		'total_active_clients' => 'Active clients',
		'has_ap' => 'Has Access Point',

		'subnets__ip_start' => 'From',
		'subnets__ip_end' => 'Up to',
		'subnets__type' => 'Subnet type',
		'subnets__type-local' => 'Home LAN',
		'subnets__type-link' => 'Link',
		'subnets__type-client' => 'Client of Access Point',
		'subnets__link_id' => 'Link',
		'subnets__client_node_id' => 'Client',
		'subnet' => 'Subnet',

		'ip_addresses__date_in' => 'Added',
		'ip_addresses__hostname' => 'Hostname',
		'ip_addresses__ip' => 'IP address',
		'ip_addresses__mac' => 'MAC address',
		'ip_addresses__type' => 'Device type',
		'ip_addresses__type-router' => 'Router',
		'ip_addresses__type-server' => 'Server',
		'ip_addresses__type-pc' => 'PC',
		'ip_addresses__type-wireless-bridge' => 'Wireless Device',
		'ip_addresses__type-voip' => 'VoIP Device',
		'ip_addresses__type-camera' => 'Web camera',
		'ip_addresses__type-other' => 'Other',
		'ip_addresses__always_on' => 'Always on-line (24/7)',
		'ip_addresses__always_on-Y' => 'Yes',
		'ip_addresses__always_on-N' => 'No',
		'ip_addresses__info' => 'Info',

                'ip_cname__date_in' => 'Added',
                'ip_cname__hostname' => 'Hostname',
                'ip_cname__cname' => 'CNAME',
                'ip_cname__info' => 'Info',

		'services__title' => 'Category',
		'services__protocol' => 'Protocol',
		'services__protocol-tcp' => 'TCP',
		'services__protocol-udp' => 'UDP',
		'services__port' => 'Port',

		'nodes_services__node_id' => 'Node',
		'nodes_services__service_id' => 'Category',
		'nodes_services__date_in' => 'Added',
		'nodes_services__ip_id' => 'IP Address',
		'nodes_services__url' => 'URL',
		'nodes_services__status' => 'Status',
		'nodes_services__status-active' => 'Active',
		'nodes_services__status-inactive' => 'Inactive',
		'nodes_services__info' => 'Info',
		'nodes_services__protocol' => 'Protocol',
		'nodes_services__protocol-tcp' => 'TCP',
		'nodes_services__protocol-udp' => 'UDP',
		'nodes_services__port' => 'Port',
		
		'node_settings_changes__id' => 'id',
	     	'node_settings_changes__node_id' => 'nodeid',
		'node_settings_changes__uid' => 'uid',
		'node_settings_changes__changemenu' => 'Section Changed',
		'node_settings_changes__changemade' => 'Last Change',
		'node_settings_changes__reason' => 'Change Reason',
		'node_settings_changes__comment' => 'Comment',
		'node_settings_changes__dateline' => 'Date and Time',
		
		'photos__date_in' => 'Date',
		'photos__view_point' => 'Aspect',
		'photos__view_point-N' => 'North',
		'photos__view_point-NE' => 'Northeast',
		'photos__view_point-E' => 'East',
		'photos__view_point-SE' => 'Southeast',
		'photos__view_point-S' => 'South',
		'photos__view_point-SW' => 'Southwest',
		'photos__view_point-W' => 'West',
		'photos__view_point-NW' => 'Northwest',
		'photos__view_point-PANORAMIC' => 'Panoramic',
		'photos__info' => 'Info',
		'photo' => 'Photo',

		'rights__type' => 'Privilege',
		'rights__type-blocked' => 'Blocked',
		'rights__type-admin' => 'Administrator',
		'rights__type-hostmaster' => 'Hostmaster'
	),
	
	'message' => array(
		'info' => array(
			'insert_success' => array(
				'title' => "Input",
				'body' => "Input was successful."
			),
			'edit_success' => array(
				'title' => "Modify",
				'body' => "Modification was successful."
			),
			'delete_success' => array(
				'title' => "Delete",
				'body' => "Deletion was successful."
			),
			'update_success' => array(
				'title' => "Data update",
				'body' => "Data were updated successfully."
			),
			'request_range_success' => array(
				'title' => "IP C-Class request",
				'body' => "Your request for IP C-Class was successfully queued. Soon, the Hostmaster team will reply to your e-mail address. You can watch the status of your IP C-Class request in your node's page."
			),
			'request_dnszone_success' => array(
				'title' => "DNS zone request",
				'body' => "Your request for DNS zone was successfully queued. Soon, the Hostmaster team will reply to your e-mail address. You can watch the status of your DNS zone request in your node's page."
			),
			'request_dnsnameserver_success' => array(
				'title' => "DNS nameserver request",
				'body' => "Your request for DNS nameserver was successfully queued. Soon, the Hostmaster team will check your request. You can watch the status of your DNS nameserver request in your node's page."
			),
			'signup_success' => array(
				'title' => "Registration was completed",
				'body' => "Your registration was completed successfully. To activate your account, click at the URL that has been sent to your e-mail address."
			),
			'login_success' => array(
				'title' => "Login Successful",
				'body' => "You were successfully identified."
			),
			'restore_success' => array(
				'title' => "Password recovery was completed",
				'body' => "The recovery of your password was successful. To restore your password, click at the URL that has been sent to your e-mail address."
			),
			'password_restored' => array(
				'title' => "Password change",
				'body' => "You password has been changed successfully. You may now login with your new password."
			),	
			'logout_success' => array(
				'title' => "Logout",
				'body' => "You have logged out the system."
			),
			'activation_required' => array(
				'title' => "Account activation",
				'body' => "You account has not been activated. To activate your account, click at the activation URL that has been sent to your e-mail address."
			),
			'activation_success' => array(
				'title' => "Account activation",
				'body' => "Your account was activated successfully. You may now login to the system."
			),
			'message_sent' => array(
				'title' => "Message was sent",
				'body' => "Your message was sent successfully. Possible answer will be send by the administrators of the node, at your e-mail account defined at your profile."
			),
		),
		'error' => array(
			'no_privilege' => array(
					'title' => "Not authorized",
					'body' => "You are not authorized to view this page."
			),
			'activation_failed' => array(
					'title' => "Account activation",
					'body' => "The activation of your account failed."
			),
			'database_error' => array(
				'title' => "Database error",
				'body' => "A database error has occured. Please report the problem to the administrator(s)."
			),
			'not_logged_in' => array(
				'title' => "Not logged in",
				'body' => "This function requires that you have logged in the system. If you have not signed up to the system, you may do so in the registration section."
			),
			'login_failed' => array(
				'title' => "Login failed",
				'body' => "Login information is incorrect. Check that your username and/or password are correct."
			),
			'password_not_match' => array(
				'title' => "Password error",
				'body' => "You have not supplied the same password in both two fields."
			),
			'password_not_valid' => array(
				'title' => "Password error",
				'body' => "Your password must not be empty."
			),
			'fields_required' => array(
				'title' => "Required",
				'body' => "It is required that you fill in the following fields:\n##fields_required##"
			),
			'duplicate_entry' => array(
				'title' => "Your record already exists",
				'body' => "The following entries already exist:\n##duplicate_entries##"
			),
			'upload_file_failed' => array(
				'title' => "Upload file",
				'body' => "Uploading your file failed. For more info, contact with the system administrator(s)."
			),
			'nodes_field_name' => array(
				'title' => 'Change node name',
				'body' => 'Changing the node name is not allowed.'
			),
			'nodes_no_area_id' => array(
				'title' => 'Area error',
				'body' => 'You have not filled in the area of your node. In order to have an IP C-Class assigned to your node, the area of your node must be filled in your node\'s data.'
			),
			'subnet_backbone_no_ip_range' => array(
				'title' => 'Add subnet of peer link',
				'body' => 'This subnet does not belong to any of the IP C-Classes that have been assigned to your node. If this subnet belongs to the IP C-Class of the peer node, it should be submitted by the adminstrator(s) of the peer node.'
			),
			'schema_files_missing' => array(
				'title' => 'Schema files are missing',
				'body' => 'Please, contact with the system administrator(s) to fix the problem.'
			),
			'node_not_found' => array(
				'title' => 'The node was not found',
				'body' => 'The node you are looking for does not exist. Check that you supplied the correct data and try again. If you are sure that you submit the correct data, it is likely that the node has been deleted or that the user has not activated his/her account yet.'
			),
			'zone_invalid_name' => array(
				'title' => 'Invalid zone name',
				'body' => 'The name of the zone contains invalid characters.'
			),
			'zone_out_of_range' => array(
				'title' => 'Zone name not in C-Class',
				'body' => 'The name of the zone does not match to any of the IP C-Classes that have been assigned to your node.'
			),
			'zone_reserved_name' => array(
				'title' => 'Reserved zone name',
				'body' => 'The name of the zone is reserved by the system.'
			),
			'generic' => array(
				'title' => "General error",
				'body' => "A general error occured. Please, report this to the system administrator(s)."
			)
		)
	),
		
	'email' => array(
		'user_activation' => array(
			'subject' => "Account activation: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\nAccount Activation ##username##\n\nClick here: ##act_link##"
		),

		'user_restore' => array(
			'subject' => "Password recovery: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nPassword recovery for the account ##username##\n\nClick here: ##act_link##"
		),

		'user_change_email' => array(
			'subject' => "E-mail address change: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nE-mail address change for account ##username##\n\nClick here: ##act_link##"
		),

		'node_contact' => array(
			'subject_prefix' => "WiND: ",
			'subject_suffix' => "",
			'body_prefix' => "Contacting administrators of node ##node_name## (###node_id##).\nThe user ##username## has sent to you the following message\nthrough the application WiND - Wireless Nodes Database:\n-------------------------------------------------------------------\n\n",
			'body_suffix' => "\n\n-------------------------------------------------------------------\nReply to this message to contact with the sender.\nWiND - Wireless Nodes Database\n-------------------------------------------------------------------"
		),

		'range' => array(
			'pending' => array(
				'subject' => "##range##: Pending",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nThe above IP C-Class has been queued with status 'pending'.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'active' => array(
				'subject' => "##range##: Activated",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nThe above IP C-Class has been activated.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'rejected' => array(
				'subject' => "##range##: Rejected",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nThe above IP C-Class has been rejected.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'invalid' => array(
				'subject' => "##range##: Invalid",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nNode: ##node_name## (###node_id##)\n\nThe above IP C-Class was invalid.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			)
		),
		
		'zone' => array(
			'pending' => array(
				'subject' => "##zone##: Pending",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nThe above DNS zone has been queued with status 'pending'.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'active' => array(
				'subject' => "##zone##: Activated",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nThe above DNS zone has been activated.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'rejected' => array(
				'subject' => "##zone##: Rejected",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nThe above DNS zone has been rejected.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'invalid' => array(
				'subject' => "##zone##: Invalid",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nNode: ##node_name## (###node_id##)\n\nThe above DNS zone was invalid.\n\nRepresenting the WiND Hostmaster team,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			)
		)
	),
	
	'help' => array(
		'dnszones' => array(
			'title' => 'DNS zones',
			'body' => 'In this page you can search for DNS zones of the network by filling in the corresponding fields. The results are displayed in the follwing table. Furthermore, you cat choose a node for viewing.'
		),
		
		'services' => array(
			'title' => 'Services',
			'body' => 'In this page you can search for network services by filling in the corresponding fields. The results are displayed in the follwing table. Furthermore, you cat choose a service or a node for viewing.'
		),
		
		'node_editor_add' => array(
			'title' => 'Add node',
			'body' => 'In this page you can add a node. Be sure to submit accurate data.'
		),
		'node_editor' => array(
			'title' => 'Nodes administration',
			'body' => 'In this page you can fully administrate your node. Be sure to submit accurate data. There is a help section for each page.'
		),
		'node_editor_range' => array(
			'title' => 'IP C-Class request',
			'body' => 'Describe clearly the reason for your request in the field "Info".'
		),
        'node_editor_range_v6' => array(
			'title' => 'IPv6 Net request',
			'body' => 'Describe clearly the reason for your request in the field "Info".'
		),
		'node_editor_dnszone_request_reverse' => array(
			'title' => 'DNS zone request',
			'body' => 'Describe clearly the reason for your request in the field "Info".'
		),
		'node_editor_dnszone_request_forward' => array(
			'title' => 'DNS zone request',
			'body' => 'Describe clearly the reason for your request in the field "Info".'
		),
		'node_editor_dnszone_edit' => array(
			'title' => 'Edit DNS zone',
			'body' => 'In this page you can add the nameservers (NS) that are responsible for the zone.'
		),
		'node_editor_dnsnameserver_add' => array(
			'title' => 'Add nameserver (NS)',
			'body' => 'Submit the name and the IP address of the nameserver.'
		),
		'node_editor_dnsnameserver_edit' => array(
			'title' => 'Edit Nameserver (NS)',
			'body' => 'In this page you can edit the name of your nameserver (NS). You cannot change the IP address of the nameserver. Instead, you can request the deletion of the nameserver and request the addition of a new nameserver with the new IP address.'
		),
		'node_editor_link_add' => array(
			'title' => 'Add link',
			'body' => 'In this page you can add a link of your node with another node. Fill in clearly as many of the fields as possible.'
		),
		'node_editor_link_edit' => array(
			'title' => 'Edit link',
			'body' => 'In this page you can edit a link of your node with another node. Fill in clearly as many of the fields as possible.'
		),
		'node_editor_subnet_add' => array(
			'title' => 'Add subnet',
			'body' => 'In this page you can add a subnet for your node. If the subnet is used in a link with another node, it must belong to any of the IP C-Classes that have been assigned to those two nodes and can be added only by the owner of the IP C-Class that the subnet belongs to. For your LAN, you may add subnets that do not belong to any of the IP C-Classes that have been assigned to your node.'
		),
		'node_editor_subnet_edit' => array(
			'title' => 'Edit subnet',
			'body' => 'In this page you can edit a subnet of your node.'
		),
		'node_editor_ipaddr_add' => array(
			'title' => 'Add IP address',
			'body' => 'In this page you can add an IP address for your node. The field Hostname describes the device that the corresponding IP address belongs to and must be the same for all the IP addresses of that device.'
		),
		'node_editor_ipaddr_edit' => array(
			'title' => 'Edit IP address',
			'body' => 'In this page you can add or edit an IP address for your node. The \'Hostname\' field describes the device that the corresponding IP address belongs to and must be the same for all the IP addresses of that device.'
		),

                'node_editor_cname_add' => array(
                        'title' => 'Add CNAME',
                        'body' => 'In this page you can add a CNAME for a \'Hostname\' on your node. CNAME is the new (alternative) name for the hostname (as defined under IP addresses). Both should be added without trailing bits. I.e. without .ctwug.za.net.'
                ),
                'node_editor_cname_edit' => array(
                        'title' => 'Edit CNAME',
                        'body' => 'In this page you can add or edit a CNAME address for a \'Hostname\' on your node.'
                ),
		
		'node_editor_services_add' => array(
			'title' => 'Add Service',
			'body' => 'In this page you can add a service of your node. The IP Address field should contain the IP address that the service is listening at. The URL field should contain a link to the service or a link to a page about the service. The Protocol and Port should contain the protocol (ie. tcp,udp) and the port that the service uses.'
		),
		'node_editor_services_edit' => array(
			'title' => 'Edit Service',
			'body' => 'In this page you can edit a service of your node. The IP Address field contains all the IP addresses that you have commit and should contain the IP address that the service is listening at. The URL field should contain a link to the service or a link to a page about the service. The Protocol and Port should contain the protocol (ie. tcp,udp) and the port that the service uses.'
		),
		'admin_services' => array(
			'title' => 'Services Administration',
			'body' => 'In this page you can add, edit or delete a Services Category. From the <<Edit Services>> link you can see all network services and edit them.'
		),
		
		'nodes_search' => array(
			'title' => 'Network nodes',
			'body' => 'In this page you can search for network nodes by filling the corresponding fields. The results are displayed in the following table. Furthermore, you can choose a node for viewing.'
		),
		'ranges_allocation' => array(
			'title' => 'IP ranges allocation',
			'body' => 'In this page you can thoroughly see the total of IP ranges that have been allocated for each area.'
		),
		'ranges_search' => array(
			'title' => 'Search for IP C-Classes',
			'body' => 'In this page you can search for IP C-Classes that have been assigned to nodes. The results are displayed in the following table. Furthermore, you can choose a node for viewing.'
		),
		'users_restore_password_recover' => array(
			'title' => 'Recover password',
			'body' => 'In this page you can recover your lost password for your account. Submit the fields in the form and you will receive an e-mail with further instructions.'
		),
		'users_restore_password_change' => array(
			'title' => 'Change password',
			'body' => 'In this page you can change the password of your account. By successfully submitting a new password in the following form, you may directly login to your account with your new password.'
		),
		'users_add' => array(
			'title' => 'New user',
			'body' => 'Fill in your data in the following form. To confirm your e-mail address and activate your account, an e-mail will be sent to your address with detailed instructions. You can login to your account only after you have activated it.'
		),
		'users_edit' => array(
			'title' => 'User profile',
			'body' => 'In this page you can edit your data. If you change your e-mail address, an e-mail will be sent to your new address with detailed instructions on how to reactivate your account.'
		),
		'node_contact' => array(
			'title' => 'Send message',
			'body' => 'In this page you can send a message to the administrator(s) of the node. Your e-mail address will appear to your message, so that you can get a reply from the receiver(s). Each reply to your message will be sent to your e-mail address and will contain the e-mail address of the sender(s), so that you can reply to them back.'
		)
	),
	
	'languages' => array(
		'greek' => 'Greek',
		'english' => 'English',
		'dutch' => 'Dutch'
	)

);

?>
