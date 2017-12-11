<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Utils.Utils');

class AriSimpleTemplate extends AriObject
{
	function &getFilterStore()
	{
		static $filterStore = null;
		
		if ($filterStore == null)
		{
			$filterStore = new AriSimpleTemplateFilterStore();
		}
		
		return $filterStore;
	}
	
	function registerFilter($name, $filter)
	{
		$store =& AriSimpleTemplate::getFilterStore();
		$store->registerFilter($name, $filter);
	}
	
	function applyFilter($name, $value, $params = null)
	{
		$store =& AriSimpleTemplate::getFilterStore();
		
		return $store->applyFilter($name, $value, $params);
	}
	
	function parse($template, $params)
	{
		if (empty($params)) return $template;
		
		$paramsRegExp = '/\{\$([^}\|]+)((\|[^}\|]+)*)}/si';
		
		$matches = array();
		@preg_match_all($paramsRegExp, $template, $matches, PREG_SET_ORDER);

		if (empty($matches)) return $template;

		$search = array();
		$replace = array();
		foreach ($matches as $match)
		{
			$value = AriSimpleTemplate::getParamValue($match[1], $params);
			if (is_null($value)) continue;
			
			if (!empty($match[2])) $value = AriSimpleTemplate::applyFilters($value, $match[2]);

			$search[] = $match[0];
			$replace[] = $value;
		}

		return str_replace($search, $replace, $template);
	}
	
	function applyFilters($value, $filterStr)
	{
		$filters = explode('|', $filterStr);
		if (empty($filters)) return $value;
		
		foreach ($filters as $filter) 
		{
			if (empty($filter)) continue;
			
			$filterInfo = preg_split('/(?<!\\\):/', $filter);
			
			$filterName = $filterInfo[0];
			array_shift($filterInfo);
			
			$filterInfo = array_map(array('AriSimpleTemplate', 'modifyFilterParam'), $filterInfo);
			
			$value = AriSimpleTemplate::applyFilter($filterName, $value, $filterInfo);
		}
		
		return $value;
	}
	
	function getParamValue($key, $params)
	{
		$value = null;
		
		if (!$key) return $value;
		
		$keys = array();
		if (strpos($key, ':') !== false)
		{
			$keys = explode(':', $key);
		}
		else
		{
			$keys = array($key);
		}
		
		$value = $params;
		foreach ($keys as $cKey)
		{
			$value = AriUtils::getParam($value, $cKey, null);

			if (is_null($value)) break;
		}
		
		if (is_array($value)) $value = null;

		return $value;
	}
	
	function modifyFilterParam($param)
	{
		return str_replace('\\:', ':', $param);
	}
}

class AriSimpleTemplateFilterStore extends AriObject
{
	var $_filters;

	function applyFilter($name, $value, $params = null)
	{
		if ($this->filterExists($name))
		{
			$filter = $this->getFilter($name);
			if (!is_array($params)) $params = array();
			array_unshift($params, $value);
			$value = call_user_func_array(array($filter, 'parse'), $params); 
		}

		return $value;
	}
	
	function filterExists($name)
	{
		return isset($this->_filters[$name]);
	}
	
	function registerFilter($name, $filter)
	{
		$this->_filters[$name] = $filter;
	}

	function getFilter($name)
	{
		$filter = null;
		if ($this->filterExists($name))
		{
			$filter = $this->_filters[$name];
		}

		return $filter;
	}
}

AriKernel::import('SimpleTemplate.Filters.LoadAll');
?>