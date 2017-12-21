<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Toolbar.JToolbar10');
AriKernel::import('Web.Controls.Toolbar.JToolbar15');

class AriToolbarFactory
{
	function createInstance()
	{
		$toolbar = null;
		$toolbar = new AriJToolbar15();
		
		return $toolbar;
	}
}
?>