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


require_once __DIR__ . '/../html.lib.php';
require_once __DIR__ . '/SmartMenuEntry.class.php';

//! Demo class of a smart menu
class SmartMenu
{
    /**
     * Internal first level menu entry
     * @var SmartMenuEntry
     */ 
    private $root_entry;

    //! Attributes to add on menu
    private $menu_attribs = array();

    //! Construct the smart menu
    /**
     * @param $attribs Custom attributes to add on menu UL element.
     */
    public function __construct($attribs = array())
    {
        $this->root_entry = new SmartMenuEntry();
        $this->menu_attribs = $attribs;
    }

    //! Create a new text entry in main menu
    /**
     * @param $display The text to be displayed.
     * @param $id A unique id for this menu entry that can be used to reference it.
     */
    public function createEntry($display, $id = null)
    {   
        return $this->root_entry->createEntry($display, $id);
    }

    //! Create a new link entry in main menu
    /**
     * @param $display The text to be displayed on link.
     * @param $link The actual link of entry.
     * @param $id A unique id for this menu entry that can be used to reference it.
     * @return SmartMenuEntry
     */    
    public function createLink($display, $link, $id = null)
    {   
        return $this->root_entry->createLink($display, $link, $id);
    }
    
    //! Render menu and return html tree.
    public function render()
    {	
        $ul = $this->root_entry->renderChildren();
        $ul->attributes = array_merge($ul->attributes, $this->menu_attribs);
        return $ul;
    }
    
    /**
     * Get the root entry
     * @return SmartMenuEntry
     */ 
    public function getRootEntry()
    {
    	return $this->root_entry;
    }
}