<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Editor');
AriKernel::import('Web.Controls.CheckBox');
AriKernel::import('Web.Controls.ListBox');
AriKernel::import('Web.Controls.TextBox');

class AriWebControlFactory extends AriObject
{
	function &createControl($type, $id, $config = null)
	{
		$control = null;
		if (!class_exists($type)) return $control;

		$control =& new $type($id, $config);
		
		return $control;
	}
}
?>