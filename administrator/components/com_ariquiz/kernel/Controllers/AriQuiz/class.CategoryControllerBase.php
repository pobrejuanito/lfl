<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.ControllerBase');

class AriQuizCategoryControllerBase extends AriControllerBase
{
	var $_tableName;
	var $_entityName;
	
	function isUniqueCategoryName($name, $id = null)
	{
		$isUnique = $this->_isUniqueField($this->_tableName, 'CategoryName', $name, 'CategoryId', $id);
		if ($this->_isError(true, false))
		{
			trigger_error('ARI: Couldnt check unique category name.', E_USER_ERROR);
			return false;
		}
		
		return $isUnique;
	}
	
	function getCategoryMapping($categoryNames)
	{
		$database =& JFactory::getDBO();
		
		$categoryMapping = array();
		if (!is_array($categoryNames) || count($categoryNames) == 0)
			return $categoryMapping;

		$query = sprintf('SELECT CategoryId,CategoryName FROM `%s` WHERE CategoryName IN (%s)',
			$this->_tableName,
			join(',', $this->_quoteValues($categoryNames)));
		$database->setQuery($query);
		$categories = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get categories mapping.', E_USER_ERROR);
			return $categoryMapping;
		}
		
		foreach ($categories as $category)
		{
			$categoryMapping[$category['CategoryName']] = $category['CategoryId'];
		}

		return $categoryMapping;
	}
	
	function saveCategory($categoryId, $fields, $ownerId)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt save category.'; 
		
		$categoryId = intval($categoryId);
		$isUpdate = ($categoryId > 0);
		$row = $isUpdate ? $this->getCategory($categoryId) : AriEntityFactory::createInstance($this->_entityName, AriGlobalPrefs::getEntityGroup());
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return null;
		}
		
		if (!$row->bind($fields))
		{
			trigger_error($error, E_USER_ERROR);
			return null;
		}
		
		if ($isUpdate)
		{
			$row->Modified = ArisDate::getDbUTC();
			$row->ModifiedBy = $ownerId;
		} 
		else
		{
			$row->Created = ArisDate::getDbUTC();
			$row->CreatedBy = $ownerId;
		}
		
		if (!$row->store())
		{
			trigger_error($error, E_USER_ERROR);
			return null;
		}
		
		return $row;
	}
	
	function getCategory($categoryId)
	{
		$database =& JFactory::getDBO();
		
		$categoryId = intval($categoryId);
		$category = AriEntityFactory::createInstance($this->_entityName, AriGlobalPrefs::getEntityGroup());
		if (!$category->load($categoryId))
		{
			trigger_error('ARI: Couldnt get category.', E_USER_ERROR);
			return null;
		}
		
		return $category;
	}
	
	function deleteCategory($idList)
	{
		$idList = $this->_fixIdList($idList);
		if (empty($idList)) return true;
		
		$database =& JFactory::getDBO();
		
		$queryList = array();
		$catStr = join(',', $this->_quoteValues($idList));
		$queryList[] = sprintf('DELETE FROM %s WHERE CategoryId IN (%s)',
			$this->_tableName, 
			$catStr);
		$queryList[] = sprintf('DELETE FROM %s WHERE CategoryId IN (%s)',
			$this->_tableName, 
			$catStr);
			
		$database->setQuery(join($queryList, ';'));
		$database->queryBatch();

		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt delete category.', E_USER_ERROR);
			return false;
		}

		return true;
	}
	
	function getCategoryCount($filter = null)
	{
		$count = $this->_getRecordCount($this->_tableName);
		if ($this->_isError(true, false))
		{
			trigger_error('ARI: Couldnt get category count.', E_USER_ERROR);
		}
		
		return $count; 
	}
	
	function getCategoryList($filter = null)
	{
		$database =& JFactory::getDBO();
		
		$query = 'SELECT CategoryId, CategoryName' . 
			' FROM ' . $this->_tableName . ' ';
		$query = $this->_applyFilter($query, $filter);
		
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get category list.', E_USER_ERROR);
			return null;
		}
		
		return $rows;
	}
}
?>