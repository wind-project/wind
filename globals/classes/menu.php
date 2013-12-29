<?php
/*
 * WiND - Wireless Nodes Database
*
* Copyright (C) 2005-2013 	by WiND Contributors (see AUTHORS.txt)
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



/**
 * @brief Renderer of a menu object
 */
class MenuRenderer {
	
	/**
	 * @brief An array with all menu entries
	 * @var array
	 */
	private $entries;
	

	/**
	 * @brief The classes of the base element
	 * @var array
	 */
	private $classes;
	
	/**
	 * @brief Construct the menu object
	 * @param array $classes An array of all classes to add on
	 * main menu element.
	 */
	function __construct($classes = array('menu')) {
		$this->entries = array();
		$this->classes = $classes;
	}
	
	
	/**
	 * @brief Add an entry on the menu
	 * @param string $id The menu identifier
	 * @param string $title The title of the menu link
	 * @param string $href The url to the resource
	 */
	function addEntry($id, $title, $href) {
		$this->entries[$id] = array(
				'title' => $title,
				'href' => $href,
				'class' => array('menu-entry-' . $id),
				'selected' => false);
	}
	
	/**
	 * @brief Get a reference to a menu entry
	 * @param string $id The identifier of the entry
	 */
	function & getEntry($id) {
		return $this->entries[$id];
	}
	
	/**
	 * @brief Set the selected menu entry
	 * This will unselecte any other entry and selecte only this one. The
	 * selected entry will have the "selected" class on the output.
	 * @param string $id
	 */
	function select($id) {
		foreach($this->entries as & $entry){
			$entry['selected'] = false;
		}
		
		$this->entries[$id]['selected'] = true;
	}

	/**
	 * @brief Render menu on HTML format
	 * @return string The html code of the menu
	 */
	function outputHtml() {
		$output = '<ul class="' . implode(' ', $this->classes) .  '" >';
		foreach($this->entries as $entry_id => $entry) {
			$output .= '<li class="' . implode(' ', $entry['class']);
			if ($entry['selected']) {
				$output .= ' selected';
			}
			$output .= '">' ;
			
			$output .= '<a href="' . $entry['href'] . '">' . $entry['title'] . '</a>';
			
			$output .= '</li>';
		}
		$output .= '</ul>';
		return $output;
	}
};