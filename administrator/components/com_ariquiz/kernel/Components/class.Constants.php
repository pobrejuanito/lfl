<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriComponentConstants extends AriObject
{
	function __construct()
	{
		if (isset($this->Option)) AriConstantsManager::registerConstantsObject($this, $this->Option);
	}
}
?>