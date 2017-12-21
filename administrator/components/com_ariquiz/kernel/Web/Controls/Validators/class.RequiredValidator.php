<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Validators.Validator');
AriKernel::import('Web.JSON.JSONHelper');

class AriRequiredValidatorWebControl extends AriValidatorWebControl
{
	function validate()
	{
		$isValid = true;
		$control =& $this->getControlToValidate();
		
		if ($control && method_exists($control, 'getValidateValue'))
		{
			$value = $control->getValidateValue();
			$isValid = (strlen(trim($value)) > 0);
		}
		
		$this->setIsValid($isValid);
		
		return $isValid;
	}
	
	function _renderJsValidator()
	{
		$ctrlId = $this->getControlToValidateId();
		$config = array(
			'errorMessage' => $this->getErrorMessage(),
			'validationGroups' => $this->getGroups(),
			'enabled' => $this->getEnabled());
		$jsConfig = AriJSONHelper::encode($config);
echo
		'YAHOO.ARISoft.validators.validatorManager.addValidator(' .
		'	new YAHOO.ARISoft.validators.requiredValidator(\'' . $ctrlId . '\',' . $jsConfig . '))';
	}
}
?>