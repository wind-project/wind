<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2009 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 2 dated June, 1991.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/* el_GR.utf8 for GNU/Linux - ell for Windows */
setlocale(LC_ALL, 'el_GR.utf8', 'ell');

$lang = array(

	'charset' => 'utf-8',
	'iso639' => 'el',
	'mysql_charset' => 'utf8',
	
	'site_title' => "WiND - Wireless Nodes Database",
	'title_small' => "WiND",
	
	'forward_text' => "Αν δεν επιθυμείτε να περιμένετε πατήστε εδώ...",
	
	'delete_request' => "Αίτηση διαγραφής",
	
	'delete' => "Διαγραφή",
	'home' => "Αρχική σελίδα",
	'edit_profile' => "Προφίλ χρήστη",
	'edit_node' => "Επεξεργασία κόμβου",
	'log_out' => "Αποσύνδεση",
	'login' => "Σύνδεση",
	'register' => "Εγγραφή",
	'password_recover' => "Ανάκτηση κωδικού",
	'password_change' => "Αλλαγή κωδικού",
	'all_nodes' => "Κόμβοι δικτύου",
	'all_zones' => "Ζώνες DNS",
	'all_ranges' => "Διευθυνσιοδότηση",
	'user_info' => "Στοιχεία χρήστη",
	'users_info' => "Στοιχεία χρηστών",
	'username' => "Όνομα χρήστη",
	'registered_since' => "Εγγραφή",
	'name' => "Όνομα",
	'surname' => "Επώνυμο",
	'last_visit' => "Τελ. επίσκεψη",
	'mynodes' => "Οι κόμβοι μου",
	'node_add' => "Προσθήκη κόμβου",
	'admin_panel' => "Διαχείριση",
	'nodes' => "Κόμβοι",
	'users' => "Χρήστες",
	'hostmaster_panel' => "Hostmaster",
	'ip_ranges' => "IP C-Classes",
	'dns_zones' => "Ζώνες DNS",
	'dns_nameservers' => "Nameservers (NS)",
	'waiting' => "προς έλεγχο",
	'for_deletion' => "για διαγραφή",
	'welcome' => "Καλώς ήρθατε",
	'gearth_download' => "Google Earth file download",
	'google_earth' => "Google Earth",
	'nodes_search' => "Αναζήτηση κόμβων",
	'nodes_found' => "Κόμβοι που βρέθηκαν",
	'users_search' => "Αναζήτηση χρηστών",
	'users_found' => "Χρήστες που βρέθηκαν",
	'dns_zones_search' => "Αναζήτηση ζώνης DNS",
	'dns_zones_found' => "Ζώνες DNS που βρέθηκαν",
	'not_found' => "Δεν βρέθηκαν αποτελέσματα",
	'all_services' => "Υπηρεσίες δικτύου",
	'active_services' => "Ενεργές υπηρεσίες",
	'services_search' => "Αναζήτηση υπηρεσιών",
	'services_found' => "Υπηρεσίες που βρέθηκαν",
	'services_edit' => "Επεξεργασία υπηρεσίας",
	'services_add' => "Προσθήκη υπηρεσίας",
	'services' => "Υπηρεσίες",
	'services_categories' => "Κατηγορίες υπηρεσίων",
	'services_categories_add' => "Προσθήκη κατηγορίας υπηρεσίων",
	'services_categories_edit' => "Επεξεργασία κατηγορίας υπηρεσίων",

	'user_add' => "Εγγραφή νέου χρήστη",
	'user_edit' => "Προφίλ χρήστη",
	'node' => "Κόμβος",
	'node_info' => "Στοιχεία κόμβου",
	'node_view' => "Προβολή κόμβου",
	'node_delete' => "Διαγραφή κόμβου",
	'ip_range_request' => "Αίτηση απόδοσης IP C-Class",
	'ip_range_request_for_node' => "Αίτηση απόδοσης IP C-Class για τον κόμβο",
	'dnszone_request_forward' => "Αίτηση απόδοσης ζώνης DNS (forward)",
	'dnszone_request_reverse' => "Αίτηση απόδοσης ζώνης DNS (reverse)",
	'dnszone_edit' => "Επεξεργασία ζώνης DNS",
	'nameserver_add' => "Προσθήκη nameserver (NS)",
	'nameserver_edit' => "Επεξεργασία nameserver (NS)",
	'link_edit' => "Επεξεργασία διασύνδεσης",
	'link_add' => "Προσθήκη διασύνδεσης",
	'links' => "Διασυνδέσεις",
	'ap' => "Access Point",
	'aps' => "Access Points",
	'aps_abbr' => "APs",
	'aps_search' => "Αναζήτηση Access Points",
	'aps_found' => "Access Points που βρέθηκαν",
	'subnet_edit' => "Επεξεργασία υποδικτύου",
	'subnet_add' => "Προσθήκη υποδικτύου",
	'subnets' => "Υποδίκτυα",
	'ip_address_edit' => "Επεξεργασία διεύθυνσης IP",
	'ip_address_add' => "Προσθήκη διεύθυνσης IP",
	'ip_addresses' => "Διευθύνσεις IP",
	'myview' => "Η οπτική του κόμβου",
	'ip_ranges_search' => "Αναζήτηση IP C-Classes",
	'ip_ranges_found' => "IP C-Classes που βρέθηκαν",
	'dns_nameservers_search' => "Αναζήτηση DNS nameservers",
	'dns_nameservers_found' => "DNS nameservers που βρέθηκαν",
	'ip_range_edit' => "Επεξεργασία IP C-Class",
	'send_mail' => "Αποστολή ενημερωτικού E-mail",
	'to' => "Προς",
	'subject' => "Θέμα",
	'body' => "Μήνυμα",
	'mailto_all' => "Διαχειριστή & Συνδιαχειριστές",
	'mailto_owner' => "Διαχειριστή",
	'mailto_custom' => "Άλλους",
	'ip_ranges_allocation' => "Κατανομή διευθύνσεων IP",
	'ip_ranges_search' => "Αναζήτηση IP C-Classes",
	'change' => "Αλλαγή",
	'submit' => "OK",
	'add' => "Προσθήκη",
	'remove' => "Αφαίρεση",
	'update' => "Ανανέωση",
	'search' => "Αναζήτηση",
	'plot' => "Οπτική επαφή",
	'mynetwork' => "Το δίκτυο του κόμβου",
	'new_window' => "Νέο παράθυρο",
	'node_plot_link' => "Οπτική επαφή με άλλους κόμβους",
	'nodes_plot_link' => "Οπτική επαφή κόμβων",
	'nodes_plot_link_info' => "Επιλέξτε παραπάνω τους κόμβους για τους οποίους επιθυμείτε να ελέγξετε την οπτική επαφή.",
	'distance' => "Απόσταση",
	'azimuth' => "Αζιμούθιο",
	'elevation' => "Υψόμετρο",
	'fsl' => "Free space loss",
	'tilt' => "Κλίση",
	'clients' => "Πελάτες",
	'compare_equal' => "Ίσο με",
	'compare_greater' => "Μεγαλύτερο από",
	'compare_less' => "Μικρότερο από",
	'compare_greater_equal' => "Μεγαλύτερο ή ίσο με",
	'compare_less_equal' => "Μικρότερο ή ίσο με",
	'compare_starts_with' => "Ξεκινάει από",
	'compare_ends_with' => "Τελειώνει σε",
	'compare_contains' => "Περιέχει",
	'zone_forward' => "Forward ζώνη DNS",
	'zone_reverse' => "Reverse ζώνη DNS",
	'contact' => "Αποστολή μηνύματος",
	'contact_node' => "Επικοινωνία με τον κόμβο",
	'from' => "Από",
	'send' => "Αποστολή",
	'node_page' => "Σελίδα κόμβου",
	'yes' => "Ναι",
	'no' => "Όχι",
	'backbone' => "Backbone",
	'backbones_abbr' => "BBs",
	'unlinked' => "Ασύνδετοι",
	'find_coordinates' => "Βρείτε τις συντεταγμένες σας",
	'select_the_coordinates' => "Επιλογή των συντεταγμένων",
	'quick_search' => "Γρήγορη εύρεση",
	'statistics' => "Στατιστικά",
	'active_nodes' => "Ενεργοί κόμβοι",
	'backbone_nodes' => "Backbone κόμβοι",
	'null' => "(Κενό)",
	'default' => "Προεπιλεγμένη",
	'logged' => "Σύνδεση ως",
	'regions' => "Νομαρχίες",
	'region_add' => "Προσθήκη νομαρχίας",
	'region_edit' => "Επεξεργασία νομαρχίας",
	'areas' => "Δήμοι / Κοινότητες",
	'area_add' => "Προσθήκη δήμου / κοινότητας",
	'area_edit' => "Επεξεργασία δήμου / κοινότητας",

	'db' => array(
		'users__username' => 'Όνομα χρήστη',
		'users__password' => 'Κωδικός πρόσβασης',
		'users__password_c' => 'Επιβεβαίωση κωδικού',
		'users__surname' => 'Επώνυμο',
		'users__name' => 'Όνομα',
		'users__email' => 'E-mail',
		'users__phone' => 'Τηλέφωνο',
		'users__info' => 'Πληροφορίες',
		'users__status' => 'Εγγραφή',
		'users__status-pending' => 'Σε αναμονή',
		'users__status-activated' => 'Ενεργοποιημένη',
		'users__language' => 'Γλώσσα',
		'fullname' => 'Ονοματεπώνυμο',
		
		'nodes__id' => 'Αριθμός κόμβου',
		'nodes__name' => 'Όνομα κόμβου',
		'nodes__date_in' => 'Δημιουργήθηκε',
		'nodes__area_id' => 'Δήμος / Κοινότητα',
		'nodes__latitude' => 'Γεωγραφικό πλάτος (lat)',
		'nodes__longitude' => 'Γεωγραφικό μήκος (lon)',
		'nodes__elevation' => 'Ύψος κτιρίου (μ)',
		'nodes__info' => 'Πληροφορίες',
		'nodes__name_ns' => 'Πρόθεμα nameserver',
		
		'users_nodes__owner' => 'Δικαίωμα',
		'users_nodes__owner-Y' => 'Διαχειριστής',
		'users_nodes__owner-N' => 'Συνδιαχειριστής',
		'users_nodes__user_id' => 'Συνδιαχειριστές',
		'users_nodes__node_id' => 'Συνδιαχείριση κόμβων',
		'user_id_owner' => 'Διαχειριστής',
		'node_id_owner' => 'Διαχείριση κόμβων',

		'areas__id' => 'Δήμος / Κοινότητα',
		'areas__region_id' => 'Νομαρχία',
		'areas__name' => 'Δήμος / Κοινότητα',
		'areas__ip_start' => 'IP από',
		'areas__ip_end' => 'IP μέχρι',
		'areas__info' => 'Πληροφορίες',

		'regions__id' => 'Νομαρχία',
		'regions__name' => 'Νομαρχία',
		'regions__ip_start' => 'IP από',
		'regions__ip_end' => 'IP μέχρι',
		'regions__info' => 'Πληροφορίες',

		'ip_ranges__date_in' => 'Ημερομηνία',
		'ip_ranges__ip_start' => 'Από',
		'ip_ranges__ip_end' => 'Μέχρι',
		'ip_ranges__status' => 'Κατάσταση',
		'ip_ranges__status-waiting' => 'Προς έλεγχο',
		'ip_ranges__status-pending' => 'Σε αναμονή',
		'ip_ranges__status-active' => 'Ενεργό',
		'ip_ranges__status-rejected' => 'Απορριφθέν',
		'ip_ranges__status-invalid' => 'Άκυρο',
		'ip_ranges__info' => 'Πληροφορίες',
		'ip_ranges__delete_req' => 'Αίτηση διαγραφής',
		'ip_ranges__delete_req-Y' => 'ΝΑΙ',
		'ip_ranges__delete_req-N' => 'ΟΧΙ',
		'ip_range' => 'C Class',
		'ip' => 'Διεύθυνση IP',

		'dns_zones__date_in' => 'Ημερομηνία',
		'dns_zones__name' => 'Όνομα ζώνης',
		'dns_zones__type' => 'Τύπος ζώνης',
		'dns_zones__type-forward' => 'Forward',
		'dns_zones__type-reverse' => 'Reverse',
		'dns_zones__status' => 'Κατάσταση',
		'dns_zones__status-waiting' => 'Προς έλεγχο',
		'dns_zones__status-pending' => 'Σε αναμονή',
		'dns_zones__status-active' => 'Ενεργό',
		'dns_zones__status-rejected' => 'Απορριφθέν',
		'dns_zones__status-invalid' => 'Άκυρο',
		'dns_zones__info' => 'Πληροφορίες',

		'schema' => "Schema",

		'dns_zones_nameservers__nameserver_id' => 'Υπεύθυνοι Nameservers (NS)',

		'dns_nameservers__date_in' => 'Ημερομηνία',
		'dns_nameservers__name' => 'Όνομα Nameserver',
		'dns_nameservers__ip' => 'Διεύθυνση IP',
		'dns_nameservers__status' => 'Κατάσταση',
		'dns_nameservers__status-waiting' => 'Προς έλεγχο',
		'dns_nameservers__status-pending' => 'Σε αναμονή',
		'dns_nameservers__status-active' => 'Ενεργό',
		'dns_nameservers__status-rejected' => 'Απορριφθέν',
		'dns_nameservers__status-invalid' => 'Άκυρο',

		'links__date_in' => 'Δημιουργήθηκε',
		'links__peer_node_id' => 'Κόμβος διασύνδεσης',
		'links__peer_ap_id' => 'Access point',
		'links__type' => 'Τύπος διασύνδεσης',
		'links__type-p2p' => 'Backbone',
		'links__type-ap' => 'Access Point',
		'links__type-client' => 'Πελάτης',
		'links__ssid' => 'SSID',
		'links__protocol' => 'Πρωτόκολλο',
		'links__protocol-other' => 'Άλλο',
		'links__channel' => 'Κανάλι επικοινωνίας',
		'links__status' => 'Κατάσταση',
		'links__status-active' => 'Ενεργό',
		'links__status-inactive' => 'Ανενεργό',
		'links__equipment' => 'Εξοπλισμός',
		'links__info' => 'Πληροφορίες',
		'peer' => 'Διασύνδεση',
		'total_active_peers' => 'Ενεργές διασυνδέσεις',
		'total_active_p2p' => 'Ενεργές διασυνδέσεις backbone',
		'total_active_aps' => 'Ενεργά Access Point',
		'total_active_clients' => 'Ενεργοί πελάτες',
		'has_ap' => 'Διαθέτει Access Point',

		'subnets__ip_start' => 'Από',
		'subnets__ip_end' => 'Μέχρι',
		'subnets__type' => 'Χρήση υποδικτύου',
		'subnets__type-local' => 'Τοπικό δίκτυο',
		'subnets__type-link' => 'Διασύνδεση',
		'subnets__type-client' => 'Πελάτη Access Point',
		'subnets__link_id' => 'Διασύνδεση',
		'subnets__client_node_id' => 'Πελάτης',
		'subnet' => 'Υποδίκτυο',

		'ip_addresses__date_in' => 'Προστέθηκε',
		'ip_addresses__hostname' => 'Hostname',
		'ip_addresses__ip' => 'Διεύθυνση IP',
		'ip_addresses__mac' => 'Διεύθυνση MAC',
		'ip_addresses__type' => 'Τύπος μηχανήματος',
		'ip_addresses__type-router' => 'Δρομολογητής',
		'ip_addresses__type-server' => 'Διακομιστής',
		'ip_addresses__type-pc' => 'Η / Υ',
		'ip_addresses__type-wireless-bridge' => 'Ασύρματη συσκευή',
		'ip_addresses__type-voip' => 'Συσκευή VoIP',
		'ip_addresses__type-camera' => 'Κάμερα',
		'ip_addresses__type-other' => 'Άλλο',
		'ip_addresses__always_on' => 'Συνεχή λειτουργία (24/7)',
		'ip_addresses__always_on-Y' => 'ΝΑΙ',
		'ip_addresses__always_on-N' => 'ΟΧΙ',
		'ip_addresses__info' => 'Πληροφορίες',
	
		'services__title' => 'Κατηγορία',
		'services__protocol' => 'Πρωτόκολλο',
		'services__protocol-tcp' => 'TCP',
		'services__protocol-udp' => 'UDP',
		'services__port' => 'Πόρτα',

		'nodes_services__node_id' => 'Κόμβος',
		'nodes_services__service_id' => 'Κατηγορία',
		'nodes_services__date_in' => 'Προστέθηκε',
		'nodes_services__ip_id' => 'Διεύθυνση IP',
		'nodes_services__url' => 'URL',
		'nodes_services__status' => 'Κατάσταση',
		'nodes_services__status-active' => 'Ενεργή',
		'nodes_services__status-inactive' => 'Ανενεργή',
		'nodes_services__info' => 'Πληροφορίες',
		'nodes_services__protocol' => 'Πρωτόκολλο',
		'nodes_services__protocol-tcp' => 'TCP',
		'nodes_services__protocol-udp' => 'UDP',
		'nodes_services__port' => 'Πόρτα',
		
		'photos__date_in' => 'Ημερομηνία',
		'photos__view_point' => 'Κατεύθυνση',
		'photos__view_point-N' => 'Βόρεια',
		'photos__view_point-NE' => 'Βορειοανατολικά',
		'photos__view_point-E' => 'Ανατολικά',
		'photos__view_point-SE' => 'Νοτιοανατολικά',
		'photos__view_point-S' => 'Νότια',
		'photos__view_point-SW' => 'Νοτιοδυτικά',
		'photos__view_point-W' => 'Δυτικά',
		'photos__view_point-NW' => 'Βορειοδυτικά',
		'photos__view_point-PANORAMIC' => 'Πανοραμική',
		'photos__info' => 'Πληροφορίες',
		'photo' => 'Φωτογραφία',

		'rights__type' => 'Δικαιώματα',
		'rights__type-blocked' => 'Μπλοκαρισμένος',
		'rights__type-admin' => 'Διαχειριστής',
		'rights__type-hostmaster' => 'Hostmaster'
	),
	
	'message' => array(
		'info' => array(
			'insert_success' => array(
				'title' => "Εισαγωγή",
				'body' => "Η εισαγωγή ολοκληρώθηκε επιτυχώς."
			),
			'edit_success' => array(
				'title' => "Επεξεργασία",
				'body' => "Η επεξεργασία ολοκληρώθηκε επιτυχώς."
			),
			'delete_success' => array(
				'title' => "Διαγραφή",
				'body' => "Η διαγραφή ολοκληρώθηκε επιτυχώς."
			),
			'update_success' => array(
				'title' => "Ενημέρωση στοιχείων",
				'body' => "Η ενημέρωση των στοιχείων ολοκληρώθηκε επιτυχώς."
			),
			'request_range_success' => array(
				'title' => "Αίτηση IP C-Class",
				'body' => "Η αίτηση σας για IP C-Class έγινε δεκτή. Σύντομα, η ομάδα Hostmaster θα απαντήσει στην αίτησή σας στο e-mail που έχετε δηλώσει. Μπορείτε να δείτε το IP C-Class καθώς και την κατάστασή του στη σελίδα του κόμβου σας."
			),
			'request_dnszone_success' => array(
				'title' => "Αίτηση ζώνης DNS",
				'body' => "Η αίτηση σας για ζώνη DNS έγινε δεκτή. Σύντομα, η ομάδα Hostmaster θα απαντήσει στην αίτησή σας στο e-mail που έχετε δηλώσει. Μπορείτε να δείτε την κατάσταση της ζώνης DNS στη σελίδα του κόμβου σας."
			),
			'request_dnsnameserver_success' => array(
				'title' => "Αίτηση DNS nameserver",
				'body' => "Η αίτηση σας για DNS nameserver έγινε δεκτή. Σύντομα, η ομάδα Hostmaster θα ελέγξει την αίτησή σας. Μπορείτε να δείτε την κατάσταση του DNS nameserver στη σελίδα του κόμβου σας."
			),
			'signup_success' => array(
				'title' => "Η εγγραφή σας ολοκληρώθηκε",
				'body' => "Η εγγραφή σας ολοκληρώθηκε με επιτυχία. Ανατρέξτε στο e-mail σας, για το URL ενεργοποίησης του λογαριασμού σας."
			),
			'login_success' => array(
				'title' => "Επιτυχής σύνδεση",
				'body' => "Τα στοιχεία που δώσατε επιβεβαιώθηκαν."
			),
			'restore_success' => array(
				'title' => "Η ανάκτηση κωδικού ολοκληρώθηκε",
				'body' => "Η ανάκτηση του κωδικού σας ολοκληρώθηκε με επιτυχία. Ανατρέξτε στο e-mail σας, για το URL ανάκτησης κωδικού του λογαριασμού σας."
			),
			'password_restored' => array(
				'title' => "Αλλαγή κωδικού",
				'body' => "Ο κωδικός πρόσβασης αλλάχτηκε με επιτυχία. Μπορείτε να προχωρήσετε σε σύνδεση με το νέο σας κωδικό πρόσβασης."
			),	
			'logout_success' => array(
				'title' => "Αποσύνδεση",
				'body' => "Έγινε αποσύνδεση από το σύστημα."
			),
			'no_privilege' => array(
				'title' => "Χωρίς δικαίωμα πρόσβασης",
				'body' => "Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα."
			),
			'activation_required' => array(
				'title' => "Ενεργοποίηση λογαριασμού",
				'body' => "Δεν έχει γίνει ενεργοποίηση του λογαριασμού σας. Ανατρέξτε στο e-mail που δηλώσατε κατά την εγγραφή σας, για το URL ενεργοποίησης."
			),
			'activation_success' => array(
				'title' => "Ενεργοποίηση λογαριασμού",
				'body' => "Η ενεργοποίηση του λογαριασμού σας έγινε με επιτυχία. Μπορείτε να προχωρήσετε σε σύνδεση με το σύστημα."
			),
			'activation_failed' => array(
				'title' => "Ενεργοποίηση λογαριασμού",
				'body' => "Υπήρξε πρόβλημα στην ενεργοποίηση του λογαριασμού."
			),
			'message_sent' => array(
				'title' => "Το μήνυμα εστάλη",
				'body' => "Το μήνυμα εστάλη με επιτυχία. Πιθανή απάντηση στο μήνυμά σας θα αποσταλλεί από τους διαχειριστές του κόμβου, στον λογαριασμό e-mail που έχετε δηλώσει στο προφίλ σας."
			),
		),
		'error' => array(
			'database_error' => array(
				'title' => "Σφάλμα στη βάση δεδομένων",
				'body' => "Υπήρξε σφάλμα στην βάση δεδομένων κατά την εκτέλεση της ενέργειάς σας. Επικοινωνήστε με τον διαχειριστή του συστήματος για την αντιμετώπιση του προβλήματος."
			),
			'not_logged_in' => array(
				'title' => "Απαιτείται σύνδεση",
				'body' => "Για να πραγματοποίησε αυτή τη λειτουργία πρέπει να είστε συνδεδεμένος στο σύστημα. Αν δεν έχετε κάποιο λογαριασμό, μπορείτε να δημιουργήσετε έναν στην ενότητα εγγραφή."
			),
			'login_failed' => array(
				'title' => "Ανεπιτυχής σύνδεση",
				'body' => "Τα στοιχεία που δώσατε δεν επιβεβαιώθηκαν."
			),
			'password_not_match' => array(
				'title' => "Σφάλμα κωδικού",
				'body' => "Ο κωδικός που επιλέξατε δεν είναι ίδιος και στα δύο πεδία."
			),
			'password_not_valid' => array(
				'title' => "Σφάλμα κωδικού",
				'body' => "Ο κωδικός πρόσβασης δεν μπορεί να είναι κενός."
			),
			'fields_required' => array(
				'title' => "Υποχρεωτικά πεδία",
				'body' => "Δεν δώσατε τα ακόλουθα πεδία που είναι υποχρεωτικά:\n##fields_required##"
			),
			'duplicate_entry' => array(
				'title' => "Η καταχώρηση υπάρχει ήδη",
				'body' => "Το ακόλουθα στοιχεία της καταχώρησής σας υπάρχουν ήδη:\n##duplicate_entries##"
			),
			'upload_file_failed' => array(
				'title' => "Εισαγωγή αρχείου",
				'body' => "Υπήρξε πρόβλημα κατά την εισαγωγή του αρχείου. Για περισσότερες λεπτομέρειες, επικοινωνήστε με τους διαχειριστές του συστήματος."
			),
			'nodes_field_name' => array(
				'title' => 'Αλλαγή ονόματος κόμβου',
				'body' => 'Δεν επιτρέπεται η αλλαγή ονόματος του κόμβου.'
			),
			'nodes_no_area_id' => array(
				'title' => 'Σφάλμα δήμου/κοινότητας κόμβου',
				'body' => 'Δεν έχετε δηλώσει τον δήμο/κοινότητα που ανήκει ο κόμβος. Για την απόδοση IP C-Classes απαιτείται η δήλωση δήμου/κοινότητας. Ανατρέξτε στα στοιχεία του κόμβου σας.'
			),
			'subnet_backbone_no_ip_range' => array(
				'title' => 'Προσθήκη υποδικτύου σε διασύνδεση',
				'body' => 'Το υποδίκτυο που δηλώσατε, δεν ανήκει σε κάποιο IP C-Class που σας έχει αποδοθεί. Αν το υποδίκτυο ανήκει στον κόμβο του άλλου άκρου της διασύνδεσης, θα πρέπει να το δηλώσει ο κάτοχος του IP C-Class.'
			),
			'schema_files_missing' => array(
				'title' => 'Τα αρχεία schema δεν βρέθηκαν',
				'body' => 'Παρακαλώ, επικοινωνήστε με τον διαχειριστή του συστήματος για τη διόρθωση του σφάλματος.'
			),
			'gmap_key_failed' => array(
				'title' => 'Το κλειδί δεν βρέθηκε',
				'body' => 'Δεν βρέθηκε το κλειδί ενεργοποίησης του Google Maps. Επικοινωνήστε με τον διαχειριστή του συστήματος για την επίλυση του προβλήματος.'
			),
			'node_not_found' => array(
				'title' => 'Ο κόμβος δεν βρέθηκε',
				'body' => 'Ο κόμβος που ζητήσατε δεν υπάρχει. Ελέγξτε τα στοιχεία και προσπαθήστε ξανά. Αν τα στοιχεία είναι σωστά, είναι πιθανό ο κόμβος να έχει διαγραφεί ή ο χρήστης να μην έχει πραγματοποιήσει ενεργοποίηση του λογαριασμού.'
			),
			'zone_invalid_name' => array(
				'title' => 'Μη έγκυρο όνομα ζώνης',
				'body' => 'Το όνομα ζώνης που δηλώσατε περιέχει μη έγκυρους χαρακτήρες.'
			),
			'zone_out_of_range' => array(
				'title' => 'Όνομα ζώνης εκτός C-Class',
				'body' => 'Το όνομα ζώνης που δηλώσατε δεν αντιστοιχεί σε κανένα από τα C-Classes που σας έχουν αποδοθεί.'
			),
			'zone_reserved_name' => array(
				'title' => 'Δεσμευμένο όνομα ζώνης',
				'body' => 'Το όνομα ζώνης που δηλώσατε είναι δεσμευμένο από το σύστημα.'
			),
			'generic' => array(
				'title' => "Γενικό σφάλμα",
				'body' => "Υπήρξε γενικό σφάλμα. Παρακαλώ ενημερώστε τους διαχειριστές του συστήματος."
			)
		)
	),
		
	'email' => array(
		'user_activation' => array(
			'subject' => "Ενεργοποίηση λογαριασμού: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\nΕνεργοποίηση λογαριασμού ##username##\n\nΠατήστε εδώ: ##act_link##"
		),

		'user_restore' => array(
			'subject' => "Ανάκτηση κωδικού: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΑνάκτηση κωδικού για το λογαριασμό ##username##\n\nΠατήστε εδώ: ##act_link##"
		),

		'user_change_email' => array(
			'subject' => "Αλλαγή e-mail λογαριασμού: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΑλλαγή e-mail λογαριασμού ##username##\n\nΠατήστε εδώ: ##act_link##"
		),

		'node_contact' => array(
			'subject_prefix' => "WiND: ",
			'subject_suffix' => "",
			'body_prefix' => "Επικοινωνία με τους διαχειριστές του κόμβου ##node_name## (###node_id##).\nΟ χρήστης ##username## σας έστειλε το παρακάτω μήνυμα\nμέσω της εφαρμογής WiND - Wireless Nodes Database:\n-------------------------------------------------------------------\n\n",
			'body_suffix' => "\n\n-------------------------------------------------------------------\nΑπαντήστε σε αυτό το μήνυμα για να επικοινωνήσετε με τον αποστολέα.\nWiND - Wireless Nodes Database\n-------------------------------------------------------------------"
		),

		'range' => array(
			'pending' => array(
				'subject' => "##range##: Σε αναμονή",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class μπήκε σε κατάσταση αναμονής.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'active' => array(
				'subject' => "##range##: Ενεργοποιήθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class ενεργοποιήθηκε.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'rejected' => array(
				'subject' => "##range##: Απορρίφθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class απορρίφθηκε.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'invalid' => array(
				'subject' => "##range##: Ακυρώθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class ακυρώθηκε.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			)
		),
		
		'zone' => array(
			'pending' => array(
				'subject' => "##zone##: Σε αναμονή",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΖώνη DNS: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone μπήκε σε κατάσταση αναμονής.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'active' => array(
				'subject' => "##zone##: Ενεργοποιήθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΖώνη DNS: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone ενεργοποιήθηκε.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'rejected' => array(
				'subject' => "##zone##: Απορρίφθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΖώνη DNS: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone απορρίφθηκε.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			),
			'invalid' => array(
				'subject' => "##zone##: Ακυρώθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΖώνη DNS: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone ακυρώθηκε.\n\nΕκ μέρους της ομάδας WiND Hostmaster,\n##hostmaster_surname## ##hostmaster_name## (##hostmaster_username##)"
			)
		)
	),
	
	'help' => array(
		'dnszones' => array(
			'title' => 'Ζώνες DNS',
			'body' => 'Στη σελίδα αυτή μπορείτε να αναζητήσετε ζώνες DNS του δικτύου, με βάση τα πεδία που προσφέρονται. Τα αποτελέσματα εμφανίζονται στον παρακάτω πίνακα. Επίσης, μπορείτε να διαλέξετε κάποιον κόμβο για προβολή των στοιχείων του.'
		),
		
		'services' => array(
			'title' => 'Υπηρεσίες',
			'body' => 'Στη σελίδα αυτή μπορείτε να αναζητήσετε υπηρεσίες του δικτύου, με βάση τα πεδία που προσφέρονται. Τα αποτελέσματα εμφανίζονται στον παρακάτω πίνακα. Επίσης, μπορείτε να μεταφερθείτε σε κάποια υπηρεσία (αν προσφέρεται URL) ή να επιλέξετε κάποιον κόμβο για προβολή των στοιχείων του.'
		),
		
		'mynodes_add' => array(
			'title' => 'Προσθήκη κόμβου',
			'body' => 'Στη σελίδα αυτή μπορείτε να προσθέσετε έναν κόμβο. Φροντίστε τα στοιχεία να καταχωρηθούν με όσο το δυνατόν μεγαλύτερη ακρίβεια.'
		),
		'mynodes' => array(
			'title' => 'Διαχείριση κόμβου',
			'body' => 'Στη σελίδα αυτή μπορείτε να διαχειριστείτε πλήρως τον κόμβο σας. Φροντίστε τα στοιχεία να καταχωρηθούν με όσο το δυνατόν μεγαλύτερη ακρίβεια. Στις επιμέρους κατηγορίες, ανατρέξτε στη βοήθεια της κάθε σελίδας.'
		),
		'mynodes_range' => array(
			'title' => 'Αίτηση απόδοσης IP C-Class',
			'body' => 'Περιγράψτε με σαφήνεια, στο πεδίο Πληροφορίες τον λόγο της αίτησής σας.'
		),
		'mynodes_dnszone_request_reverse' => array(
			'title' => 'Αίτηση απόδοσης ζώνης DNS',
			'body' => 'Περιγράψτε με σαφήνεια στο πεδίο Πληροφορίες τον λόγο της αίτησής σας.'
		),
		'mynodes_dnszone_request_forward' => array(
			'title' => 'Αίτηση απόδοσης ζώνης DNS',
			'body' => 'Περιγράψτε με σαφήνεια στο πεδίο Πληροφορίες τον λόγο της αίτησής σας.'
		),
		'mynodes_dnszone_edit' => array(
			'title' => 'Επεξεργασία ζώνης DNS',
			'body' => 'Στη σελίδα αυτή μπορείτε να ορίσετε τους υπεύθυνους nameservers (NS) που θα διατηρούν τις πληροφορίες της ζώνης.'
		),
		'mynodes_dnsnameserver_add' => array(
			'title' => 'Προσθήκη nameserver (NS)',
			'body' => 'Δώστε το όνομα και τη διεύθυνση του nameserver.'
		),
		'mynodes_dnsnameserver_edit' => array(
			'title' => 'Επεξεργασία nameserver (NS)',
			'body' => 'Στη σελίδα αυτή μπορείτε να επεξεργαστείτε το όνομα του nameserver (NS) που διατηρείτε. Αλλαγή της διεύθυνσης IP δεν είναι εφικτή, θα πρέπει να κάνετε αίτηση διαγραφής του υπάρχοντος nameserver και αίτηση καταχώρησης νέου.'
		),
		'mynodes_link_add' => array(
			'title' => 'Προσθήκη διασύνδεσης',
			'body' => 'Στη σελίδα αυτή μπορείτε να προσθέσετε μια διασύνδεση του κόμβου σας με κάποιον άλλο κόμβο. Συμπληρώστε με σαφήνεια όσο το δυνατόν περισσότερα από τα πεδία.'
		),
		'mynodes_link_edit' => array(
			'title' => 'Επεξεργασία διασύνδεσης',
			'body' => 'Στη σελίδα αυτή μπορείτε να επεξεργαστείτε μια διασύνδεση του κόμβου σας με κάποιον άλλο κόμβο. Συμπληρώστε με σαφήνεια όσο το δυνατόν περισσότερα από τα πεδία.'
		),
		'mynodes_subnet_add' => array(
			'title' => 'Προσθήκη υποδικτύου',
			'body' => 'Στη σελίδα αυτή μπορείτε να προσθέσετε ένα υποδίκτυο του κόμβου σας. Για το τοπικό σας δίκτυο μπορείτε να δηλώσετε και διευθύνσεις που δεν περιέχονται σε IP C-Class που σας έχει αποδοθεί. Σε περίπτωση διασυνδέσεων κόμβων, δήλωση ενός υποδικτύου μπορεί να γίνει μόνο από τον κάτοχο του IP C-Class του υποδικτύου που χρησιμοποιείται.'
		),
		'mynodes_subnet_edit' => array(
			'title' => 'Επεξεργασία υποδικτύου',
			'body' => 'Στη σελίδα αυτή μπορείτε να επεξεργαστείτε ένα υποδίκτυο του κόμβου σας.'
		),
		'mynodes_ipaddr_add' => array(
			'title' => 'Προσθήκη διεύθυνσης IP',
			'body' => 'Στη σελίδα αυτή μπορείτε να προσθέσετε μία διεύθυνση IP του κόμβου σας. Το πεδίο Hostname, πρέπει να καθορίζει ποιο μηχάνημα φέρει τη συγκεκριμένη διεύθυνση IP και πρέπει να είναι κοινό σε όλες τις διευθύνσεις IP του συγκεκριμένου μηχανήματος.'
		),
		'mynodes_ipaddr_edit' => array(
			'title' => 'Επεξεργασία διασύνδεσης',
			'body' => 'Στη σελίδα αυτή μπορείτε να επεξεργαστείτε μία διεύθυνση IP του κόμβου σας. Το πεδίο Hostname, πρέπει να καθορίζει ποιο μηχάνημα φέρει τη συγκεκριμένη διεύθυνση IP και πρέπει να είναι κοινό σε όλες τις διευθύνσεις IP του συγκεκριμένου μηχανήματος.'
		),
		
		'mynodes_services_add' => array(
			'title' => 'Προσθήκη υπηρεσίας',
			'body' => 'Στη σελίδα αυτή μπορείτε να προσθέσετε μία υπηρεσία του κόμβου σας. Το πεδίο Διεύθυνση IP περιέχει όλες τις διευθύνσεις που έχετε δηλώσει και πρέπει να καθορίζει την IP στην οποία τρέχει (ακούει) η υπηρεσία. Το πεδίο URL, πρέπει να περιέχει το link για την υπηρεσία ή το link για κάποια σελίδα που αναφέρεται στην υπηρεσία. Τέλος τα πεδία Πρωτόκολλο και Πόρτα, πρέπει να αναφέρονται στο πρωτόκολλο που χρησιμοποιεί η υπηρεσία (π.χ. tcp, udp) και στην πόρτα που ακούει.'
		),
		'mynodes_services_edit' => array(
			'title' => 'Επεξεργασία υπηρεσίας',
			'body' => 'Στη σελίδα αυτή μπορείτε να επεξεργαστείτε μία υπηρεσία του κόμβου σας. Το πεδίο Διεύθυνση IP περιέχει όλες τις διευθύνσεις που έχετε δηλώσει και πρέπει να καθορίζει την IP στην οποία τρέχει (ακούει) η υπηρεσία. Το πεδίο URL, πρέπει να περιέχει το link για την υπηρεσία ή το link για κάποια σελίδα που αναφέρεται στην υπηρεσία. Τέλος τα πεδία Πρωτόκολλο και Πόρτα, πρέπει να αναφέρονται στο πρωτόκολλο που χρησιμοποιεί η υπηρεσία (π.χ. tcp, udp) και στην πόρτα που ακούει.'
		),
		
		'nodes_search' => array(
			'title' => 'Κόμβοι δικτύου',
			'body' => 'Στη σελίδα αυτή μπορείτε να αναζητήσετε κόμβους του δικτύου με βάση τα πεδία που προσφέρονται. Τα αποτελέσματα εμφανίζονται στον παρακάτω πίνακα. Επίσης, μπορείτε να διαλέξετε κάποιον κόμβο για προβολή των στοιχείων του.'
		),
		'ranges_allocation' => array(
			'title' => 'Κατανομή διευθύνσεων IP',
			'body' => 'Στη σελίδα αυτή μπορείτε να δείτε αναλυτικά το σύνολο των διευθύνσεων που έχουν δεσμευτεί για κάθε δήμο.'
		),
		'ranges_search' => array(
			'title' => 'Αναζήτηση IP C-Classes',
			'body' => 'Στη σελίδα αυτή μπορείτε να αναζητήσετε τα IP C-Classes του δικτύου που έχουν δεσμευτεί από κόμβους. Τα αποτελέσματα εμφανίζονται στον παρακάτω πίνακα. Επίσης, μπορείτε να διαλέξετε κάποιον κόμβο για προβολή των στοιχείων του.'
		),
		'users_restore_password_recover' => array(
			'title' => 'Ανάκτηση κωδικού',
			'body' => 'Στη σελίδα αυτή μπορείτε να ανακτήσετε τον χαμένο κωδικό πρόσβασης για τον λογαριασμό σας. Εισάγετε τα ακόλουθα πεδία στη φόρμα και θα λάβετε e-mail με αναλυτικές οδηγίες.'
		),
		'users_restore_password_change' => array(
			'title' => 'Αλλαγή κωδικού πρόσβασης',
			'body' => 'Στη σελίδα αυτή μπορείτε να αλλάξετε τον χαμένο κωδικό πρόσβασης του λογαριασμού σας. Δώστε έναν νέο κωδικό πρόσβασης στη φόρμα που ακολουθεί και θα μπορέσετε άμεσα να πραγματοποιήσετε σύνδεση στον λογαριασμό σας με τον νέο κωδικό πρόσβασης.'
		),
		'users_add' => array(
			'title' => 'Εγγραφή νέου χρήστη',
			'body' => 'Δηλώστε τα στοιχεία σας στη φόρμα που ακολουθεί. Για την επιβεβαίωση του e-mail σας και την ενεργοποίηση του λογαριασμού σας, θα σας αποσταλεί  e-mail με αναλυτικές οδηγίες στη διεύθυνσή σας. Μέχρι την ενεργοποίησή του, ο λογαριασμός σας θα παραμείνει ανενεργός χωρίς δυνατότητα σύνδεσης στο σύστημα.'
		),
		'users_edit' => array(
			'title' => 'Προφίλ χρήστη',
			'body' => 'Στη σελίδα αυτή μπορείτε να επεξεργαστείτε τα στοιχεία σας. Σε περίπτωση αλλαγής διεύθυνσης e-mail θα σας αποσταλεί μήνυμα e-mail με αναλυτικές οδηγίες ενεργοποίησης στη νέα διεύθυνση που θα δηλώσετε.'
		),
		'node_contact' => array(
			'title' => 'Αποστολή μηνύματος',
			'body' => 'Στη σελίδα αυτή μπορείτε να αποστείλετε μήνυμα προς τον διαχειριστή ή και τους συνδιαχειριστές του κόμβου. Η ηλεκτρονική σας διεύθυνση θα είναι διαθέσιμη στο απεσταλμένο μήνυμα ώστε να είναι εφικτή η πιθανή απάντηση στο μήνυμά σας από τους παραλήπτες. Οι ηλεκτρονικές διευθύνσεις των παραληπτών θα αποκαλυφθούν κατά την απάντηση του μηνύματος. Η πιθανή απάντηση στο μήνυμά σας θα σας αποσταλεί στο ηλεκτρονικό σας ταχυδρομείο.'
		)
	),
	
	'languages' => array(
		'greek' => 'Ελληνικά',
		'english' => 'Αγγλικά'
	)

);

?>
