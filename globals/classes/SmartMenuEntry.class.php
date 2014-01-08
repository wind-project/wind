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

//! An menu entry of the SmartMenu
class SmartMenuEntry
{
    //! Acceptable types
    static private $types = array('link', 'text', 'custom');

    //! Acceptablte modes
    static private $modes = array('prefix', 'equal', false);

    //! Display text of this entry
    private $display = '';

    //! Type of this entry
    private $type = 'text';

    //! Link of this entry
    private $link = '';

    //! Autoselect mode for links
    private $autoselect_mode = 'prefix';

    //! Children of this entry
    private $children = array();

    //! Extra custom html attributes entry's LI element.
    public $extra_attr = array();

    //! Check if it is selected
    public function isSelected()
    {
        $REQUEST_URL = $_SERVER['REQUEST_URI'];
        if ($this->autoselect_mode === false)
            return false;
            
        if ($this->autoselect_mode === 'prefix')
            if( $this->link === substr($REQUEST_URL, 0, strlen($this->link)))
                return true;
        if ($this->autoselect_mode === 'equal')
            if ($this->link === $REQUEST_URL)
                return true;
        return false;
    }
    
    /**
     * Render this entry and all its children;
     * @return Output_HTMLTag
     */ 
    public function render()
    {
        if ($this->type === 'link')
        {
            $li = tag('li', tag('a', array('href' => $this->link), $this->display), $this->extra_attr);
            if ($this->isSelected())
                $li->add_class('active');
        }
        else if ($this->type === 'custom')
            $li = tag('li html_escape_off', $this->display, $this->extra_attr);
        else if ($this->type == 'text')
            $li = tag('li', $this->display, $this->extra_attr);

        // Add children if any
        if (!empty($this->children)) {
        	$li->add_class('has-children');
        	$submenu = $this->renderChildren();
            $li->append($submenu);
        }
            
        return $li;
    }

    /**
     *  Render only the children of this entry.
     *  @return Output_HTMLTag
     */
    public function renderChildren()
    {
        $ul = tag('ul');
        
        foreach($this->children as $entry)
            $entry->render($entry)->appendTo($ul);

        return $ul;
    }

    //! Create a new sub text entry
    /**
     * @param $display The text to be displayed.
     * @param $id A unique id for this menu entry that can be used to reference it.
     * @return SmartMenuEntry
     */
    public function createEntry($display, $id = null)
    {   
        $entry = new SmartMenuEntry();
        $entry->setDisplay($display);
        if ($id !== null)
            $this->children[$id] = $entry;
        else
            $this->children[] = $entry;
            
        return $entry;
    }

    //! Create a new sub entry
    /**
     * @param $display The text to be displayed on link.
     * @param $link The actual link of entry.
     * @param $id A unique id for this menu entry that can be used to reference it.
     * @return SmartMenuEntry
     */    
    public function createLink($display, $link, $id = null)
    {   
        $entry = $this->createEntry($display, $id);
        $entry->setType('link');
        $entry->setLink($link);
        return $entry;
    }

    /**
     * Get a child based on its id
     * @return SmartMenuEntry
     */ 
    public function getChild($id)
    {
        if (isset($this->children[$id]))
            return $this->children[$id];
        return NULL;
    }
    
    /**
     * Remove a child from the entries
     */
    public function removeChild($id)
    {
    	unset($this->children[$id]);
    }
    
    /**
     * Get all children
     * @return array
     */
    public function getChildren()
    {
    	return $this->children;
    }

    //! Set the display of this entry
    public function & setDisplay($display)
    {
        $this->display = $display;
        return $this;
    }

    //! Set the type of this entry   
    public function & setType($type)
    {
        if (in_array($type, self::$types, true))
            $this->type = $type;
        return $this;
    }

    //! Set the link of this entry
    public function & setLink($link)
    {
        $this->link = (string)$link;
        return $this;
    }

    //! Set the autoselect mode of this entry
    public function & setAutoselectMode($mode)
    {
        if (in_array($mode, self::$modes, true))
            $this->autoselect_mode = $mode;
        return $this;
    }

    //! Get the display of this entry
    public function getDisplay()
    {
        return $this->display;
    }

    //! Get the type of this entry
    public function getType()
    {
        return $this->type;
    }

    //! Get the link of this entry
    public function getLink()
    {
        return $this->link;
    }

    //! Get the autoselect mode of this entry
    public function getAutoselectMode()
    {
        return $this->autoselect_mode;
    }
}