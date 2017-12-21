<?php
global $Itemid;
$option = $GLOBALS['option'] = 'com_ariquiz';
if (empty($Itemid) && JRequest::getVar('Itemid') != null)
	$Itemid = $GLOBALS['Itemid'] = JRequest::getInt('Itemid');

$basePath = $adminBasePath = JPATH_ROOT . '/components/com_ariquiz/';
$adminBasePath = JPATH_ROOT . '/administrator/components/com_ariquiz/';
require_once ($adminBasePath . 'kernel/class.AriKernel.php');

AriKernel::import('Joomla.JoomlaBridge');

$option = $GLOBALS['option'] = 'com_ariquiz';

AriKernel::import('PHPCompat.CompatPHP50x');
AriKernel::import('Constants.ClassConstants');
AriKernel::import('Constants.ConstantsManager');
AriKernel::import('GlobalPrefs.GlobalPrefs');
AriKernel::import('Components.AriQuiz.AriQuiz');
AriKernel::import('Web.Utils.WebHelper');
AriKernel::import('Web.TaskManager');
AriKernel::import('Web.Response');

$managerComp =& AriQuizComponent::instance();
$managerComp->init();
AriWebHelper::prepareRequestValues();

AriTaskManager::registerTaskGroup('script', $basePath . 'frontend_pages/scripts/');
AriTaskManager::registerTaskGroup('', $basePath . 'frontend_pages/', 
	array(ARI_TM_KEY_TEMPLATEDIR => $basePath . 'view/', ARI_TM_KEY_TEMPLATEEXT => 'html.php'));

$task = JRequest::getString('task');
if (empty($task)) $task = 'quiz_list';
if (!AriTaskManager::doTask($task)) AriResponse::redirect('index.php?option=' . $option);

AriWebHelper::restoreRequestValues();
?>