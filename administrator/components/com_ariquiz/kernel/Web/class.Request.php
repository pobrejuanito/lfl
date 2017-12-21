<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Utils.Utils');

class AriRequest 
{
	function getIP()
	{
		$ip = getenv('HTTP_X_FORWARDED_FOR')
    		? getenv('HTTP_X_FORWARDED_FOR')
    		: getenv('REMOTE_ADDR');

    	return $ip;
	}
	
	function getParam($name, $defValue = null, $mask = 0)
	{
		$input = $_REQUEST;
		if (strpos($name, '[') !== false)
		{
			$matches = array();
			if (preg_match('/([^[=&;]+)\[([^\]]+)/', $name, $matches))
			{
				$input = isset($_REQUEST[$matches[1]]) ? $_REQUEST[$matches[1]] : array();
				$name = $matches[2];
			}
		}
		
		return AriUtils::getFilteredParam($input, $name, $defValue, $mask);
	}
	
	function getCurrentDomain($normalize = true) 
	{
		$domain = '';
		if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']) 
		{
			$domain = $_SERVER['HTTP_HOST'];
		} 
		elseif (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME']) 
		{
			$domain = $_SERVER['SERVER_NAME'];
		} 
		else 
		{
			$domain = JURI::root(false);
		}
		
		if ($normalize)
		{
			$domain = AriRequest::normalizeDomain($domain);
		}

		return $domain;
	}
	
	function normalizeDomain($domain)
	{
		if (!empty($domain))
		{
			$urlParts = parse_url($domain);
			$domain = isset($urlParts['host']) ? $urlParts['host'] : $urlParts['path'];
			$domain = strtolower($domain);
			if (strpos($domain, "www.") === 0) $domain = substr($domain, 4);
		}
		
		return $domain;
	}
}
?>
