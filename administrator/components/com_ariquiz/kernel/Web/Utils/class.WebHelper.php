<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('GlobalPrefs.GlobalPrefs');
AriKernel::import('Web.Response');
AriKernel::import('String.String');

class AriWebHelper
{
	function prepareRequestValues()
	{
		if (get_magic_quotes_gpc())
		{
			$GLOBALS[ARI_ROOT_NAMESPACE]['OldRequest'] = $_REQUEST;
			reset($_REQUEST);
			$_REQUEST = AriString::stripslashes($_REQUEST);
		}
	}
	
	function restoreRequestValues()
	{
		if (isset($GLOBALS[ARI_ROOT_NAMESPACE]['OldRequest'])) $_REQUEST = $GLOBALS[ARI_ROOT_NAMESPACE]['OldRequest'];
	}
	
	function translateDbValue($value, $htmlSpecialChars = true)
	{
		$dbCharset = AriGlobalPrefs::getDbCharset();
		
		if ($htmlSpecialChars)
			$value = AriWebHelper::htmlSpecialChars($value);
		
		return $value;
	}
	
	function displayDbValue($value, $htmlSpecialChars = true)
	{
		echo AriWebHelper::translateDbValue($value, $htmlSpecialChars);
	}
	
	function displayRealResValue($keyRes)
	{
		$arisI18N =& AriGlobalPrefs::getI18N();
		
		echo $arisI18N->getMessage($keyRes);
	}
	
	function displayResValue($keyRes, $htmlSpecialChars = false)
	{
		echo AriWebHelper::translateResValue($keyRes, $htmlSpecialChars);
	}
	
	function translateResValue($keyRes, $htmlSpecialChars = false)
	{
		$arisI18N =& AriGlobalPrefs::getI18N();
		
		return AriWebHelper::translateDbValue($arisI18N->getMessage($keyRes), $htmlSpecialChars);
	}
	
	function translateAjaxRequestValue($key, $defaultValue = null)
	{
		$dbCharset = AriGlobalPrefs::getDbCharset();
		return AriWebHelper::_translateRequestValue('UTF-8', $dbCharset, $key, $defaultValue);
	}
	
	function translateRequestValue($key, $defaultValue = null)
	{
		$dbCharset = AriGlobalPrefs::getDbCharset();
		return AriWebHelper::_translateRequestValue(AriResponse::getEncoding(), $dbCharset, $key, $defaultValue);
	}
	
	function translateValue($value)
	{
		return $value;
	}
	
	function _translateRequestValue($inputCharset, $outputCharset, $key, $defaultValue = null)
	{
		$value = $defaultValue;
		if (isset($_REQUEST[$key]))
		{
			$value = $_REQUEST[$key];
		}
		
		return $value;
	}
	
	function translateRequestValues($key = null)
	{
		$dbCharset = AriGlobalPrefs::getDbCharset();
		return AriString::translateParams(AriResponse::getEncoding(), $dbCharset, $_REQUEST, $key);
	}
	
	function htmlSpecialChars($value)
	{
		if (!empty($value))
		{
			$transTable = get_html_translation_table(HTML_SPECIALCHARS);
			$transTable['&'] = '&';
			
			$value = strtr($value, $transTable);
		}
		
		return $value;
	}
	
	function cancelAction($task, $params = array())
	{
		global $option;
		
		$url = 'index.php?option=' . $option . '&task=' . $task;
		if ($params && is_array($params))
		{
			foreach ($params as $key => $value)
			{
				$url .= sprintf('&%s=%s', $key, $value);  
			}
		}
		
		AriResponse::redirect($url);
	}
	
	function preCompleteAction($messageId, $params = array())
	{
		global $option;
		
		$url = 'index.php?option=' . $option;
		if ($params && is_array($params))
		{
			foreach ($params as $key => $value)
			{
				$url .= sprintf('&%s=%s', $key, $value);  
			}
		}

		AriResponse::redirect($url . '&arimsg=' . urlencode($messageId));
	}
}
?>