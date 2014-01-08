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

class construct {
	
	function form($form, $template='constructors/form.tpl') {
		global $smarty;
		if (substr(strrchr($template, "."), 1) != "tpl") {
			$path_parts = pathinfo($template);
			$tpl_file = 'includes'.substr($path_parts['dirname'], strpos($path_parts['dirname'], 'includes') + 8)."/".basename($path_parts['basename'], '.'.$path_parts['extension']).'_'.$form->info['FORM_NAME'].'.tpl';
			if (file_exists($smarty->template_dir.$tpl_file)) {
				$template = $tpl_file;
			} else {
				$template='constructors/form.tpl';
			}
		}
		return template(array("data" => $form->data,
				"extra_data" => $form->info,
				'buttons' => $form->buttons,
				"action_url" => self_ref()),
				$template);
	}
	
	function table($table, $template='constructors/table.tpl') {
		global $smarty;
		if (substr(strrchr($template, "."), 1) != "tpl") {
			$path_parts = pathinfo($template);
			$tpl_file = 'includes'.substr($path_parts['dirname'], strpos($path_parts['dirname'], 'includes') + 8)."/".basename($path_parts['basename'], '.'.$path_parts['extension']).'_'.$table->info['TABLE_NAME'].'.tpl';
			if (file_exists($smarty->template_dir.$tpl_file)) {
				$template = $tpl_file;
			} else {
				$template='constructors/table.tpl';
			}
		}
		return template(array("data" => $table->data, "extra_data" => $table->info, "action_url" => self_ref()), $template);
	}
		
}

?>
