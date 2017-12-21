<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriClassConstants extends AriObject
{
	function __construct()
	{
		$className = strtolower(get_class($this));
		AriConstantsManager::registerConstantsObject($this, $className);
	}
}
?>