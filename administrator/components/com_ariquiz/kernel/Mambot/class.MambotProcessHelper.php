<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriMambotProcessHelper extends AriObject
{
	function processMambotTags($content, $addOutputContent = false, $exclude = array())
	{
		if (empty($content)) return $content;
		
		if ($addOutputContent)
		{
			@ob_start();
		}
		$preContent = '';

		{
			// Hack
			if (!class_exists('JDate')) $d = JFactory::getDate(); 

			$oldHeadData = null;
			if ($addOutputContent)
			{
				$document=& JFactory::getDocument();
				if($document->getType() == 'html') 
				{
					$oldHeadData = $document->getHeadData();		
				}
			}
			
			$content = AriMambotProcessHelper::processJ15MambotTag($content);
			
			if ($addOutputContent)
			{
				$document=& JFactory::getDocument();
				if($document->getType() == 'html') 
				{
					$newHeadData = $document->getHeadData();
					$newScript = isset($newHeadData['script']) && !in_array('script', $exclude) ? $newHeadData['script'] : array();
					$newScripts = isset($newHeadData['scripts']) && !in_array('scripts', $exclude) ? $newHeadData['scripts'] : array();
					$newCustom = isset($newHeadData['custom']) && !in_array('custom', $exclude) ? $newHeadData['custom'] : array();
					if (!empty($newScript) || !empty($newScripts) || !empty($newCustom))
					{
						if (empty($oldHeadData)) $oldHeadData = array();
						
						$oldScript = isset($oldHeadData['script']) ? $oldHeadData['script'] : array();
						$oldScripts = isset($oldHeadData['scripts']) ? $oldHeadData['scripts'] : array();
						$oldCustom = isset($oldCustom['custom']) ? $oldCustom['custom'] : array();
						foreach ($newScripts as $script => $scriptType)
						{
							if (!array_key_exists($script, $oldScripts))
							{
								$preContent .= sprintf('<script type="%s" src="%s"></script>', $scriptType, $script);
							}
						}
						
						foreach ($newScript as $script)
						{
							if (!in_array($script, $oldScript))
							{
								$preContent .= sprintf('<script type="text/javascript">%s</script>', $script);
							}
						}
						
						foreach ($newCustom as $customTag)
						{
							if (preg_match('~(<script.+?</script>)~si', $customTag) && !in_array($customTag, $oldCustom))
							{
								$preContent .= $customTag;
							}
						}
					}
				}
			}
		}

		
		if ($addOutputContent)
		{
			$content = @ob_get_contents() . $content;
			@ob_end_clean();
		}
		
		$content = $preContent . $content;

		return $content;
	}
	
	function processJ10MambotTag($content, $params = null)
	{
		global $_MAMBOTS;
		$_MAMBOTS->loadBotGroup('content');

		$isObject = is_object($content);
		
		if (is_null($params))
		{
			$params = new mosParameters('');
		}

		$row = $content;
		if (!$isObject)
		{
			$row = new stdClass();
			$row->title = '';
			$row->text = $content;
		}

		$results = $_MAMBOTS->trigger('onPrepareContent', array(&$row, &$params, 0), true);
		
		return $isObject ? $row : $row->text;
	}
	
	function processJ15MambotTag($content, $params = null)
	{
		$dispatcher	=& JDispatcher::getInstance(); 
		JPluginHelper::importPlugin('content', null, true);
		if (is_null($params) && !J1_6)
		{
			$params = new JParameter('');
		}
		
		$isObject = is_object($content);
		
		$row = $content;
		if (!$isObject)
		{
			$row = new stdClass();
			$row->title = '';
			$row->text = $content;
		} 

		if (!J1_6)
			$dispatcher->trigger('onPrepareContent', array(&$row, &$params, 0), true);
		else 
			$dispatcher->trigger('onContentPrepare', array('com_ariquiz.question', &$row, &$params, 0), true);
		
		return $isObject ? $row : $row->text;
	}
	
	function processArticle($row)
	{
		$params = AriMambotProcessHelper::createParams();
		$params->def('image', 1);
		$params->def('intro_only', 1);

		$modRow = clone($row);
		$modRow->text = $row->introtext;
		$modRow = AriMambotProcessHelper::processJ15MambotTag($modRow, $params);
		
		$introText = $modRow->text;
		$modRow = clone($row);

		$params->set('intro_only', 0);
		$modRow->text = $row->fulltext;
		$modRow = AriMambotProcessHelper::processJ15MambotTag($modRow, $params);

		$row->introtext = $introText;
		$row->fulltext = $modRow->text;

		return $row;
	}
	
	function createParams()
	{
		$params = new JParameter('');
		
		return $params;
	}
}
?>