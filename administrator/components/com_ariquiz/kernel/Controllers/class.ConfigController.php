<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriConfigController extends AriControllerBase
{
	var $_table;
	
	function __construct($table)
	{
		$this->_table = $table;
		
		parent::__construct();
	}
	
	function getConfig()
	{
		$database =& JFactory::getDBO();
		
		$config = array();
		$query = 'SELECT ParamName,ParamValue FROM ' . $this->_table;
		$database->setQuery($query);
		$list = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt load config.', E_USER_ERROR);
			return $config;
		}
		
		if (!empty($list))
		{
			foreach ($list as $row)
			{
				$config[$row['ParamName']] = $row['ParamValue'];
			}
		}
		
		return $config;
	}
	
	function getConfigValue($key)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT ParamValue FROM ' . $this->_table . ' WHERE ParamName = %s LIMIT 0,1',
			$database->Quote($key));
		$database->setQuery($query);
		$value = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get config value.', E_USER_ERROR);
			return null;
		}
		
		return $value;
	}
	
	function setConfigValue($key, $value)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('INSERT INTO ' . $this->_table . ' (ParamName,ParamValue) VALUES(%s,%s) ON DUPLICATE KEY UPDATE ParamValue = %2$s',
			$database->Quote($key),
			$database->Quote($value));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt store config value.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function removeConfigKey($key)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('DELETE FROM ' . $this->_table . ' WHERE ParamName = %s',
			$database->Quote($key));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt remove config key.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
}
?>
