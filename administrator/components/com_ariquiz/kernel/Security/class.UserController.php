<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.ControllerBase');

class AriUserController extends AriControllerBase
{
	function getUserCount($filter = null)
	{
		$database =& JFactory::getDBO();
		
		$query = 'SELECT COUNT(*) FROM #__users';
		
		$database->setQuery($query);
		$cnt = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get user count.', E_USER_ERROR);
			return 0;
		}
		
		return $cnt;
	}
	
	function getUserList($filter = null, $gid = null)
	{
		$database =& JFactory::getDBO();
		
		$query = 'SELECT id AS UserId,name AS Name,username AS LoginName,email AS Email FROM #__users';
		if ($gid)
		{
			$query .= ' WHERE gid IN (' . join(',', $gid) . ')';
		}
		
		$query = $this->_applyFilter($query, $filter);

		$database->setQuery($query);
		$users = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get user list.', E_USER_ERROR);
			return null;
		}

		return $users;
	}
	
	function getUser($userId)
	{
		$database =& JFactory::getDBO();
		
		$userId = @intval($userId, 10);
		if ($userId < 1) return null;
		
		$query = 'SELECT * FROM #__users WHERE id=' . $userId . ' LIMIT 0,1';
		$database->setQuery($query);
		$user = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get user.', E_USER_ERROR);
			return null;
		}
		
		$user = count($user) > 0 ? $user[0] : null;

		return $user;
	}
	
	function getUserByUsername($username)
	{
		$database =& JFactory::getDBO();
		
		if ($username) $username = trim($username);
		if (!$username) return null;

		$query = 'SELECT * FROM #__users WHERE username=' . $database->Quote($username) . ' LIMIT 0,1';
		$database->setQuery($query);
		$user = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get user by name.', E_USER_ERROR);
			return null;
		}
		
		$user = count($user) > 0 ? $user[0] : null;

		return $user;
	}
	
	function hasUsername($username)
	{
		$database =& JFactory::getDBO();
		
		if ($username) $username = trim($username);
		if (!$username) return false;
		
		$query = 'SELECT COUNT(*) FROM #__users WHERE username=' . $database->Quote($username);

		$database->setQuery($query);
		$cnt = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt check user name.', E_USER_ERROR);
			return false;
		}

		return ($cnt > 0);
	}
}
?>