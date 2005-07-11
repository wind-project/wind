<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
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

setlocale(LC_ALL, 'ell');

$lang = array(

	'charset' => 'iso-8859-7',
	
	'site_title' => "WiND - Wireless Nodes Database",
	
	'forward_text' => "Αν δεν επιθυμείτε να περιμένετε πατήστε εδώ...",
	
	'delete_request' => "Αίτηση διαγραφής",
	
	'delete' => "Διαγραφή",
	'home' => "Αρχική σελίδα",
	'edit_profile' => "Προφίλ χρήστη",
	'log_out' => "Αποσύνδεση",
	'login' => "Σύνδεση",
	'register' => "Εγγραφή",
	'password_recover' => "Ανάκτηση κωδικού",
	'password_change' => "Αλλαγή κωδικού",
	'all_nodes' => "Κόμβοι δικτύου",
	'all_zones' => "DNS Zones",
	'all_ranges' => "Διευθυνσιοδότηση",
	'user_info' => "Στοιχεία χρήστη",
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
	'dns_zones' => "DNS zones",
	'dns_nameservers' => "DNS nameservers",
	'pending' => "σε αναμονή",
	'for_deletion' => "για διαγραφή",
	'welcome' => "Καλώς ήρθατε",
	'nodes_search' => "Αναζήτηση κόμβων",
	'nodes_found' => "Κόμβοι που βρέθηκαν",
	'users_search' => "Αναζήτηση χρηστών",
	'users_found' => "Χρήστες που βρέθηκαν",
	'dns_zones_search' => "Αναζήτηση DNS zone",
	'dns_zones_found' => "DNS zones που βρέθηκαν",
	'user_add' => "Εγγραφή νέου χρήστη",
	'user_edit' => "Προφίλ χρήστη",
	'node' => "Κόμβος",
	'node_info' => "Στοιχεία κόμβου",
	'node_delete' => "Διαγραφή κόμβου",
	'ip_range_request' => "Αίτηση απόδοσης IP C-Class",
	'ip_range_request_for_node' => "Αίτηση απόδοσης IP C-Class για τον κόμβο",
	'dnszone_request_forward' => "Αίτηση απόδοσης DNS zone (forward)",
	'dnszone_request_reverse' => "Αίτηση απόδοσης DNS zone (reverse)",
	'dnszone_edit' => "Επεξεργασία DNS zone",
	'nameserver_add' => "Προσθήκη nameserver (NS)",
	'nameserver_edit' => "Επεξεργασία nameserver (NS)",
	'link_edit' => "Επεξεργασία διασύνδεσης",
	'link_add' => "Προσθήκη διασύνδεσης",
	'links' => "Διασυνδέσεις",
	'ap' => "Access Point",
	'aps' => "Access Points",
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
	'to' => "Πρός",
	'subject' => "Θέμα",
	'body' => "Μήνυμα",
	'mailto_all' => "Διαχειριστή & Συνδιαχειριστές",
	'mailto_owner' => "Διαχειριστή",
	'mailto_custom' => "Άλλους",
	'ip_ranges_allocation' => "Κατανομή διευθύνσεων IP",
	'ip_ranges_search' => "Αναζήτηση IP C-Classes",
	'change' => "Αλλαγή",
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
	'compare_equal' => "Ισούται με",
	'compare_greater' => "Μεγαλύτερο από",
	'compare_less' => "Μικρότερο από",
	'compare_greater_equal' => "Μεγαλύτερο ή ίσο με",
	'compare_less_equal' => "Μικρότερο ή ίσο με",
	'compare_starts_with' => "Ξεκινάει από",
	'compare_ends_with' => "Τελειώνει σε",
	'compare_contains' => "Περιέχει",
	'' => "",
	

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
		'fullname' => 'Ονοματεπώνυμο',
		
		'nodes__id' => 'Αριθμός κόμβου',
		'nodes__name' => 'Όνομα κόμβου',
		'nodes__date_in' => 'Δημιουργήθηκε',
		'nodes__area_id' => 'Δήμος / Κοινότητα',
		'nodes__latitude' => 'Γεωγραφικό πλάτος (lat)',
		'nodes__longitude' => 'Γεωγραφικό μήκος (log)',
		'nodes__elevation' => 'Υψόμετρο',
		'nodes__info' => 'Πληροφορίες',
		'nodes__name_ns' => 'Πρόθεμα nameserver',

		'users_nodes__user_id' => 'Συνδιαχειριστές',
		'user_id_owner' => 'Διαχειριστής',

		'areas__id' => 'Δήμος / Κοινότητα',
		'areas__name' => 'Δήμος / Κοινότητα',

		'regions__id' => 'Νομαρχία',
		'regions__name' => 'Νομαρχία',

		'ip_ranges__date_in' => 'Ημερομηνία',
		'ip_ranges__ip_start' => 'Από',
		'ip_ranges__ip_end' => 'Μέχρι',
		'ip_ranges__status' => 'Κατάσταση',
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
		'dns_zones__status-pending' => 'Σε αναμονή',
		'dns_zones__status-active' => 'Ενεργό',
		'dns_zones__status-rejected' => 'Απορριφθέν',
		'dns_zones__status-invalid' => 'Άκυρο',
		'dns_zones__info' => 'Πληροφορίες',
		'dns_zones__delete_req' => 'Αίτηση διαγραφής',
		'dns_zones__delete_req-Y' => 'ΝΑΙ',
		'dns_zones__delete_req-N' => 'ΟΧΙ',

		'dns_zones_nameservers__nameserver_id' => 'Υπεύθυνοι Nameservers (NS)',

		'dns_nameservers__date_in' => 'Ημερομηνία',
		'dns_nameservers__name' => 'Όνομα Nameserver',
		'dns_nameservers__delete_req' => 'Αίτηση διαγραφής',
		'dns_nameservers__delete_req-Y' => 'ΝΑΙ',
		'dns_nameservers__delete_req-N' => 'ΟΧΙ',
		'dns_nameservers__ip' => 'Διεύθυνση IP',
		'dns_nameservers__status' => 'Κατάσταση',
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
		'total_active_clients' => 'Ενεργοί πελάτες',

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
		'rights__type-hostmaster' => 'Hostmaster',
		
		'' => '',
		'' => '',
		'' => '',
		'' => ''
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
				'body' => "Η αίτηση σας για IP C-Class έγινε δεκτή. Σύντομα η ομάδα hostmaster θα απαντήσει στην αίτησή σας στο e-mail που έχετε δηλώσει. Μπορείται να δείτε το IP C-Class καθώς και την κατάστασή του στη σελίδα του κόμβου σας."
			),
			'request_dnszone_success' => array(
				'title' => "Αίτηση DNS zone",
				'body' => "Η αίτηση σας για DNS zone έγινε δεκτή. Σύντομα η ομάδα hostmaster θα απαντήσει στην αίτησή σας στο e-mail που έχετε δηλώσει. Μπορείται να δείτε την κατάστασή του DNS zone στη σελίδα του κόμβου σας."
			),
			'request_dnsnameserver_success' => array(
				'title' => "Αίτηση DNS nameserver",
				'body' => "Η αίτηση σας για DNS nameserver έγινε δεκτή. Σύντομα η ομάδα hostmaster θα ελέγξει την αίτησή σας. Μπορείται να δείτε την κατάστασή του DNS nameserver στη σελίδα του κόμβου σας."
			),
			'signup_success' => array(
				'title' => "Η εγγραφή σας ολοκλώθηκε",
				'body' => "Η εγγραφή σας ολοκλώθηκε με επιτυχία. Ανατρέξτε στο e-mail σας για το URL ενεργοποίησεις του λογαριασμού σας."
			),
			'login_success' => array(
				'title' => "Επιτυχής σύνδεση",
				'body' => "Τα στοιχεία που δώσατε επιβεβαιώθηκαν."
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
				'body' => "Δεν έχει γίνει ενεργοποίηση του λογαριασμού σας. Ανατρέξτε στο e-mail που δηλώσατε κατά την εγγραφή σας για το URL ενεργοποίησης."
			),
			'activation_success' => array(
				'title' => "Ενεργοποίηση λογαριασμού",
				'body' => "Η ενεργοποίηση του λογαριασμού σας έγινε με επιτυχία. Μπορείτε να προχωρήσετε σε σύνδεση με το σύστημα."
			),
			'activation_failed' => array(
				'title' => "Ενεργοποίηση λογαριασμού",
				'body' => "Υπήρξε πρόβλημα στην ενεργοποίηση του λογαριασμού."
			)
		),
		'error' => array(
			'login_failed' => array(
				'title' => "Ανεπιτυχής σύνδεση",
				'body' => "Τα στοιχεία που δώσατε δεν επιβεβαιώθηκαν."
			),
			'password_not_match' => array(
				'title' => "Σφάλμα κωδικού",
				'body' => "Ο κωδικός που επιλέξατε δεν είναι ίδιος στα δύο πεδία."
			),
			'password_not_valid' => array(
				'title' => "Σφάλμα κωδικού",
				'body' => "Ο κωδικός που επιλέξατε δεν πληρή "
			),
			'fields_required' => array(
				'title' => "Υποχρεωτικά πεδία",
				'body' => "Δεν δώσατε τα ακόλουθα πεδία που είναι υποχρεωτικά: ##fields_required##"
			),
			'upload_file_failed' => array(
				'title' => "Εισαγωγή αρχείου",
				'body' => "Υπήρξε πρόβλημα κατά την εισαγωγή του αρχείου. Επικοινωνήστε με τον διαχειριστή του συστήματος."
			),
			'nodes_field_name' => array(
				'title' => 'Αλλαγή ονόματος κόμβου',
				'body' => 'Δεν επιτρέπεται η αλλαγή του ονόματος του κόμβου.'
			),
			'nodes_field_area_id' => array(
				'title' => 'Αλλαγή δήμου/κοινότητας κόμβου',
				'body' => 'Δεν επιτρέπεται η αλλαγή της περιοχής του κόμβου. Σας έχουν αποδοθεί IP C-Classes. Επικοινωνήστε με την ομάδα hostmaster.'
			),
			'subnet_backbone_no_ip_range' => array(
				'title' => 'Προσθήκη υποδικτύου σε διασύνδεση',
				'body' => 'Το υποδίκτυο που δώσατε δεν ανήκει σε κάποιο IP C-Class που σας έχει αποδωθεί. Αν το υποδίκτυο ανήκει στον κόμβο του άλλου άκρου της διασύνδεσης, θα πρέπει να το δηλώσει ο κάτοχος του IP C-Class.'
			),
			'generic' => array(
				'title' => "Γενικό σφάλμα",
				'body' => "Υπήρξε γενικό. Αναφέρεται το πρόβλημα στη διαχείριση του συστήματος."
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

		'user_change_mail' => array(
			'subject' => "Αλλαγή e-mail λογαριασμού: ##username##",
			'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nΑλλαγή e-mail λογαριασμού ##username##\n\nΠατήστε εδώ: ##act_link##"
		),

		'range' => array(
			'pending' => array(
				'subject' => "##range##: Σε αναμονή",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class μπήκε σε κατάσταση αναμονής.\n\nΗ ομάδα WiND Hostmaster"
			),
			'active' => array(
				'subject' => "##range##: Ενεργοποιήθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class ενεργοποιήθηκε.\n\nΗ ομάδα WiND Hostmaster"
			),
			'rejected' => array(
				'subject' => "##range##: Απορρίφθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class απορρίφθηκε.\n\nΗ ομάδα WiND Hostmaster"
			),
			'invalid' => array(
				'subject' => "##range##: Ακυρώθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nIP C-Class: ##range##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω IP C-Class ακυρώθηκε.\n\nΗ ομάδα WiND Hostmaster"
			)
		),
		
		'zone' => array(
			'pending' => array(
				'subject' => "##zone##: Σε αναμονή",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone μπήκε σε κατάσταση αναμονής.\n\nΗ ομάδα WiND Hostmaster"
			),
			'active' => array(
				'subject' => "##zone##: Ενεργοποιήθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone ενεργοποιήθηκε.\n\nΗ ομάδα WiND Hostmaster"
			),
			'rejected' => array(
				'subject' => "##zone##: Απορρίφθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone απορρίφθηκε.\n\nΗ ομάδα WiND Hostmaster"
			),
			'invalid' => array(
				'subject' => "##zone##: Ακυρώθηκε",
				'body' => "WiND - Wireless Nodes Database\n------------------------------------------\n\nDNS zone: ##zone##\nΚόμβος: ##node_name## (###node_id##)\n\nΤο παραπάνω DNS zone ακυρώθηκε.\n\nΗ ομάδα WiND Hostmaster"
			)
		)
	),
	
	'help' => array(
		'nodes_search' => array(
			'title' => 'Κόμβοι δικτύου',
			'body' => 'Στη σελίδα αυτή μπορείτε να αναζητήσετε κόμβους του δικτύου με βάση τα πεδία που προσφέρονται. Τα αποτελέσματα εμφανίζονται στον παρακάτω πίνακα. Επίσης, μπορείτε να διαλέξετε κάποιον κόμβο για προβολή των στοιχείων του.'
		)
	)

);

?>
