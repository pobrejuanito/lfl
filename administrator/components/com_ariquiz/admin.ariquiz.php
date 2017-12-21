<?php
if (!defined('_ARI_QUIZ_INSTALL_DATE')) define('_ARI_QUIZ_INSTALL_DATE', '07 February 2010');

$basePath = dirname(__FILE__) . '/';
require_once ($basePath . 'kernel/class.AriKernel.php');

$option = $GLOBALS['option'] = 'com_ariquiz';

global $Itemid;
if (empty($Itemid) && JRequest::getVar('Itemid') != null)
	$Itemid = $GLOBALS['Itemid'] = JRequest::getInt('Itemid');

AriKernel::import('Joomla.JoomlaBridge');

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

AriTaskManager::registerTaskGroup('ajax', $basePath . 'ajax/');
AriTaskManager::registerTaskGroup('', $basePath . 'pages/', 
	array(ARI_TM_KEY_TEMPLATEDIR => $basePath . 'templates/', ARI_TM_KEY_TEMPLATEEXT => 'html.php'));

if (!AriTaskManager::doTask(JRequest::getString('task'))) AriResponse::redirect('index.php?option=com_ariquiz&task=quiz_list');

AriWebHelper::restoreRequestValues();
?>