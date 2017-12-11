<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Document.DocumentHelper');
AriKernel::import('Utils.Utils');

class AriDocumentIncludesManager extends AriObject
{
	var $_initState = null;
	
	function __construct($saveInitState = true)
	{
		if ($saveInitState) 
			$this->saveInitState();
	}
	
	function saveInitState()
	{
		$this->_initState = $this->getCurrentState();
	}

	function getInitState()
	{
		return $this->_initState;
	}
	
	function getCurrentState()
	{
		$currentState = array();
		$document=& JFactory::getDocument();
		if ($document->getType() != 'html') 
			return $currentState; 

		$currentState = $document->getHeadData();

		return $currentState;
	}
	
	function deleteState()
	{
		$this->_initState = null;
	}
	
	function getDifferences($deleteState = true, $exclude = array())
	{
		$differences = array();
		$initState = $this->getInitState();

		$currentState = $this->getCurrentState();
		if ($currentState)
		{
			if (!empty($currentState['styleSheets']) && !in_array('styleSheets', $exclude))
			{
				foreach ($currentState['styleSheets'] as $style => $styleInfo)
				{
					if (!array_key_exists($style, $initState['styleSheets']))
						$differences[] = sprintf('<link rel="stylesheet" href="%s" type="%s" />', $style, AriUtils::getParam($styleInfo, 'mime'));
				}
			}
			
			if (!empty($currentState['scripts']) && !in_array('scripts', $exclude))
			{
				foreach ($currentState['scripts'] as $script => $type)
				{
					if (!array_key_exists($script, $initState['scripts']))
						$differences[] = sprintf('<script type="%s" src="%s"></script>', $type, $script);
				}
			}
			
			if (!empty($currentState['script']) && !in_array('script', $exclude))
			{
				foreach ($currentState['script'] as $type => $script) 
				{
					if (!empty($initState['script'][$type]))
					{
						$difScript = '';
						if (strpos($script, $initState['script'][$type]) === 0)
							$difScript = trim(substr($script, strlen($initState['script'][$type])));
							
						if (!empty($difScript))
							$differences[] = sprintf('<script type="%s">%s</script>', $type, $difScript);
					}
					else
					{
						$differences[] = sprintf('<script type="%s">%s</script>', $type, $script);
					}
				}
			}
			
			if (!empty($currentState['custom']) && !in_array('custom', $exclude))
			{
				foreach ($currentState['custom'] as $customTag)
				{
					if (!in_array($customTag, $initState['custom']))
						$differences[] = $customTag;
				}
			}			
		}

		if ($deleteState) $this->deleteState();

		return $differences;
	}
}
?>