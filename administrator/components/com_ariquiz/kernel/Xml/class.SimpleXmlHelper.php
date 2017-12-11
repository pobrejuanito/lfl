<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriSimpleXmlHelper extends AriObject
{ 
	function &getNode(&$rootNode, $tagName)
	{
		$node = null;
		if (isset($rootNode->$tagName)) $node =& $rootNode->$tagName;

		return $node;
	}
	
	function &getSingleNode(&$rootNode, $tagName)
	{
		$node =& AriSimpleXmlHelper::getNode($rootNode, $tagName);
		if ($node != null && is_array($node))
		{
			$node =& $node[0];
		}
		
		return $node;
	}
	
	function getData(&$rootNode, $tagName, $default = null)
	{
		$node =& AriSimpleXmlHelper::getSingleNode($rootNode, $tagName);
		if (empty($node))
			return $default;
			
		return $node->data();
	}
} 
?>