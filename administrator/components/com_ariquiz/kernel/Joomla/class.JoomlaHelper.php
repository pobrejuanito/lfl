<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('File.FileManager');

class AriJoomlaHelper extends AriObject
{
	function deletePlugin($name, $type = 'content')
	{
		$database =& JFactory::getDBO();
		
		$table = '#__plugins';
		$query = sprintf('DELETE FROM %s WHERE `element` = %s AND folder = %s',
			$table,
			$database->Quote($name),
			$database->Quote($type));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			return false;
		}
		
		return true;
	}
	
	function deleteModule($name, $type = 'content')
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('DELETE FROM #__modules WHERE `module` = %s',
			$database->Quote($name));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			return false;
		}
		
		$ret = true;
		$moduleDir = AriFileManager::ensureEndWithSlash(JPATH_ROOT) . '/modules/' . $name . '/';
		AriFileManager::deleteFiles($moduleDir);
		
		return $ret;
	}
	
	function isPluginInstalled($name, $type = 'content')
	{
		$database =& JFactory::getDBO();
		
		$table = '#__plugins';
		
		$query = sprintf('SELECT COUNT(*) FROM %s WHERE `element` = %s AND folder = %s',
			$table,
			$database->Quote($name),
			$database->Quote($type));
		$database->setQuery($query);
		$cnt = $database->loadResult();

		if (empty($cnt)) return false;
		
		$pluginDir = 'plugins';
		$pluginPath = AriFileManager::ensureEndWithSlash(JPATH_ROOT) . $pluginDir . '/' . $type . '/' . $name . '.php';
		
		return @file_exists($pluginPath); 
	}
	
	function isModuleInstalled($name)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT COUNT(*) FROM #__modules WHERE `module` = %s',
			$database->Quote($name));
		$database->setQuery($query);
		$cnt = $database->loadResult();
		
		if (empty($cnt)) return false;
		
		$modulePath = AriFileManager::ensureEndWithSlash(JPATH_ROOT) . 'modules/';
		$modulePath .= $name . '/';
		$modulePath .= $name . '.php';
		return @file_exists($modulePath);
	} 
	
	function isRequireFtp()
	{
		jimport('joomla.client.helper');

		return !JClientHelper::hasCredentials('ftp');
	}
}
?>