<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('File.FileManagerInterfaces.FileManagerBase');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class AriJ15FileManagerProvider extends AriFileManagerBaseProvider
{
	function setPermissions($path, $mode = 0777)
	{
		$ret = @chmod($path, $mode);
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp'); 
		
		if (!$ret || $FTPOptions['enabled'] == 1) 
		{ 
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);
			$ret = $ftp->chmod($path, $mode); 
		}

		return $ret;
	}
	
	function deleteFolder($path)
	{
		return JFolder::delete($path);
	}
	
	function deleteFile($path)
	{
		return JFile::delete($path);
	}
	
	function copy($src, $dest, $path = null)
	{
		return JFile::copy($src, $dest, $path);
	}
	
	function move($src, $dest, $path = '')
	{
		return JFile::move($src, $dest, $path);
	}
	
	function createFolder($path, $mode = 0755)
	{
		return JFolder::create($path, $mode);
	}
}
?>