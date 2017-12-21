<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.WebControl');

class AriListBoxWebControl extends AriWebControl
{
	var $_dataSource = null;
	var $_valueMember;
	var $_textMember;
	var $_selectedValue;
	var $_emptyText = null;
	var $_emptyValue = null;

	function __construct($id, $config = null)
	{
		$this->extendConfig(array('translateText' => true, 'multiple' => false));
		parent::__construct($id, $config);
		if ($this->getStoreState()) $this->setSelectedValue(AriRequest::getParam($this->getName()));
	}
	
	function setEmptyRow($emptyText, $emptyValue = false)
	{		
		$this->_emptyValue = ($emptyValue === false ? $emptyText : $emptyValue);
		$this->_emptyText = $emptyText;
	}

	function dataBind($dataSource, $textMember = null, $valueMember = null)
	{
		$this->_dataSource = $this->_createDataSource($dataSource, $textMember, $valueMember);
		$this->_valueMember = $valueMember;
		$this->_textMember = $textMember;
	}

	function getSelectedValue()
	{
		$ret_val = null;

		if (empty($this->_dataSource) && is_null($this->_emptyValue))
			return $ret_val;
		
		$ret_val = array();
		$isComplex = $this->isMultiple();
		$selValue = $this->_selectedValue;
		if (!is_array($selValue))
			$selValue = array($selValue);

		foreach ($selValue as $value)
		{
			if (isset($this->_dataSource[$value]))
			{
				$ret_val[] = $value;
			}
			else if ($this->_selectedValue == $this->_emptyValue)
			{
				$ret_val[] = $this->_emptyValue;
			}
		}
		
		if (count($ret_val) == 0) $ret_val = null;
		else if (!$isComplex) $ret_val = $ret_val[0];

		return $ret_val;
	}

	function setSelectedValue($selectedValue)
	{
		$this->_selectedValue = $selectedValue;
	}

	function setValue($value)
	{
		$this->setSelectedValue($value);
	}
	
	function _createDataSource($dataSource, $textMember, $valueMember)
	{
		$retDataSource = array();

		if (empty($dataSource)) return $retDataSource;

		reset($dataSource);
		foreach ($dataSource as $key => $item)
		{
			$optionAttrs = array();
			$optPropName = 'OptionAttrs';
			if (is_array($item) && isset($item[$optPropName]))
			{
				$optionAttrs = $item[$optPropName];
			}
			else if (is_object($item) && isset($item->{$optPropName}))
			{
				$optionAttrs = $item->{$optPropName};
			}
			
			$value = $key;
			if (!empty($valueMember))
			{
				if (is_array($item))
				{
					$value = $item[$valueMember];
				}
				else if (is_object($item))
				{
					$value = $item->$valueMember;
				}
			}
			
			$text = $item;
			if (!empty($textMember))
			{
				if (is_array($item))
				{
					$text = $item[$textMember];
				}
				else if (is_object($item))
				{
					$text = $item->$textMember;
				}
			}

			if ($this->getConfigValue('translateText')) $text = AriWebHelper::translateDbValue($text);
			$retDataSource[$value] = array('text' => $text, 'optionAtrrs' => $optionAttrs);
		}

		return $retDataSource;
	}

	function getValidateValue()
	{
		return $this->getSelectedValue();
	}
	
	function isMultiple()
	{
		return $this->getConfigValue('multiple');
	}
	
	function render($attrs = null)
	{
		if (!$this->getVisible()) return '';
		
		$isComplex = $this->isMultiple();
		if ($isComplex)
		{
			if (is_null($attrs)) $attrs = array();
			$attrs['multiple'] = 'multiple';
		}
		
		$attrsHtml = $this->_getAttributeHtml($attrs);
		$ddlOptionsHtml = '';
		$selValue = $this->getSelectedValue();

		if (!is_null($this->_emptyText))
		{
			$emptyValue = !is_null($this->_emptyValue) ? $this->_emptyValue : $this->_emptyText;
			$selected = !$isComplex ? $emptyValue == $selValue : in_array($emptyValue, $selValue);
			$ddlOptionsHtml .= sprintf('<option value="%s"%s>%s</option>',
				$emptyValue,
				$selected ? ' selected="selected"' : '',
				$this->_emptyText);
		}

		if ($this->_dataSource)
		{
			foreach ($this->_dataSource as $key => $value)
			{
				$optAttrs = $value['optionAtrrs'];
				if (!is_array($optAttrs)) $optAttrs = array();

				$optAttrs['value'] = $key;
				if ((!$isComplex && $key == $selValue) || 
					($isComplex && in_array($key, $selValue)))
				{
					$optAttrs['selected'] = 'selected';
				}

				$ddlOptionsHtml .= sprintf('<option %s>%s</option>',
					$this->_getCustomAttributesHtml($optAttrs),
					$value['text']);
			}
		}

		printf('<select %s>%s</select>',
			$attrsHtml,
			$ddlOptionsHtml);
	}	
}
?>