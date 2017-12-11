<?php
global $Itemid;
$option = $GLOBALS['option'] = 'com_ariquiz';
if (empty($Itemid) && JRequest::getVar('Itemid') != null)
	$Itemid = $GLOBALS['Itemid'] = JRequest::getInt('Itemid');

$basePath = dirname(__FILE__) . '/';
require_once ($basePath . 'kernel/class.AriKernel.php');

AriKernel::import('PHPCompat.CompatPHP50x');
AriKernel::import('Joomla.JoomlaBridge');
AriKernel::import('Web.TaskManager');
AriKernel::import('Constants.ClassConstants');
AriKernel::import('Constants.ConstantsManager');
AriKernel::import('GlobalPrefs.GlobalPrefs');
AriKernel::import('Components.AriQuiz.AriQuiz');
AriKernel::import('Components.AriQuiz.Toolbar');
AriKernel::import('Web.Utils.WebHelper');

$quizComp =& AriQuizComponent::instance();
$quizComp->init();

$clearTask = AriTaskManager::getTask($task);
$toolbar = new AriQuizToolbar();
$toolbar->showToolbar($clearTask);
$toolbar->addSubmenu($clearTask);
?>