<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriString
{
	function strToHex($data) 
	{
  		return array_shift(unpack('H*', $data));
	}
	
	function hexToStr($data)
	{
		$data = str_replace(' ', '', $data);
  		$data = str_replace('\x', '', $data);

  		return pack('H*', $data);
	}
	
	function stripslashes($value)
	{
		$ret = '';
		if (is_string($value)) 
		{
			$ret = stripslashes($value);
		} 
		else 
		{
			if (is_array($value)) 
			{
				$ret = array();
				foreach ($value as $key => $val) 
				{
					$ret[$key] = AriString::stripslashes($val);
				}
			} 
			else 
			{
				$ret = $value;
			}
		}

		return $ret;
	}
	
	function translateParams($inputCharset, $outputCharset, $var, $group = null)
	{
		if ($var === null) return ;
		
		$value = null;
		if ($group == null)
		{
			$value = $var; 
		}
		else if (isset($var[$group]) && is_array($var[$group]))
		{
			$value = $var[$group];
		}
		
		if ($value) AriString::_translateParams($inputCharset, $outputCharset, $value);
		
		return $value;
	}
	
	function _translateParams($inputCharset, $outputCharset, &$value)
	{
		if ($value)
		{
			foreach ($value as $key => $val)
			{
				if (is_array($val))
				{
					AriString::_translateParams($inputCharset, $outputCharset, $val);
					continue;
				}
 				
				$value[$key] = AriString::translateParam($inputCharset, $outputCharset, $val);
			}
		}
	}
	
	function translateParam($inputCharset, $outputCharset, $value)
	{
		return $value;
	}	
}
?>