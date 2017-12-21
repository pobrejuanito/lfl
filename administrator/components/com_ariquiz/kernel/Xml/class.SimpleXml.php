<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriSimpleXML extends AriObject
{
	var $_parser = null;
	var $_xml = '';
	var $document = null;
	var $_stack = array();

	function __construct($options = null)
	{
		if (!function_exists('xml_parser_create')) 
		{
			trigger_error('ARI: Couldnt not xml parser create.', E_USER_ERROR);
			return false;
		}

		$this->_parser = xml_parser_create();

		xml_set_object($this->_parser, $this);
		xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, 0);
		if (is_array($options))
		{
			foreach($options as $option => $value) 
			{
				xml_parser_set_option($this->_parser, $option, $value);
			}
		}

		xml_set_element_handler($this->_parser, '_startTagHandler', '_endTagHandler');
		xml_set_character_data_handler($this->_parser, '_cdataHandler');
	}

	function loadString($string) 
	{
		$this->_parse($string);
		return true;
	}

	function loadFile($path)
	{
		if (!file_exists( $path ))  
		{
			return false;
		}

		$xml = trim(file_get_contents($path));
		if (empty($xml))
		{
			return false;
		}
		else
		{
			$this->_parse($xml);
			return true;
		}
	}

	function importDom($node) 
	{
		return false;
	}

	function getParser() 
	{
		return $this->_parser;
	}

	function setParser($parser) 
	{
		$this->_parser = $parser;
	}

	function _parse($data = '')
	{
		if (!xml_parse($this->_parser, $data, true)) 
		{
			$this->_triggerError(
				xml_get_error_code($this->_parser),
				xml_get_current_line_number($this->_parser),
				xml_get_current_column_number($this->_parser)
			);
		}

		xml_parser_free($this->_parser);
	}

	function _triggerError($code, $line, $col)
	{
		echo sprintf('ARI XML: Error at line %s column %s. Error %s: %s',
			$line,
			$col,
			$code,
			xml_error_string($code));
		trigger_error(sprintf('ARI XML: Error at line %s column %s. Error %s: %s',
			$line,
			$col,
			$code,
			xml_error_string($code)),
			E_USER_ERROR);
	}

	function _getStackLocation()
	{
		$return = '';
		foreach($this->_stack as $stack) 
		{
			$return .= $stack . '->';
		}

		return rtrim($return, '->');
	}
	
	function &_getElementFromStack()
	{
		$path = $this->_getStackLocation();
		eval('$GLOBALS[\'_ariXmlEl\'] =& $this->' . $path . ';');

		return $GLOBALS['_ariXmlEl'];
	}

	function _startTagHandler($parser, $name, $attrs = array())
	{
		if (count($this->_stack) == 0)
		{
			$this->document = new AriSimpleXMLElement($name, $attrs);
			$this->_stack = array('document');
		}
		else
		{
			$el =& $this->_getElementFromStack();
			$el->addChild($name, $attrs, count($this->_stack));
			$this->_stack[] = $name . '[' . (count($el->$name) - 1) . ']';
		}
	}

	function _endTagHandler($parser, $name)
	{
		array_pop($this->_stack);
	}

	function _cdataHandler($parser, $data)
	{
		$el =& $this->_getElementFromStack();
		$el->_data .= $data;
	}
}

class AriSimpleXMLElement extends AriObject
{
	var $_attributes = array();
	var $_name = '';
	var $_data = '';
	var $_children = array();
	var $_level = 0;

	function __construct($name, $attrs = array(), $level = 0)
	{
		$this->_attributes = array_change_key_case($attrs, CASE_LOWER);
		$this->_name = strtolower($name);
		$this->_level = $level;
	}

	function name() 
	{
		return $this->_name;
	}

	function attributes($attribute = null)
	{
		if(is_null($attribute)) 
		{
			return $this->_attributes;
		}
		
		$attribute = strtolower($attribute);

		return isset($this->_attributes[$attribute]) ? $this->_attributes[$attribute] : null;
	}

	function data() 
	{
		return $this->_data;
	}

	function setData($data) 
	{
		$this->_data = $data;
	}

	function children() 
	{
		return $this->_children;
	}

	function level() 
	{
		return $this->_level;
	}

	function addAttribute($name, $value)
	{
		$this->_attributes[$name] = $value;
	}

	function removeAttribute($name)
	{
		unset($this->_attributes[$name]);
	}

	function &addChild($name, $attrs = array(), $level = null)
	{
		if(!isset($this->$name)) 
		{
			$this->$name = array();
		}

		if (is_null($level))	
		{
			$level = ($this->_level + 1);
		}

		$classname = get_class( $this );
		$child = new $classname( $name, $attrs, $level );
		$this->{$name}[] =& $child;
		$this->_children[] =& $child;

		return $child;
	}

	function removeChild(&$child)
	{
		$name = $child->name();
		for ($i = 0, $n = count($this->_children); $i < $n; $i++)
		{
			if ($this->_children[$i] == $child) 
			{
				unset($this->_children[$i]);
			}
		}

		for ($i = 0, $n = count($this->{$name}); $i < $n; $i++)
		{
			if ($this->{$name}[$i] == $child) 
			{
				unset($this->{$name}[$i]);
			}
		}
		$this->_children = array_values($this->_children);
		$this->{$name} = array_values($this->{$name});
		unset($child);
	}

	function &getElementByPath($path)
	{
		$tmp =& $this;
		$false = false;
		$parts = explode('/', trim($path, '/'));

		foreach ($parts as $node)
		{
			$found = false;
			foreach ($tmp->_children as $child)
			{
				if ($child->_name == $node)
				{
					$tmp =& $child;
					$found = true;
					break;
				}
			}
			if (!$found) 
			{
				break;
			}
		}

		if ($found) 
		{
			$ref =& $tmp;
		} 
		else 
		{
			$ref =& $false;
		}

		return $ref;
	}

	function map($callback, $args = array())
	{
		$callback($this, $args);

		if ($n = count($this->_children)) 
		{
			for($i = 0; $i < $n; $i++)
			{
				$this->_children[$i]->map($callback, $args);
			}
		}
	}

	function toString($whitespace = true)
	{
		if ($whitespace) 
		{
			$out = "\n" . str_repeat("\t", $this->_level) . '<' . $this->_name;
		} 
		else 
		{
			$out = '<' . $this->_name;
		}

		foreach($this->_attributes as $attr => $value)
		{
			$out .= sprintf(' %s="%s"', $attr, htmlspecialchars($value)); 
		}

		$isEmptyData = is_null($this->_data) || !strlen($this->_data);
		if(empty($this->_children) && $isEmptyData)
		{
			$out .= " />";
		}
		else
		{
			if(!empty($this->_children))
			{
				$out .= '>';

				foreach($this->_children as $child)
				{
					$out .= $child->toString($whitespace);
				}

				if ($whitespace) 
				{
					$out .= "\n" . str_repeat("\t", $this->_level);
				}
			}
			else if(!$isEmptyData)
			{
				$out .= '>' . htmlspecialchars($this->_data);
			}

			$out .= '</' . $this->_name . '>';
		}

		return $out;
	}
}