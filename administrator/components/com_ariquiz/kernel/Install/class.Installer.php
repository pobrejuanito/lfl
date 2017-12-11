<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

define('_ARI_INSTALL_ERROR_EXECUTEQUERY', 'Couldn\'t execute query. Error: %s.');
define('_ARI_INSTALL_ERROR_CHMOD', 'Couldn\'t change permission for directory "%s" permission "%s".');
define('_ARI_INSTALL_SUCCESFULLY', 'Component succesfully installed');
define('_ARI_INSTALL_FAILED', 'Component installation failed');

AriKernel::import('Install.XmlInstaller');
AriKernel::import('File.FileManager');
AriKernel::import('System.System');

class AriInstallerBase extends AriObject
{
	var $option;
	var $adminPath;
	var $_installErrors;
	var $_xmlInstaller;
	
	function __construct($options)
	{		
		$this->bindProperties($options);
		
		$this->basePath = JPATH_ROOT . '/components/' . $this->option . '/';
		$this->adminPath = JPATH_ROOT . '/administrator/components/' . $this->option . '/';
		$this->_xmlInstaller = new AriXmlInstaller();
	}
	
	function errorHandler($errNo, $errStr, $errFile, $errLine)
	{
		parent::errorHandler($errNo, $errStr, $errFile, $errLine);
		
		if ($this->_isError(false, false))
		{
			$this->_installErrors .= "\r\n" . $this->_lastError->error;
			$this->_lastError = null;
		}
	}
	
	function install()
	{
		@set_time_limit(9999);
		@ini_set('display_errors', true);
		error_reporting(E_ALL);
		ignore_user_abort(true);
		
		AriSystem::setOptimalMemoryLimit('16M', '16M', '48M');

		$this->_installErrors = '';
		
		$this->_registerErrorHandler();
		
		$result = $this->installSteps();
		
		restore_error_handler();
		
		return $this->_getInstallationResult();
	}
	
	function isSuccess()
	{
		return empty($this->_installErrors);
	}
	
	function _getInstallationResult()
	{
		$success = empty($this->_installErrors);
		$return = '';
		
		if ($success)
		{ 
			$return = sprintf('<div style="color: green; font-weight: bold; text-align: center;">%s</div>',
				_ARI_INSTALL_SUCCESFULLY);
		}
		else
		{
			$return = sprintf('<div style="color: red; font-weight: bold; text-align: center;">%s</div><div style="color: red;">%s</div>',
				_ARI_INSTALL_FAILED,
				$this->_installErrors);
		}
		
		return $return;
	}
	
	function installSteps()
	{
		return true;
	}
	
	function isDbSupportUtf8()
	{
		$database =& JFactory::getDBO();
		
		$query = 'SHOW CHARACTER SET LIKE "utf8"';
		$database->setQuery($query);
		$result = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			$error = sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, 
				$database->getErrorMsg());
			trigger_error($error, E_USER_ERROR);
			return false;			
		}
		
		return (!empty($result) && count($result) > 0);
	}

	function doInstallFile($file)
	{
		$this->_xmlInstaller->doInstallFile($file, $this->option);
	}
	
	/*
	 $dirForChmod = array(
			$adminPath . 'cache/files' => 0777,
			$adminPath . 'cache/files/thumb' => 0777, 
			$adminPath . 'cache/files/lbackend' => 0777,
			$adminPath . 'cache/files/i18n/lbackend' => 0777); 
	 */
	function setPermissions($dirForChmod)
	{
		$errors = array();
		foreach ($dirForChmod as $dir => $perm)
		{
			if (!AriFileManager::setPermissions($dir, $perm))
			{
				$errors[] = sprintf(_ARI_INSTALL_ERROR_CHMOD, $dir, $perm); 
			}
		}
		
		if (count($errors) > 0)
		{
			trigger_error(join("\r\n", $errors), E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	/*
	 * $menuInfo = array({'link', 'image'}, ...)
	 */
	function updateMenuIcons($menuInfo)
	{
		$database =& JFactory::getDBO();
		
		$queryList = array();
		foreach ($menuInfo as $menuInfoItem)
		{
			$link = $menuInfoItem['link'];
			$img = $menuInfoItem['image'];
			
			$queryList[] = sprintf('UPDATE #__components' .
			  	' SET admin_menu_img=%s' .
			  	' WHERE admin_menu_link=%s',
				$database->Quote($img),
				$database->Quote($link)); 
		}

		$database->setQuery(join($queryList, ';'));
		$database->queryBatch();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	/*
		$mambots = array(
			'arithumb' => 
				array('name' => 'ARI Thumbnail',
				'folder' => 'content', 
				'files' => array('modules/mod_arithumbnail/mod_arithumbnail.php', 'modules/mod_arithumbnail/mod_arithumbnail.xml')));
	*/
	function installMambots($mambots)
	{
		$database =& JFactory::getDBO();
		
		$sysFolder = 'plugins';
		$sysTable = '#__plugins';
		$existsMambots = array();
		foreach ($mambots as $key => $value)
		{
			$existsMambots[] = "'" . $key . "'";
		}
				
		if (!empty($existsMambots))
		{
			$query = sprintf('SELECT DISTINCT element FROM ' . $sysTable . ' WHERE element IN (%s)', join(',', $existsMambots));
			$database->setQuery($query);
			$existsMambots = $database->loadResultArray();
		}
		
		if (empty($existsMambots)) $existsMambots = array();

		$query =
			'INSERT INTO `' . $sysTable . '` (`name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES ("%s", "%s", "%s", 0, 2, 1, 0, 0, 0, "0000-00-00 00:00:00", "")';
		$queryList = array();
		$notExistsMambots = array();
		foreach ($mambots as $key => $value)
		{
			if (!in_array($key, $existsMambots))
			{
				$notExistsMambots[] = $key;
				$queryList[] = sprintf($query, $value['name'], $key, $value['folder']);
			}
		}
		
		$database->setQuery(join($queryList, ';'));
		$database->queryBatch();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			return false;
		}
		
		$files = array();
		foreach ($mambots as $key => $value)
		{
			$mambotFiles = $value['files'];
			$files[$key] = array('folder' => $value['folder'], 'files' => $mambotFiles); 
		}

		$baseBotDir = JPATH_ROOT . '/' . $sysFolder . '/';
		foreach ($files as $key => $value)
		{
			$files = $value['files'];
			$folder = $value['folder'];
			
			$botDir = $baseBotDir . $folder . '/';

			foreach ($files as $file)
			{
				$fileName = basename($file);
				$mambotPath = $botDir . $fileName;
				if (@file_exists($mambotPath)) @AriFileManager::deleteFile($mambotPath);
				
				@AriFileManager::copy($this->adminPath . $file, $mambotPath);
				if (!@file_exists($mambotPath))
				{
					//return false;
				}
			}
		}

		return true;
	}

	function installModule($modulePath)
	{
		jimport( 'joomla.installer.installer' );

		$installer = new JInstaller();

		$installer->setOverwrite(true);
		$installer->install($modulePath);
	
		return true;
	}
	
	function _isColumnExists($table, $column)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SHOW COLUMNS FROM %s LIKE "%s"',
			$table,
			$column);
		$database->setQuery($query);
		$columnsList = $database->loadObjectList();
		$isColumnExists = (!empty($columnsList) && count($columnsList) > 0);
		
		return $isColumnExists; 
	}

	function _isIndexExists($table, $index)
	{
		$database =& JFactory::getDBO();
		
		$query = 'SHOW INDEX FROM ' . $table;
		$database->setQuery($query);
		$keys = $database->loadAssocList();
		if (is_array($keys))
		{
			foreach ($keys as $keyInfo)
			{
				if (isset($keyInfo['Key_name']) && $keyInfo['Key_name'] == $index)
				{
					return true;
				}
			}
		}
		
		return false;
	}
	
	function _applyUpdates($version)
	{
		$updateSig = '_updateTo_';
		$lowerUpdateSig = strtolower($updateSig);
		$methods = get_class_methods(get_class($this));
		$updateMethods = array();
		
		foreach ($methods as $method)
		{
			$lowerMethod = strtolower($method);
			if (strpos($lowerMethod, $lowerUpdateSig) === 0)
			{
				$methodVer = str_replace(array($updateSig, $lowerUpdateSig, '_'), array('', '', '.'), $method);
				if (version_compare($methodVer, $version, '>'))
				{
					$updateMethods[$methodVer] = $method;
				}
			}
		}
		
		if (count($updateMethods) > 0)
		{
			uksort($updateMethods,  'version_compare');
			
			foreach ($updateMethods as $updateMethod)
			{
				$this->$updateMethod();
			}
		}
	}
}
?>