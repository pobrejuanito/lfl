<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriAlertSummaryValidatorWebControl extends AriObject
{
	var $_id;
	
	function __construct($id)
	{
		$this->setId($id);
		
		$pageHelper =& AriPageHelper::getInstance();
		$currentPage =& $pageHelper->getCurrentPage();
		$currentPage->addControl($this);
	}
	
	function getId()
	{
		return $this->_id;
	}
	
	function setId($id)
	{
		$this->_id = $id;
	}
	
	function render($valGroups = null)
	{
		$pageHelper =& AriPageHelper::getInstance();
		$currentPage =& $pageHelper->getCurrentPage();

		$failedValidators =& $currentPage->getFailedValidators($valGroups);
		if ($failedValidators)
		{
			$errorMessages = array();
			foreach ($failedValidators as $validator)
			{
				$errorMessage = AriWebHelper::translateResValue($validator->getErrorMessageResourceKey());
				$errorMessage = addslashes($errorMessage);
				$errorMessages[] = $errorMessage;
			}
			
			echo '<script type="text/javascript">' .
			'alert("' . join('\\r\\n', $errorMessages) . '")' .
			'</script>'; 
		}
	}
}
?>