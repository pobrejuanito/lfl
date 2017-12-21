<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.WebControl');

class AriCheckBoxWebControl extends AriWebControl
{
	var $_checked = false;

	function __construct($id, $config = null)
	{
		parent::__construct($id, $config);
		if ($this->getStoreState())
		{
			$value = AriRequest::getParam($this->getName());
			$this->setChecked(!empty($value));
		}
	}

	function getChecked()
	{
		return $this->_checked;
	}

	function setChecked($checked)
	{
		$this->_checked = $checked;
	}

	function setValue($value)
	{
		$this->setChecked(AriUtils::parseValueBySample($value, true));
	}
	
	function getValidateValue()
	{
		return $this->getChecked();
	}

	function render($attrs = null)
	{
		if (!$this->getVisible()) return '';

		$renderAttrs =  
			array(
				'type' => 'checkbox');
		if ($this->getChecked()) $renderAttrs['checked'] = 'true';
		$renderAttrs = array_merge($renderAttrs, $attrs);
		$attrsHtml = $this->_getAttributeHtml($renderAttrs);
		
		printf('<input %s />', $attrsHtml);
	}
}
?>