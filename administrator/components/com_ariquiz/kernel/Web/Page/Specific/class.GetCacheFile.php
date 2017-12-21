<?php
AriKernel::import('Controllers.FileController');
AriKernel::import('Cache.FileCache');

class GetCacheFileAriPage extends AriPageBase 
{
	var $_fileGroup;
	var $_fileTable = null;
	var $_contentType = 'application/octet-stream';
	
	function execute()
	{
		$fileId = AriRequest::getParam('fileId', 0);
		$content = $this->_getFileContent($fileId);
		$this->sendBinaryRespose($content, $this->_contentType);
	}
	
	function _getFileContent($fileId)
	{
		$content = '';
		$cacheDir = AriGlobalPrefs::getCacheDir() . $this->_fileGroup . '/';
		$cacheFile = null;
		if (empty($cacheFile) || !file_exists($cacheFile))
		{
			$fileController = new AriFileController($this->_fileTable);
			$fileList = $fileController->call('getFileList', $this->_fileGroup, array($fileId), true);
			if (!empty($fileList) && count($fileList) > 0)
			{
				$file = $fileList[0];
				$content = $file->Content;

				if (substr($content, 0, 2) == '0x')
					$content = pack('H*', substr($content, 0, 2));

				if (!file_exists($cacheDir . $file->FileId . '.' . $file->Extension))
				{
					AriFileCache::saveBinaryFile($content, $cacheDir . $file->FileId . '.' . $file->Extension);
				}
			}
		}
		else
		{
			$oldMQR = get_magic_quotes_runtime();
			set_magic_quotes_runtime(0);

			$handle = fopen($hotSpotImg, "rb");			 
			$content = fread($handle, filesize($cacheFile));
			fclose($handle);
		
			set_magic_quotes_runtime($oldMQR);
		}
		
		return $content;
	}
}
?>