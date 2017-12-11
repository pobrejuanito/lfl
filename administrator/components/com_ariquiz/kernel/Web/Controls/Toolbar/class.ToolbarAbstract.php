<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

class AriToolbarAbstract extends AriObject
{	
	function resourceTitle($resKey, $img = 'generic.png')
	{
		$this->title(AriWebHelper::translateResValue($resKey), $img);
	}
	
	function title($title, $icon = 'generic.png')
	{
		
	}

	function startToolbar()
	{
	}
	
	function endToolbar()
	{
	}
	
	function spacer($width = '')
	{
		
	}
	
	function divider()
	{
		
	}
	
	function custom($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true, $x = false)
	{
		
	}
	
	function customX($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true)
	{
	}
	
	function preview($url = '', $updateEditors = false)
	{
	}
	
	function help($ref, $com = false)
	{
	}
	
	function back($alt = 'Back', $href = 'javascript:history.back();')
	{
		
	}
	
	function media_manager($directory = '', $alt = 'Upload')
	{
		
	}
	
	function addNew($task = 'add', $alt = 'New')
	{
		
	}
	
	function addNewX($task = 'add', $alt = 'New')
	{
		
	}
	
	function publish($task = 'publish', $alt = 'Publish')
	{
		
	}
	
	function publishList($task = 'publish', $alt = 'Publish')
	{
		
	}
	
	function makeDefault($task = 'default', $alt = 'Default')
	{
	}
	
	function assign($task = 'assign', $alt = 'Assign')
	{
	}
	
	function unpublish($task = 'unpublish', $alt = 'Unpublish')
	{
	}
	
	function unpublishList($task = 'unpublish', $alt = 'Unpublish')
	{
	}
	
	function save($task = 'save', $alt = 'Save')
	{
	}
	
	function apply($task = 'apply', $alt = 'Apply')
	{
	}
	
	function cancel($task = 'cancel', $alt = 'Cancel')
	{
	}

	function deleteList($msg = '', $task = 'remove', $alt = 'Delete')
	{		
	}

	function deleteListX($msg = '', $task = 'remove', $alt = 'Delete')
	{
	}	
}
?>