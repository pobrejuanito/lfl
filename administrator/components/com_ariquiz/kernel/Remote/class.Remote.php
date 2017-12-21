<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Remote.Snoopy');

class AriRemote extends AriObject
{	
	function getRemoteFile($url)
	{
		$snoopy = new Snoopy();
		
		@$snoopy->fetch($url);
		$content = $snoopy->results;
		
		return $content;
	}
}
?>