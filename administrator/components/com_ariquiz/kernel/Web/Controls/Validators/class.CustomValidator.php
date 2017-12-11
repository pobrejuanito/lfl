<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Validators.Validator');

class AriCustomValidatorWebControl extends AriValidatorWebControl
{
	var $_validateMethod;
	
	function __construct($id, &$validateMethod, $config)
	{
		$this->_validateMethod =& $validateMethod;
		
		$this->extendConfig(array('clientValidateFunc' => null, 'emptyValidate' => true));
		parent::__construct($id, $config);
	}
	
	function getClientValidateFunc()
	{
		return $this->getConfigValue('clientValidateFunc');
	}
	
	function validate()
	{
		$isValid = call_user_func($this->_validateMethod, $this);
		$this->setIsValid($isValid);

		return $isValid;
	}
	
	function _renderJsValidator()
	{
		$ctrlId = $this->getControlToValidateId();
		$clientValidateFunc = $this->getClientValidateFunc();
		$config = array(
			'emptyValidate' => $this->getConfigValue('emptyValidate'),
			'errorMessage' => $this->getErrorMessage(),
			'validationGroups' => $this->getGroups(),
			'enabled' => $this->getEnabled());
		$jsConfig = AriJSONHelper::encode($config);
		
echo
		'YAHOO.ARISoft.validators.validatorManager.addValidator(' .
		'	new YAHOO.ARISoft.validators.customValidator(\'' . $ctrlId . '\',' .
				$clientValidateFunc . ',' .
				$jsConfig . '))';
	}
}
?>