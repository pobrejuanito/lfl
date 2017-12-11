<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('SimpleTemplate.SimpleTemplate');

class AriTextTemplateEntity extends AriDBTable 
{
	var $TemplateId;
	var $BaseTemplateId;
	var $TemplateName;
	var $Value;
	var $Created;
	var $CreatedBy = 0;
	var $Modified = null;
	var $ModifiedBy = 0;
	var $Params = null;
	
	function AriTextTemplateEntity(&$_db, $tableName) 
	{
		$this->AriDBTable($tableName, 'TemplateId', $_db);
	}
	
	function parse($params = array())
	{
		$value = $this->Value;
		/*
		$search = array();
		$replace = array();
		
		if (!empty($params))
		{
			foreach ($params as $key => $val)
			{
				if (!is_array($val))
				{
					$search[] = sprintf('{$%s}', $key);
					$replace[] = $val;
				}
				else
				{
					foreach ($val as $subKey => $subVal)
					{
						$search[] = sprintf('{$%s:%s}', $key, $subKey);
						$replace[] = $subVal;
					}
				}
			}
		}
		
		$value = str_replace($search, $replace, $value);*/
		$value = AriSimpleTemplate::parse($value, $params);
		
		return $value;
	}	
}
?>