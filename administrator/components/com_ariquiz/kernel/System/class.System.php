<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriSystem extends AriObject
{
	function setOptimalMemoryLimit($init, $step = null, $max = null)
	{
		$ret = true;
		
		$firstStepSize = $stepSize = AriSystem::parseFileSize($step);
		$initSize = AriSystem::parseFileSize($init);
		$maxSize = AriSystem::parseFileSize($max);
		
		$currentLimit = AriSystem::getMemoryLimit();
		if ($initSize < $currentLimit)
		{ 
			if ($stepSize > 0 && $maxSize > 0)
			{
				$firstStepSize += $initSize;
				while ($firstStepSize < $currentLimit) $firstStepSize += $stepSize;
				$firstStepSize -= $currentLimit;
			}

			$initSize = $currentLimit;			
		}
		else
		{
			$ret = @ini_set('memory_limit', $init);
		}

		if (is_null($max) || (is_null($step) && $maxSize < $initSize)) return $ret;
		if (is_null($step)) return @ini_set('memory_limit', $max);

		$initSize += $firstStepSize;
		
		while ($initSize < $maxSize)
		{
			$ret = @ini_set($initSize);
			$initSize += $stepSize;
		}
		
		return @ini_set('memory_limit', $max);
	}

	function getMemoryLimit()
	{
		$memoryLimit = trim(@ini_get('memory_limit'));
		
		return AriSystem::parseFileSize($memoryLimit); 
	}
	
	function parseFileSize($size)
	{
		if ($size)
		{
			$measure = strtolower($size{strlen($size) - 1});
			$size = @intval($size, 10);
			switch($measure) 
			{
				case 'g':
					$size *= 1024 * 1024 * 1024;
					break;
				case 'm':
					$size *= 1024 * 1024;
					break;
				case 'k':
					$size *= 1024;
					break;
			}
		}
		else
		{
			$size = 0;
		}
		
		return $size;
	}
}
?>