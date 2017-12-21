<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.ControllerBase');

class AriPropertyController extends AriControllerBase 
{
	var $_propTable;
	var $_propValueTable;
	
	function __construct($propTable, $propValueTable)
	{
		$this->_propTable = $propTable;
		$this->_propValueTable = $propValueTable;
		
		parent::__construct();
	}
	
	function deleteProperties($entityName, $entityKey, $props, $strictDelete)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('DELETE FROM %1$s USING %1$s,%2$s WHERE %2$s.PropertyId = %1$s.PropertyId AND %2$s.Entity = %3$s AND %1$s.EntityKey = %4$d',
			$this->_propValueTable,
			$this->_propTable,
			$database->Quote($entityName),
			intval($entityKey));
		if ($strictDelete)
		{
			if (empty($props)) return true;
			
			$propKeys = array_keys($props);
			$propKeys = $this->_quoteValues($propKeys);
			
			$query .= sprintf(' AND %1$s.PropertyName IN (%2$s)',
				$this->_propTable,
				join(',', $propKeys));
		}
			
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt delete properties.', E_USER_ERROR);
			return false;
		}

		return true;
	}
	
	function saveProperties($entityName, $entityKey, $props, $strictDelete = false)
	{
		$database =& JFactory::getDBO();
		
		$errorMessage = 'ARI: Couldnt save properties.';
		
		$this->deleteProperties($entityName, $entityKey, $props, $strictDelete);
		if ($this->_isError(true, false))
		{
			trigger_error($errorMessage, E_USER_ERROR);
			return false;
		}
		
		if (empty($props)) return true;
		
		$mapping = $this->_getPropertiesMapping($entityName, array_keys($props));
		if ($this->_isError(true, false))
		{
			trigger_error($errorMessage, E_USER_ERROR);
			return false;
		}
		
		if (empty($mapping)) return true;

		$values = array();
		foreach ($mapping as $propName => $propId)
		{
			$values[] = sprintf('(%d,%s,%d)',
				$propId,
				$database->Quote($props[$propName]),
				$entityKey);
		}
		$query = sprintf('INSERT INTO %s (PropertyId,PropertyValue,EntityKey) VALUES %s',
			$this->_propValueTable,
			join(',', $values));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error($errorMessage, E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function getProperties($entityName, $entityKey)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT AP.ResourceKey,AP.PropertyName,IF(APV.PropertyId, APV.PropertyValue, AP.DefaultValue) AS PropertyValue,AP.PropertyType,AP.ControlType' .
			' FROM %s AP LEFT JOIN %s APV' .
			'	ON AP.PropertyId = APV.PropertyId AND APV.EntityKey = %d' .
			' WHERE AP.Entity = %s',
			$this->_propTable,
			$this->_propValueTable,
			intval($entityKey),
			$database->Quote($entityName));
		$database->setQuery($query);
		$properties = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get properties.', E_USER_ERROR);
			return null;
		}
		
		return $properties;
	}
	
	function getSimpleProperties($entityName, $entityKey)
	{
		$props = $this->getProperties($entityName, $entityKey);
		if ($this->_isError(true, false))
		{
			trigger_error('ARI: Could get simple properties.', E_USER_ERROR);
			return null;
		}
		
		$simpleProps = array();
		if (empty($props)) return $simpleProps;
		
		foreach ($props as $prop)
		{
			$simpleProps[$prop->PropertyName] = $prop->PropertyValue;
		}
		
		return $simpleProps;
	}
	
	function _getPropertiesMapping($entityName, $propNames)
	{
		$database =& JFactory::getDBO();
		
		$qPropNames = array();
		foreach ($propNames as $propName)
		{
			$qPropNames[] = $database->Quote($propName);
		}
		
		$query = sprintf('SELECT PropertyId,PropertyName FROM %s WHERE Entity = %s AND PropertyName IN(%s)',
			$this->_propTable,
			$database->Quote($entityName),
			join(',', $qPropNames));
		$database->setQuery($query);
		$mappingList = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get properties mapping.', E_USER_ERROR);
			return null;
		}
		
		$mapping = array();
		foreach ($mappingList as $mappingItem)
		{
			$mapping[$mappingItem->PropertyName] = $mappingItem->PropertyId;
		}
		
		return $mapping;
	}
}
?>