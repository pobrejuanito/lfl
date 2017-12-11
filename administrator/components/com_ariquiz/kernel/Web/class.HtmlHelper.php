<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriHtmlHelper extends AriObject 
{
	function getAttrStr($attrs, $leadSpace = true)
	{
		$str = '';
		
		if (empty($attrs) || !is_array($attrs)) return $str;
		
		$str = array();
		foreach ($attrs as $key => $value)
		{
			if (is_null($value)) continue;
			
			if (is_array($value))
			{
				$subAttrs = array();
				foreach ($value as $subKey => $subValue)
				{
					if (is_null($subValue)) continue;
					
					$subAttrs[] = sprintf('%s:%s',
						$subKey,
						str_replace('"', '\\"', $subValue));
				}
				
				if (count($subAttrs) > 0)
				{
					$str[] = sprintf('%s="%s"',
						$key,
						join(';', $subAttrs));
				}
			}
			else
			{
				$str[] = sprintf('%s="%s"',
					$key,
					str_replace('"', '\\"', $value));
			}
		}
		
		$str = join(' ', $str);
		if (!empty($str) && $leadSpace) $str = ' ' . $str;

		return $str;
	}
}
?>