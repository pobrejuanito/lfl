<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.JSON.JSONHelper');

class AriDataTableControlColumnConstants extends AriClassConstants
{
	var $Formatter = array(
		'Button' => 'YAHOO.widget.DataTable.formatButton',
		'Checkbox' => 'YAHOO.widget.DataTable.formatCheckbox',
		'Currency' => 'YAHOO.widget.DataTable.formatCurrency',
		'Date' => 'YAHOO.widget.DataTable.formatDate',
		'Dropdown' => 'YAHOO.widget.DataTable.formatDropdown',
		'Email' => 'YAHOO.widget.DataTable.formatEmail',
		'Link' => 'YAHOO.widget.DataTable.formatLink',
		'Number' => 'YAHOO.widget.DataTable.formatNumber',
		'Radio' => 'YAHOO.widget.DataTable.formatRadio',
		'Text' => 'YAHOO.widget.DataTable.formatText',
		'Textarea' => 'YAHOO.widget.DataTable.formatTextarea',
		'Textbox' => 'YAHOO.widget.DataTable.formatTextbox',
		'TheadCell' => 'YAHOO.widget.DataTable.formatTheadCell');
	
	function getClassName()
	{
		return strtolower('AriDataTableControlColumnConstants');
	}
}

new AriDataTableControlColumnConstants(); 

class AriDataTableControlColumn extends AriObject 
{
	var $_configProps = array(
		'key' => null,
		'label' => null,
		'sortable' => false,
		'resizable' => false,
		'formatter' => null,
		'minWidth' => null,
		'hidden' => false,
		'width' => null,
		'sortOptions' => null,
		'className' => ''
	);
	
	var $_ignoredProps = array('headerWidth');
	
	function __construct($config)
	{
		$this->bindConfig($config);
	}
	
	function getDef()
	{
		$jsDef = array();
		foreach ($this->_configProps as $key => $value)
		{
			if (in_array($key, $this->_ignoredProps)) continue;
			$isNeedEncode = ($key != 'formatter' || empty($value));
			$jsDef[] = $key . ': ' . ($isNeedEncode ? AriJSONHelper::encode($value) : $value);
		}
		
		return '{' . join(',', $jsDef) . '}';
	}
}
?>
