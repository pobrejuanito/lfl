<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriConstantsManager
{
	function getVar($varName, $namespace)
	{
		static $constCache;

		$nullVal = null;
		if (isset($constCache[$namespace][$varName])) return $constCache[$namespace][$varName];

		$consts =& AriConstantsManager::_getConstantsObject($namespace);
		if ($consts == null) return $nullVal;

		$varParts = explode('.', $varName);
		$val = $varParts[0];
		if (!isset($consts->$val)) return $nullVal;
		 
		$val =& $consts->$val;
		array_shift($varParts);
		
		foreach ($varParts as $part)
		{
			if (!isset($val[$part])) return $nullVal;
			$val =& $val[$part];
		}
		
		if (!isset($constCache[$namespace])) $constCache[$namespace] = array();
		$constCache[$namespace][$varName] = $val;
		
		return $val;
	}

	function &_getConstantsObject($namespace)
	{
		static $constObjCache;
		
		$null = null;
		if (empty($namespace)) return $null;
		
		if (!isset($constObjCache[$namespace]))
		{
			if (!isset($GLOBALS[ARI_ROOT_NAMESPACE][ARI_CONSTANTS_NAMESPACE][$namespace])) return $null;

			$constObjCache[$namespace] =& $GLOBALS[ARI_ROOT_NAMESPACE][ARI_CONSTANTS_NAMESPACE][$namespace];
		}

		return $constObjCache[$namespace];
	}
	
	function registerConstantsObject(&$obj, $namespace)
	{
		if (!empty($namespace))
		{
			$GLOBALS[ARI_ROOT_NAMESPACE][ARI_CONSTANTS_NAMESPACE][$namespace] =& $obj;
		}
	}
}
?>