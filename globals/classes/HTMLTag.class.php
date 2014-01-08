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



//require_once(dirname(__FILE__) . '/../functions.lib.php');

//! Simple DOM representation interface 
/**
 * HTMLTag is a simple interface to create DOM elements, and render
 * html/xhtml valid code. It has a small memory footprint and supports
 * automatic html escaping of text nodes, attributes etc. To check how
 * to use it look at the HTMLTag::__construct() 
 * 
 * @remarks HTMLTag does @b not support parsing of HTML/XHTML
 * 
 * @par Example of usage
 * @code
 * // A 2x2 table creation
 * $table = new HTMLTag('table',
 *     new HTMLTag('tr',
 *         new HTMLTag('td', 'row 1 col 1'),
 *         new HTMLTag('td', 'row 1 col 2')
 *     ),
 *     new HTMLTag('tr',
 *         new HTMLTag('td', 'row 2 col 1'),
 *         new HTMLTag('td', 'row 2 col 2')
 *     )
 * );
 * @endcode
 * \n
 * An easier way to create the same code as above is to use tag() shortcut
 * @code
 * // A 2x2 table using tag() shortcut
 * $table = tag('table',
 *     tag('tr',
 *         tag('td', 'row 1 col 1'),
 *         tag('td', 'row 1 col 2')
 *     ),
 *     tag('tr',
 *         tag('td', 'row 2 col 1'),
 *         tag('td', 'row 2 col 2')
 *     )
 * );
 * @endcode
 * \n
 * <b> Output in both cases is the same </b>
 * @code
 * <table>
 *   <tr>
 *       <td>row 1 col 1</td>
 *       <td>row 1 col 2</td>
 *   </tr>
 *   <tr>
 *       <td>row 2 col 1</td>
 *       <td>row 2 col 2</td>
 *   </tr>
 * </table>
 * @endcode
 * @author sque
 *
 */
class Output_HTMLTag
{
	//! Set the default render mode for all HTMLTag
	/**
	 * This parameter controls the rendering mode of all HTMLTag 
	 * that have not explicit specified their mode with HTMLTag::$render_mode .
	 * Accepted values are:
	 * - @b 'xhtml'
	 * - @b 'html'
	 * .
	 */
	public static $default_render_mode = 'html';

	//! List of html element that do not close
	private static $html_single_tags = array('hr', 'br', 'img', 'meta', 'link', 'input');
	
	//! The actual tag
	public $tag = '';
	
	//! The parameter of tag
	public $attributes = array();
	
	//! The childs of this tag
	public $childs = array();
	
	//! Mode of rendering for this HTMLTag
	/**
	 * Accepted values are:
	 * - @b NULL [Default] : It will render in the mode that is specified by HTMLTag::$default_render_mode
	 * - @b 'xhtml': The tag will be rendered in xhtml mode.
	 * - @b 'html': The tag will be rendered in html mode.
	 * .
	 */
	public $render_mode = NULL;
	
	//! Escape html special entities from text blocks
	public $esc_html= true;
	
	//! Escape new lines to br
	public $esc_nl = false;
	
	//! General Constructor
	/**
	 * Construct an HTML element with custom attributes and childs.
	 * How to use it
	 * @code
	 * new HTMLTag($name_and_options, [array $extra_options], [$child1], [$child2], ...)
	 * @endcode
	 * @par Parameters
	 * @b $name_and_options: is the tag name with some extra static attributes. 
	 * - 'div' Just the tag name
	 * - 'div class="test" id="1"' The tag along with two attributes
	 * .
	 * \n
	 * @b $extra_options is an associative array with extra class attributes. The attributes
	 *  are given in the form of name => value.
	 * - array(class => "button", "id" => "button1");
	 * .
	 * \n
	 * @b $child is another child tag or a string for a text node. Strings are properly escaped
	 *  so that they don't brake html syntax in case they contain special characters.
	 *  
	 * 
	 * @note To simplify the process of HTMLTag construction an alias function tag() was created 
	 *  to create HTMLTag object with the specified parameters and return the object reference.
	 * 
	 * @par Examples
	 * @code
	 * tag('table class="number-table"', array('style' => 'background-color: red;'),
	 *     tag('tr class="odd"',
	 *         tag('td', 'My cell is the best')
	 *      )
	 * );
	 * @endcode
	 * \n
	 * @code
	 * // Create
	 * $article = tag('div', array('class' => 'article'),
	 *    tag('h1', 'The best news in town'),
	 *    tag('p', 'Bla bla balb abl ablab alba lba'),
	 *    tag('p', 'More bla bla bla bal')
	 * );
	 * 
	 * // Render it
	 * $article->render();
	 * @endcode
	 */
	public function __construct()
	{		
		$args = func_get_args();
		
		if (count($args) == 0)
			throw new InvalidArgumentException('HTMLTag constructor must take at least one argument with the tag');
		
		// Analyze tag options
		$tag_exploded = explode(' ', $args[0]);
		foreach(array_slice($tag_exploded, 1) as $option)
			if ($option == "")
				continue;
			else if ($option == 'html_escape_off')
				$this->esc_html = false;
			else if ($option == 'html_escape_on')
				$this->esc_html = true;
			else if ($option == 'nl_escape_on')
				$this->esc_nl = true;
			else if ($option == 'nl_escape_off')
				$this->esc_nl = false;
			else if ($option == 'html_mode')
				$this->render_mode = 'html';
			else if ($option == 'xhtml_mode')
				$this->render_mode = 'xhtml';
			else
			{	// Directly html attribute
				$options = explode('=', $option);
				if (count($options) == 2)
					$this->attributes[trim($options[0], ' "')] = trim($options[1], ' "');
				
				else
					$this->attributes[trim($options[0], ' "')] = '';
			}
				
		$this->tag = $tag_exploded[0];
		
		// Add more arguments
		foreach(array_slice($args, 1) as $arg)
		{	if (is_array($arg))
				$this->attributes = array_merge($this->attributes, $arg);
			else if (is_string($arg) || is_object($arg))
				$this->childs[] = $arg;			
		}
	}
	
	//! Custom nl2br to be compliant with pre-php5.3 version
	public static function nl2br($string, $is_xhtml)
	{	return str_replace("\n", $is_xhtml?'<br />':'<br>', $string);		
	}
	
	//! Render tag attributes
	public static function render_tag_attributes($hash_map)
	{ 	$str = '';
		foreach($hash_map as $attr_key => $attr_value)
			$str .= sprintf(' %s="%s"', esc_html($attr_key), esc_html($attr_value));
		return $str;
	}
	
	//! Set an attribute
	public function attr($attr_name, $attr_value = NULL)
	{	if ($attr_value === NULL)
			return isset($this->attributes[$attr_name])?$this->attributes[$attr_name]:NULL; 
		$this->attributes[$attr_name] = $attr_value;
		return $this;
	}

	//! Get an attribute
	public function get_attr($attr_name)
	{
	    if(!isset($this->attributes[$attr_name]))
	        return null;
        return $this->attributes[$attr_name];
	}

	//! Check if it has an attribute with a specific name and value
	public function has_attr($attr_name, $attr_value = null)
    {
	    if(!isset($this->attributes[$attr_name]))
	        return false;
        if (($attr_value === null) || ($this->attributes[$attr_name] == $attr_value))
            return true;
        return false;
    }
	
	//! Check if it has a class
	public function has_class($class_name)
	{	return in_array($class_name, explode(' ', $this->attr('class')), true);	}
	
	//! Remove class
	public function remove_class($class_name)
	{	$classes = explode(' ', $this->attr('class'));
		if (($key = array_search($class_name, $classes)) === FALSE)
			return $this;
		unset($classes[$key]);
		$this->attr('class', implode(' ', array_values($classes)));
		return $this;
	}
	
	//! Add a class in tag
	public function add_class($class_name)
	{	if ($this->has_class($class_name))
			return $this;
			
		if (($prev_class = $this->attr('class')) === NULL)
			$this->attr('class', $class_name);
		else
			$this->attr('class', $prev_class . ' ' . $class_name);	
		return $this;
	}
	
	//! Append a child
	public function append()
	{	if (func_num_args() > 0)
			foreach(func_get_args() as $arg)
				$this->childs[] = $arg;
		return $this;
	}

	//! Append a text child
	public function append_text($text)
	{
	    $this->childs[] = (string) $text;
	}
	
	//! Prepend a child
	public function prepend()
	{	if (func_num_args() > 0)
		{	$this->childs = array_merge(func_get_args(), $this->childs);	}				
		return $this;
	}
	
	//! Append to another tag
	public function appendTo($tag)
	{	$tag->append($this);
		return $this;
	}
	
	//! Prepend to another tag
	public function prependTo($tag)
	{	$tag->prepend($this);
		return $this;
	}
	
	//! Find all descendant with a specific tag name
	/**
	 * @param $tag The tag name that all descendant must have.
	 * @return An array with all objects having the specified tag name.
	 */
	public function getElementsByTagName($tag)
	{	$elements = array();
	
		foreach($this->childs as $child)
			if (is_object($child))
			{	if ($child->tag == $tag)
					$elements[] = $child;
				$elements = array_merge($elements, $child->getElementsByTagName($tag));
			}
		return $elements;
	}

	//! Find the first descendant with a specific id
	/**
	 * @param $id The id that descendant must have
	 * @return The element with that id or @b null if not found.
	 */
	public function getElementById($id)
	{	$elements = array();
	
		foreach($this->childs as $child)
			if (is_object($child))
			{	if ($child->has_attr('id', $id))
			        return $child;

                if ($res = $child->getElementById($id))
                    return $res;                
			}
		return null;
	}
	
	//! Render this tag and children
	/**
	 * It will render this and all its descendant elements in html/xhtml format.
	 * 
	 * @note To control html or xhtml mode use HTMLTag::$render_mode static flag.
	 * 
	 * @return The string with the html/xhtml code of this element. 
	 */
	public function render()
	{	if ($this->render_mode !== NULL)
			$render_mode = &$this->render_mode;
		else
			$render_mode  = &self::$default_render_mode;
			
		$str = "<{$this->tag}" . self::render_tag_attributes($this->attributes);
	
		// Fast route for always empty tags
		if (in_array($this->tag, self::$html_single_tags))
    		if ($render_mode === 'html')
	    		return $str . ' >';
	        else
	            return $str . ' />';

		// Fast route for XHTML tags with no childs
		if (($render_mode === 'xhtml') && (count($this->childs) == 0))
			return $str . ' ></' . $this->tag . '>';
		$str .= '>';
		
		// Add childs
		foreach($this->childs as $child)
		{	
			if (is_string($child))
			{	if ($this->esc_html) $child = esc_html($child);
				if ($this->esc_nl) $child = self::nl2br($child, ($render_mode == 'xhtml'));
				$str .= $child;
			}
			else
				$str .= (string)$child;
		}
		$str .= "</{$this->tag}>";
		return $str;
	}
	
	//! Render all elements in text-only
	/**
	 * This function will concat ONLY the text nodes of this and all
	 * descendant childs in the same order that they are accessed.
	 * @remark It will not return HTML code, and text is note escaped.	 
	 * @return A string with all element text nodes.
	 */
	public function render_text()
	{	$str = '';
		foreach($this->childs as $child)
		{
			if (is_string($child))
				$str .= $child;
			else
				$str .= $child->render_text();
		}
		return $str;
	}
	
	//! Auto render when converted to string
	public function __toString()
	{	return $this->render();		}
	
	
	/**********************************
	 *  Sub-module for parent tracking
	 */
	
	private static $tracked_parents = array();
	
	//
	public function push_parent($append_to_current = false)
	{   if ($append_to_current)
			$this->append_to_default_parent(); 
		array_push(self::$tracked_parents, $this);
		return $this;
	}
	
	//
	public static function pop_parent($total_pops = 1)
	{	if ($total_pops <= 1)
			return array_pop(self::$tracked_parents);
		
		array_pop(self::$tracked_parents);
		return self::pop_parent($total_pops - 1);	
	}
	
	//! Get current parent returns pointer to HTMLTag or null if none.
	public static function get_current_parent()
	{	if (count(self::$tracked_parents) > 0)
		{
			$last = end(self::$tracked_parents);
			reset(self::$tracked_parents);
			return $last;
		}
		return NULL;
	}
	
	//! Append to default parent
	public function append_to_default_parent()
	{	if (($parent = self::get_current_parent()) != NULL)
		{
			$parent->append($this);
			return true;
		}
		return false;
	}
}

?>
