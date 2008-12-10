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

class table {
	
	var $info=array();
	var $data=array();
	
	function table($info="") {
		if (is_array($info)) $this->info = $info;
	}
	
	function db_data($select, $from, $where="", $group_by="", $order_by="", $limit="") {
		global $db, $vars;
		if ($limit == '' && $limit !== FALSE) {
			if ((!isset($this->info['CURRENT_PAGE']) || $this->info['CURRENT_PAGE'] == '') && $_SERVER['REQUEST_METHOD'] == 'GET') $this->info['CURRENT_PAGE'] = get($this->info['TABLE_NAME']."_showpage");
			if ( !isset($this->info['CURRENT_PAGE']) || $this->info['CURRENT_PAGE'] == '') $this->info['CURRENT_PAGE'] = 1;
			$page = $this->info['CURRENT_PAGE'];
			$limit = (($page-1)*$vars['constructor']['max_rows']).', '.$vars['constructor']['max_rows'];
			$want_pages = true;
			}
		$data = $db->get("SQL_CALC_FOUND_ROWS ".$select, $from, $where, $group_by, $order_by, $limit);
		if (isset($want_pages)) {
			$cnt = $db->query_data("SELECT FOUND_ROWS()");
			$cnt = $cnt[0]['FOUND_ROWS()'];
			if ($vars['constructor']['max_rows'] != '' && $cnt > $vars['constructor']['max_rows']) {
				$this->info['TOTAL_PAGES'] = ceil($cnt / $vars['constructor']['max_rows']);
				for ($i=1;$i<=$this->info['TOTAL_PAGES'];$i++) {
					$this->info['PAGES'][$i] = makelink(array($this->info['TABLE_NAME']."_showpage" => $i), TRUE);
				}
			}
		}
		$isset = FALSE;
		if (isset($data[0])) {
			$isset = TRUE;
			array_unshift($data, $data[0]);
			while (list($key, $value) = each($data[0])) {
				$data[0][$key] = $key;
			}
		}
		$a = explode(",", $select);
		for($i=0;$i<count($a);$i++) {
			$f = explode(" AS ", $a[$i]);
			if (!isset($f[1])) {
				$f = explode(".", $f[0]);
				if (!isset($f[1])) {
					$t = explode(",", trim($from), 1);
					$t = explode(" ", $t[0], 1);
					$f = trim($t[0])."__".trim($f[0]);
					$fkey = trim($f[0]);
				} else {
					$fkey = trim($f[1]);
					$f = trim($f[0])."__".trim($f[1]);
				}
			} else {
				$f = trim($f[1]);
				$fkey = $f;
			}
			if (isset($data[0][$fkey]) || ($isset !== TRUE && !isset($data[0][$fkey]))) $data[0][$fkey] = $f;
		}
		if (!isset($this->data[0])) {
			$this->data[0] = array();		
		} 
		$this->data[0] = array_merge($this->data[0], $data[0]);
		unset($data[0]);
		$this->data = array_merge($this->data, $data);
	}
	
	function db_data_search($form) {
		$sc = unserialize(stripslashes(get($form->info['FORM_NAME'].'_search')));
		for ($i=0;$i<count($form->data);$i++) {
			if (isset($form->data[$i])) {
				$sf = isset($sc[$form->data[$i]['fullField']])?$sc[$form->data[$i]['fullField']]:'';
				$search[$form->data[$i]['fullField']] = (isset($_POST[$form->data[$i]['fullField']])?$_POST[$form->data[$i]['fullField']]:$sf);
				if (isset($form->data[$i]['Compare'])) {
					$sf_cmp = isset($sc[$form->data[$i]['fullField'].'_compare'])?$sc[$form->data[$i]['fullField'].'_compare']:'';
					$search[$form->data[$i]['fullField'].'_compare'] = (isset($_POST[$form->data[$i]['fullField'].'_compare']) ? $_POST[$form->data[$i]['fullField'].'_compare'] : $sf_cmp);
				}
			}
		}
		$search = serialize($search);
		if (isset($this->info['TOTAL_PAGES'])) {
			for ($i=1;$i<=$this->info['TOTAL_PAGES'];$i++) {
			        $this->info['PAGES'][$i] = makelink(array($form->info['FORM_NAME']."_search" => $search, $this->info['TABLE_NAME']."_showpage" => $i), TRUE);
			}
		}
	}
	
	function db_data_edit() {
		$args = func_get_args();
		for($i=1;$i<count($this->data);$i++) {
			if (isset($this->data[$i])) {
				unset($edit_par);
				for($j=1;$j<func_num_args();$j=$j+2) {
					$edit_par[$args[$j]] = $this->data[$i][$args[$j+1]];
				}
				$this->info['EDIT'][$i] = makelink($edit_par);
			}
		}
		return $this->data;
	}

	function db_data_delete() {
		$args = func_get_args();
		for($i=1;$i<count($this->data);$i++) {
			if (isset($this->data[$i])) {
				unset($delete_par);
				for($j=1;$j<func_num_args();$j=$j+2) {
					$delete_par[$args[$j]] = $this->data[$i][$args[$j+1]];
				}
				$delete_par['delete_item'] = 'true';
				$this->info['DELETE'][$i] = makelink($delete_par);
			}
		}
		return $this->data;
	}

	function db_data_multichoice() {
		$args = func_get_args();
		for($i=1;$i<count($this->data);$i++) {
			if (isset($this->data[$i])) {
				if (func_num_args() > 2) {
					unset($delete_par);
					for($j=1;$j<=func_num_args();$j=$j+2) {
						$delete_par[$args[$j]] = $this->data[$i][$args[$j]];
					}
					$this->info['MULTICHOICE'][$i] = urlencode(serialize($delete_par));
				} else {
					$this->info['MULTICHOICE'][$i] = $this->data[$i][$args[1]];				
				}
			}
		}
	}

	function db_data_multichoice_checked($key, $true_value=TRUE) {
		for($i=1;$i<count($this->data);$i++) {
			if (isset($this->data[$i]) && ($this->data[$i][$key] == $true_value)) {
				$this->info['MULTICHOICE_CHECKED'][$i] = 'YES';
			}
		}
	}
	
	function db_data_remove() {
		$args = func_get_args();
		for($i=0;$i<count($this->data);$i++) {
			for($j=0;$j<func_num_args();$j++) {
				unset($this->data[$i][$args[$j]]);
			}
		}
	}

	function db_data_translate() {
		$args = func_get_args();
		for($j=0;$j<func_num_args();$j++) {
			$this->info['TRANSLATE'][$args[$j]] = 'YES';
		}
	}

	function db_data_hide() {
		$args = func_get_args();
		for($j=0;$j<func_num_args();$j++) {
			$this->info['HIDE'][$args[$j]] = 'YES';
		}
	}
	
}

?>
