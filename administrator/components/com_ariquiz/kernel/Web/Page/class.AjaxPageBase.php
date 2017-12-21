<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.JSON.JSONHelper');
AriKernel::import('Web.Response');

class AriAjaxPageBase extends AriPageBase
{
	function __construct($executionTask, $template = null, $event = null, $eventArgs = null)
	{		
		parent::__construct($template, $event, $eventArgs);
	}
	
	function sendJsonResponse($data, $charset = 'utf-8')
	{
		AriResponse::sendJsonResponse($data, $charset);
	}
}
?>