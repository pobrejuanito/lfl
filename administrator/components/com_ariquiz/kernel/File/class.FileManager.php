<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriFileManager extends AriObject
{
	function &getInterface()
	{
		static $interface;
		
		if (is_null($interface))
		{
			AriKernel::import('File.FileManagerInterfaces.J15FileManager');
			$interface = new AriJ15FileManagerProvider();
		}
		
		return $interface;
	}
	
	function ensureDirExists($filePath, $baseDir, $mode = 0777)
	{
		$interface =& AriFileManager::getInterface(); 
		
		return $interface->ensureDirExists($filePath, $baseDir, $mode);
	}
	
	function deleteFiles($path, $recursive = true, $delSubDirs = true, $delRoot = true)
	{
		$interface =& AriFileManager::getInterface(); 
		
		return $interface->deleteFiles($path, $recursive, $delSubDirs, $delRoot);
	}
	
	function ensureEndWithSlash($dir)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->ensureEndWithSlash($dir);
	}
	
	function getImageFileList($dir, $recursive = false, $exts = null)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->getImageFileList($dir, $recursive, $exts);
	}
	
	function getFolderList($dir, $recursive = false, $fullPath = false)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->getFolderList($dir, $recursive, $fullPath);
	}
	
	function getFileList($dir, $recursive = false, $exts = null)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->getFileList($dir, $recursive, $exts);
	}
	
	function createFolder($path, $mode = 0755)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->createFolder($path, $mode);
	}
	
	function move($src, $dest, $path = '')
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->move($src, $dest); 
	}
	
	function copy($src, $dest, $path = null)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->copy($src, $dest); 
	}
	
	function deleteFile($path)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->deleteFile($path);
	}
	
	function setPermissions($path, $mode = 0777)
	{
		$interface =& AriFileManager::getInterface();
		
		return $interface->setPermissions($path, $mode);
	}
}
?>
