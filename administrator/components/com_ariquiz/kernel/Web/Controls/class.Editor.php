<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.WebControl');

class AriEditorWebControl extends AriWebControl
{
	var $_text;
	
	function __construct($id, $config = null)
	{
		$this->extendConfig(
			array(
				'translateText' => true,
				'trimValue' => true,
				'maxLength' => null));
		parent::__construct($id, $config);

		//if ($this->getStoreState()) $this->setText(AriRequest::getParam($this->getName()));
	}
	
	function setValue($value)
	{
		$this->setText($value);
	}
	
	function setText($text)
	{
		$this->_text = $text;
	}

	function getText()
	{
		$text = $this->isTrimValue() ? trim($this->_text) : $this->_text;
		$maxLength = $this->getMaxLength();
		if (!is_null($maxLength)) $text = substr($text, 0, $maxLength);
		
		return $text;
	}

	function getMaxLength()
	{
		return $this->getConfigValue('maxLength');
	}

	function setMaxLength($maxLength)
	{
		$this->setConfigValue('maxLength', $maxLength);
	}

	function isTrimValue()
	{
		return $this->getConfigValue('trimValue');
	}
	
	function setIsTrimValue($isTrimValue)
	{
		$this->setConfigValue('trimValue', $isTrimValue ? true : false);
	}
	
	function getValidateValue()
	{
		return $this->getText();
	}

	function getContent()
	{
			$correctedName = $this->getCorrectedName();
			$editor =& JFactory::getEditor();
			$content = $editor->getContent($correctedName);
			
			$content = str_replace('tinyMCE.getContent()', sprintf('tinyMCE.getContent("%s")', $correctedName), $content);
			$content = str_replace('tinyMCE.activeEditor.getContent()', sprintf('tinyMCE.get("%s").getContent()', $correctedName), $content);
			$content = str_replace(
				sprintf('JContentEditor.getContent(\'%s\')', $correctedName), 
				sprintf('(tinyMCE.get("%s") ? tinyMCE.get("%1$s").getContent() : JContentEditor.getContent(\'%1$s\'))', $correctedName),
				$content);
			
			return $content;
	}
	
	function getCorrectedName()
	{
		return str_replace(array('[', ']'), array('_', ''), $this->getName());
	}
	
	function render($attrs = null)
	{
		$width = AriUtils::getParam($attrs, 'width', '100%;');
		$height = AriUtils::getParam($attrs, 'height', '250');
		$rows = AriUtils::getParam($attrs, 'rows', '20');
		$cols = AriUtils::getParam($attrs, 'cols', '60');
		
			$ctrlName = $this->getName();
			$needHack = (strpos($ctrlName, '[') !== false);
			$correctedCtrlName = $this->getCorrectedName();

			$editor =& JFactory::getEditor();
			echo $editor->display(
				$correctedCtrlName, 
				$this->getText(),
				$width,
				$height,
				$cols,
				$rows);
				
			if ($needHack)
			{
				printf('<textarea name="%1$s" id="%2$s" style="display: none !important;"></textarea>',
					$ctrlName,
					$this->getId());
				$document =& JFactory::getDocument();
				$document->addScriptDeclaration(sprintf('window.addEvent("domready", function() {
					var oldSubmitHandler = %3$s;
					%3$s = function() {
						$("%1$s").value = %2$s;
						oldSubmitHandler.apply(this, arguments);
					}
				});',
				$this->getId(),
				$this->getContent(),
				J1_6 ? 'Joomla.submitform' : 'submitform'));
			}
	}
}
?>