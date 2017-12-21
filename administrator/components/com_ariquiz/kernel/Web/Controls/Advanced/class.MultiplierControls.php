<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.JSON.JSON');

class WebControls_MultiplierControls
{
	function getData($containerId, $keys, $idKey = null, $stripSlashes = false)
	{
		$i = 0;
		$data = array();

		while (WebControls_MultiplierControls::isSetTemplateItem($containerId, $i))
		{
			$dataItem = array();

			if (!empty($keys))
			{
				foreach ($keys as $key)
				{
					$itemKey = WebControls_MultiplierControls::getTemplateItemKey($key, $i);
					$dataItem[$key] = null;
					if (isset($_REQUEST[$itemKey]))
					{
						$dValue = $_REQUEST[$itemKey];
						if ($stripSlashes && get_magic_quotes_gpc())
						{
							$dValue = stripslashes($dValue);
						}
						
						$dataItem[$key] = $dValue;
					}
					else if (isset($_FILES[$itemKey]))
					{
						$dataItem[$key] = $_FILES[$itemKey];
					}
				}
			}

			$itemIdKey = !empty($idKey) ? WebControls_MultiplierControls::getTemplateItemKey($idKey, $i) : null;
			if (!empty($itemIdKey) && isset($dataItem[$itemIdKey]))
			{
				$data[$dataItem[$itemIdKey]] = $dataItem;
			}
			else
			{
				$data[] = $dataItem;
			}

			++$i;
		}

		return $data;
	}

	function isSetTemplateItem($containerId, $index)
	{
		return isset($_REQUEST[$containerId . '_hdnstatus_' . $index]);
	}

	function getTemplateItemKey($key, $index)
	{
		return $key . '_' . $index;
	}
	
	function dataToJson($data)
	{
		$jsonHandler = new Services_JSON();

		return $jsonHandler->encode($data); 
	}
}
?>