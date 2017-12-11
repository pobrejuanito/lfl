<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Validators.Validator');

class AriRangeValidatorWebControlConstants extends AriClassConstants
{
	var $DataType = array(
		'Integer' => 0,
		'Float' => 1); 

	function getClassName()
	{
		return strtolower('AriRangeValidatorWebControlConstants');
	}
}

new AriRangeValidatorWebControlConstants();

class AriRangeValidatorWebControl extends AriValidatorWebControl
{	
	function __construct($id, $config)
	{
		$dataTypes = AriConstantsManager::getVar('DataType', AriRangeValidatorWebControlConstants::getClassName());
		
		$this->extendConfig(array('minValue' => null, 'maxValue' => null, 'dataType' => $dataTypes['Integer']));
		parent::__construct($id, $config);
	}
	
	function getDataType()
	{
		return $this->getConfigValue('dataType');
	}
	
	function setDataType($dataType)
	{
		$dataTypes = AriConstantsManager::getVar('DataType', AriRangeValidatorWebControlConstants::getClassName());
		switch ($dataType)
		{
			case $dataTypes['Integer']:
			case $dataTypes['Float']:
				break;
			default:
				$dataType = $dataTypes['Integer'];
		}
		
		$this->setConfigValue('dataType', $dataType);
	}
	
	function getMinValue()
	{
		return $this->getConfigValue('minValue');
	}
	
	function setMinValue($minValue)
	{
		$this->setConfigValue('minValue', $minValue);
	}
	
	function getMaxValue()
	{
		return $this->getConfigValue('maxValue');
	}
	
	function setMaxValue($maxValue)
	{
		$this->setConfigValue('maxValue', $maxValue);
	}
	
	function validate()
	{
		$isValid = true;
		$control =& $this->getControlToValidate();
		
		if ($control && method_exists($control, 'getValidateValue'))
		{
			$value = $control->getValidateValue();
			$isValid = !empty($value) ? is_numeric($value) : true;
			
			if ($isValid && !empty($value))
			{
				// check data type
				$dataType = $this->getDataType();
				$dataTypes = AriConstantsManager::getVar('DataType', AriRangeValidatorWebControlConstants::getClassName());
				switch ($dataType)
				{
					case $dataType['Integer']:
						$isValid = (intval($value) == $value);
						break;
					
					case $dataType['Float']:
						$isValid = (floatval($value) == $value);
						break;
				}

				$len = strlen($value);
				$minValue = $this->getMinValue();
				if ($len > 0 && !is_null($minValue) && $value < $minValue)
				{
					$isValid = false;
				}
		
				$maxValue = $this->getMaxValue();
				if ($len > 0 && !is_null($maxValue) && $value > $maxValue)
				{
					$isValid = false;
				}
			}
		}
		
		$this->setIsValid($isValid);
		
		return $isValid;		
	}

	function _renderJsValidator()
	{
		$ctrlId = $this->getControlToValidateId();
		$minValue = AriJSONHelper::encode($this->getMinValue());
		$maxValue = AriJSONHelper::encode($this->getMaxValue());

		$dataType = $this->getDataType();
		$dataTypes = AriConstantsManager::getVar('DataType', AriRangeValidatorWebControlConstants::getClassName());
		$jsDataType = $dataType == $dataTypes['Float'] ? 'YAHOO.ARISoft.validators.rangeValidatorType.float' : 'YAHOO.ARISoft.validators.rangeValidatorType.int';
		
		$config = array(
			'errorMessage' => $this->getErrorMessage(),
			'validationGroups' => $this->getGroups(),
			'enabled' => $this->getEnabled());
		$jsConfig = AriJSONHelper::encode($config);
echo
		'YAHOO.ARISoft.validators.validatorManager.addValidator(' .
		'	new YAHOO.ARISoft.validators.rangeValidator(\'' . $ctrlId . '\', ' . $minValue . ', ' . $maxValue . ', ' . $jsDataType . ',' . 
				$jsConfig . '))';
	}
}
?>