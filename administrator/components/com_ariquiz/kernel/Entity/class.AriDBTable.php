<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriDBTable extends JTable
{
	function AriDBTable($table, $keyField, &$database)
	{
		parent::__construct($table, $keyField, $database);
	}

	function bind($data, $ignoreArray = array())
	{
		if (is_array($data))
		{
			$vars = get_class_vars(get_class($this));
			if ($vars)
			{
				foreach ($vars as $name => $value)
				{
					if (isset($data[$name]) && empty($data[$name]))
					{
						$data[$name] = $value;
					}
				}
			}
		}
		
		return parent::bind($data, $ignoreArray);
	}
	
	function getPublicFields($ignoreArray = array())
	{
		$fields = array();
		foreach (get_class_vars(get_class($this)) as $key => $val) 
		{
			if (substr($key, 0, 1) != '_') 
			{
				$value = $this->$key;
				if (!is_object($value) && !in_array($key, $ignoreArray)) $fields[$key] = $value; 
			}
		}

		return $fields;
	}
}
?>