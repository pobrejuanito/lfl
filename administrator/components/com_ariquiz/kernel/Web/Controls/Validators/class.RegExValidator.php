<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Validators.Validator');

class AriRegExValidatorWebControl extends AriValidatorWebControl
{
	var $_regEx;

	function __construct($id, $regEx, $config)
	{
		$this->setRegEx($regEx);
		$this->extendConfig(array('clientRegEx' => null));
		parent::__construct($id, $config);
	}
	
	function setClientRegEx($regEx)
	{
		$this->setConfifValue('clientRegEx', $regEx);
	}
	
	function getClientRegEx()
	{
		$clientRegEx = $this->getConfigValue('clientRegEx');
		if (is_null($clientRegEx)) $clientRegEx = $this->getRegEx();
		
		return $clientRegEx;
	}
	
	function getRegEx()
	{
		return $this->_regEx;
	}
	
	function setRegEx($regEx)
	{
		$this->_regEx = $regEx;
	}
	
	function validate()
	{
		$isValid = true;
		$control =& $this->getControlToValidate();

		if ($control && method_exists($control, 'getValidateValue'))
		{
			$value = $control->getValidateValue();
			if (!empty($value))
			{
				$regEx = $this->getRegEx();
				$isValid = !(!preg_match($regEx, $value));
			}
		}
		
		$this->setIsValid($isValid);
		
		return $isValid;
	}
	
	function _renderJsValidator()
	{
		$ctrlId = $this->getControlToValidateId();

		$regEx = $this->getClientRegEx();
		
		$config = array(
			'errorMessage' => $this->getErrorMessage(),
			'validationGroups' => $this->getGroups(),
			'enabled' => $this->getEnabled());
		$jsConfig = AriJSONHelper::encode($config);
echo
		'YAHOO.ARISoft.validators.validatorManager.addValidator(' .
		'	new YAHOO.ARISoft.validators.regexpValidator(\'' . $ctrlId . '\', ' . $regEx . ',' . 
				$jsConfig . '))';
	}
}
?>