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

class form {
	
	var $info=array();
	var $data=array();
	
	function form($info="") {
		if (is_array($info)) $this->info = $info;
	}
	
	function db_data($db_info) {
		global $db;
		$ret = array();
		$db_info = explode(',', $db_info);
		for ($i=0;$i<count($db_info);$i++) {
			$db_info[$i] = trim($db_info[$i]);
			$db_info[$i] = explode('.', $db_info[$i]);
			if (!isset($f[$db_info[$i][0]])) $f[$db_info[$i][0]] = $db->get_fields($db_info[$i][0]);
			for ($p=0;$p<count($f[$db_info[$i][0]]);$p++) {
				if ($db_info[$i][1] == $f[$db_info[$i][0]][$p]['Field'] || $db_info[$i][1] == '*') {
					$f[$db_info[$i][0]][$p]['fullField'] = $db_info[$i][0].'__'.$f[$db_info[$i][0]][$p]['Field'];
					if (strpos($f[$db_info[$i][0]][$p]['Type'], 'enum') === 0) {
						$enums = substr($f[$db_info[$i][0]][$p]['Type'], 5, -1);
						$enums = explode(',', $enums);
						unset($tmp);
						for($e=0;$e<count($enums);$e++) {
							$tmp[$e]['output'] = $tmp[$e]['value'] = substr($enums[$e], 1, -1);
						}
						$f[$db_info[$i][0]][$p]['Type'] = 'enum';
						$f[$db_info[$i][0]][$p]['Type_Enums'] = $tmp;
					}
					array_push($ret, $f[$db_info[$i][0]][$p]);
				}
			}
		}
		$this->data = array_merge($this->data, $ret);
	}
	
	function db_data_enum($data_field, $options, $multi=FALSE) {
		for ($i=0;$i<count($this->data);$i++) {
			if ($data_field == str_replace("__", ".", $this->data[$i]['fullField'])) {
				$this->data[$i]['Type'] = 'enum'.($multi==FALSE?'':"_multi");
				$this->data[$i]['Type_Enums'] = $options;
				break;
			}
		}
	}

	function db_data_pickup($data_field, $subpage, $values, $multi=FALSE) {
		for ($i=0;$i<count($this->data);$i++) {
			if ($data_field == str_replace("__", ".", $this->data[$i]['fullField'])) {
				$this->data[$i]['Type'] = 'pickup'.($multi==FALSE?'':"_multi");
				$this->data[$i]['Pickup_url'] = makelink(array("page" => "pickup", "subpage" => $subpage, "object" => $this->info['FORM_NAME'].".elements['".str_replace(".", "__", $data_field).($multi==FALSE?'':"[]")."']"));
				if ($multi == FALSE) {
					$this->data[$i]['Type_Pickup'] = (isset($values[0])?$values[0]:'');
				} else {
					$this->data[$i]['Type_Pickup'] = $values;
				}
				break;
			}
		}
	}
	
	// args: [[table], [key], [value] ...]
	function db_data_values() {
		global $db;
		$args = func_get_args();
		for ($carg=0;$carg<func_num_args();$carg=$carg+3) {
			$ckey = $args[$carg];
			$db_data = $db->get("*", $args[$carg], $args[$carg+1]."='".$args[$carg+2]."'");
			for($i=0;$i<count($this->data);$i++) {
				$key = explode("__", $this->data[$i]['fullField']);
				if (isset($key[1])) {
					if ($ckey == $key[0]) {
						$this->data[$i]['value'] = (isset($db_data[0][$key[1]])?$db_data[0][$key[1]]:"");
					}
				}
			}
		}
	}

	// args: [[table], [key], [value], [result key] ...]
	function db_data_values_multi() {
		global $db;
		$args = func_get_args();
		for ($carg=0;$carg<func_num_args();$carg=$carg+4) {
			$ckey = $args[$carg];
			$db_data = $db->get($args[$carg+3], $args[$carg], $args[$carg+1]."='".$args[$carg+2]."'");
			for($i=0;$i<count($this->data);$i++) {
				$key = explode("__", $this->data[$i]['fullField']);
				if ($key[1] != '') {
					if ($ckey == $key[0]) {
						for ($j=0;$j<count($db_data);$j++) {
							$this->data[$i]['value'][$db_data[$j][$args[$carg+3]]] = "YES";
						}
					}
				}
			}
		}
	}
	
	// set all values in the search form
	function db_data_search() {
		$sc = unserialize(stripslashes(get($this->info['FORM_NAME'].'_search')));
		for ($i=0;$i<count($this->data);$i++) {
			if (isset($this->data[$i])) {
				if (isset($sc[$this->data[$i]['fullField']])) {
					$sc_dati_ff = $sc[$this->data[$i]['fullField']];
				}
				else { 
					$sc_dati_ff = ''; 
				}
				$this->data[$i]['value'] = (isset($_POST[$this->data[$i]['fullField']]) ? $_POST[$this->data[$i]['fullField']] : $sc_dati_ff);
				if (isset($this->data[$i]['Compare'])) {
					if (isset($sc[$this->data[$i]['fullField'].'_compare'])) {
					    $sc_dati_ff_cmp = $sc[$this->data[$i]['fullField'].'_compare'];
					}
					else {
					    $sc_dati_ff_cmp = '';
					}
					$this->data[$i]['Compare_value'] = (isset($_POST[$this->data[$i]['fullField'].'_compare']) ? $_POST[$this->data[$i]['fullField'].'_compare'] : $sc_dati_ff_cmp);
				}
				$this->data[$i]['Null'] = 'YES';
			}
		}
	}
	
	// get the where string for SQL. $extra[_fieldname_]: '=' | 'starts_with' | 'ends_with' | 'contains' | 'exclude'
	function db_data_where($extra="") {
		$where = "";
		for ($i=0;$i<count($this->data);$i++) {
			if (isset($this->data[$i])) {
				$item = $this->data[$i]['fullField'];
				if (isset($this->data[$i]['Compare']) && !isset($extra[$item])) {
					$extra[$item] = $this->data[$i]['Compare_value'];
				}
				$value = $this->data[$i]['value'];
				switch (isset($extra[$item])?$extra[$item]:'') {
					case '':
					case '=':
					case 'equal':
						$where .= ($value !=''?str_replace("__", ".", $item)." = '".$value."' AND ":"");
						break;
					case 'greater':
						$where .= ($value !=''?str_replace("__", ".", $item)." > '".$value."' AND ":"");
						break;
					case 'less':
						$where .= ($value !=''?str_replace("__", ".", $item)." < '".$value."' AND ":"");
						break;
					case 'greater_equal':
						$where .= ($value !=''?str_replace("__", ".", $item)." >= '".$value."' AND ":"");
						break;
					case 'less_equal':
						$where .= ($value !=''?str_replace("__", ".", $item)." <= '".$value."' AND ":"");
						break;
					case 'starts_with':
						$where .= ($value !=''?str_replace("__", ".", $item)." LIKE '".$value."%' AND ":"");
						break;
					case 'ends_with':
						$where .= ($value !=''?str_replace("__", ".", $item)." LIKE '%".$value."' AND ":"");
						break;
					case 'contains':
						$where .= ($value !=''?str_replace("__", ".", $item)." LIKE '%".$value."%' AND ":"");
						break;
					case 'exclude':
						break;
				}
			}
		}
		if ($where!='') $where = substr($where, 0, -5);
		return $where;
	}
	
	// pdata: extra data, args: [[table], [key], [value] ...]
	function db_set($pdata=array()) { 
		global $db;
		if (!is_array($pdata)) $pdata = array();
		$ret = TRUE;
		$args = func_get_args();
		for ($carg=1;$carg<func_num_args() || $carg==1;$carg=$carg+3) {
			$ckey = isset($args[$carg])?$args[$carg]:'';
			unset($data);
			$cpost = $this->correct_datetime_data($_POST);
			for($i=0;$i<count($this->data);$i++) {
				$key = explode("__", $this->data[$i]['fullField']);
				if (isset($key[1])) {
					if ($ckey == '') $ckey = $key[0];
					if ($ckey == $key[0]) {
						if (isset($cpost[$this->data[$i]['fullField']])) {
						    if (!is_array($cpost[$this->data[$i]['fullField']])) {
								$data[$key[1]] = $cpost[$this->data[$i]['fullField']];
						    }
						}
					}
				}
			}
			reset($pdata);
			while (list($key, $value) = each($pdata)) {
				$key = explode(".", $key);
				if ($ckey == $key[0] || !isset($key[1])) {
					$data[(isset($key[1])?$key[1]:$key[0])] = $value;
				}
			}
			$field = isset($args[$carg+1])?$args[$carg+1]:'';
			$value = isset($args[$carg+2])?$args[$carg+2]:'';
			if ($field == '' || $value == '' || $value == 'add') {
				$ret = $ret && $db->add($ckey, $data);
			} else {
				$ret = $ret && $db->set($ckey, $data, "$field = '$value'");
			}
		}
		return $ret;
	}
	
	// pdata: extra data, args: [[table], [key] [value] ...]
	function db_set_multi($pdata=array()) { 
		global $db;
		$ret = TRUE;
		$args = func_get_args();
		for ($carg=1;$carg<func_num_args() || $carg==1;$carg=$carg+3) {
			$ckey = $args[$carg];
			unset($data);
			$cpost = $this->correct_datetime_data($_POST);
			for($i=0;$i<count($this->data);$i++) {
				$key = explode("__", $this->data[$i]['fullField']);
				if (isset($key[1])) {
					if ($ckey == '') $ckey = $key[0];
					if ($ckey == $key[0]) {
						$data[$key[1]] = (isset($cpost[$this->data[$i]['fullField']]))?$cpost[$this->data[$i]['fullField']]:NULL;
					}
				}
			}
			reset($pdata);
			while (list($key, $value) = each($pdata)) {
				$key = explode(".", $key);
				if ($ckey == $key[0] || !isset($key[1])) {
					$data[(!isset($key[1])?$key[0]:$key[1])] = $value;
				}
			}
			while (list($key, $value) = each($data)) {
				if (is_array($value)) {
					for ($i=0;$i<count($value);$i++) {
						$data_f[$i] = $data;
						$data_f[$i][$key] = $value[$i];
					}
					break;
				}
			}
			$ret = $ret && $db->del($ckey, '', $args[$carg+1]." = '".$args[$carg+2]."'");
			if (isset($data_f)) {
				for ($i=0;$i<count($data_f);$i++) {
					$data_f[$i][$args[$carg+1]] = $args[$carg+2];
					$ret = $ret && $db->add($ckey, $data_f[$i]);
				}
			}
		}
		return $ret;
	}

	function correct_datetime_data($data) {
		while (list($key, $value) = each($data)) {
			if (strpos($key, "CONDATETIME_") === 0) {
				$ckey = substr($key, 12, strrpos($key, "_") - strlen($key));
				
				$Day = $data["CONDATETIME_".$ckey."_Day"];
				$Month = $data["CONDATETIME_".$ckey."_Month"];
				$Year = $data["CONDATETIME_".$ckey."_Year"];
				$Hour = $data["CONDATETIME_".$ckey."_Hour"];
				$Minute = $data["CONDATETIME_".$ckey."_Minute"];
				$Second = $data["CONDATETIME_".$ckey."_Second"];
				
				unset($data["CONDATETIME_".$ckey."_Day"]);
				unset($data["CONDATETIME_".$ckey."_Month"]);
				unset($data["CONDATETIME_".$ckey."_Year"]);
				unset($data["CONDATETIME_".$ckey."_Hour"]);
				unset($data["CONDATETIME_".$ckey."_Minute"]);
				unset($data["CONDATETIME_".$ckey."_Second"]);
								
				$data[$ckey] = "$Year-$Month-$Day $Hour:$Minute:$Second";
				reset($data);
			}
		}
		return $data;
	}

	function db_data_remove() {
		$args = func_get_args();
		for($i=0;$i<count($this->data);$i++) {
			for($j=0;$j<func_num_args();$j++) {
				if ($this->data[$i]['fullField'] == $args[$j]) unset($this->data[$i]);
			}
		}
		$this->data = array_merge($this->data);
	}


}
?>