<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.AriQuiz.UserQuizController');
AriKernel::import('Controllers.AriQuiz.QuestionController');
AriKernel::import('Controllers.FileController');
AriKernel::import('Cache.FileCache');

class showHotspotAriPage extends AriPageBase
{
	var $_userQuizController;
	var $_questionController;
	var $_quizStorage;
	var $_ticketId;
	
	function _init()
	{
		$this->_userQuizController = new AriUserQuizController();
		$this->_questionController = new AriQuizQuestionController();
		
		parent::_init(); 
	}
	
	function execute()
	{
		$this->sendResponse($this->_getImage());
	}
	
	function getQuizStorage()
	{
		if (is_null($this->_quizStorage))
		{
			$my =& JFactory::getUser();

			$this->_quizStorage = AriEntityFactory::createInstance('AriQuizStorageEntity', AriGlobalPrefs::getEntityGroup(), 
				$this->getTicketId(), 
				$my);
		}
		
		return $this->_quizStorage;
	}
	
	function getTicketId()
	{
		if (is_null($this->_ticketId))
		{
			$this->_ticketId = AriRequest::getParam('ticketId', '');
		}
		
		return $this->_ticketId;
	}
	
	function _getImage()
	{
		global $option;
		
		$quizStorage = $this->getQuizStorage();
		$sid = $quizStorage->get('StatisticsInfoId');

		$statistics = $this->_userQuizController->call('getCurrentQuestion', $sid);
		
		if (empty($statistics) || empty($statistics->StatisticsId))
		{
			return $this->_getErrorImage();
		}

		$questionVersionId = $statistics->Question->QuestionVersionId;
		$questionVersion = $statistics->Question->QuestionVersion;
		if ($questionVersion->QuestionType->ClassName != 'HotSpotQuestion')
		{
			return $this->_getErrorImage();
		}
		
		$files = $this->_questionController->call('getQuestionFiles',
			$statistics->BankVersionId
				? $statistics->BankVersionId
				: $questionVersionId);
		if (empty($files['hotspot_image']))
		{
			return $this->_getErrorImage();
		}

		$imageFile = $files['hotspot_image'];
		$questionEntity = AriEntityFactory::createInstance($questionVersion->QuestionType->ClassName, AriConstantsManager::getVar('QuestionEntityGroup', AriQuizComponent::getCodeName()));
		$questionData = $questionEntity->getDataFromXml($questionVersion->Data);
		$hotspotGroup = AriConstantsManager::getVar('FileGroup.HotSpot', $option);

		$cacheFile = $imageFile['FileId'] . '.' . $imageFile['Extension'];
		//$cacheFile = $questionData[ARI_QUIZ_HOTSPOT_IMGSRC];
		$cacheDir = JPATH_ROOT . '/administrator/components/' . $option . '/cache/files/' . $hotspotGroup . '/';
		$wwwDir = JURI::root(true) . '/administrator/components/' . $option . '/cache/files/' . $hotspotGroup . '/';
		$hotSpotImg = '';
		if (empty($cacheFile) || !file_exists($cacheDir . $cacheFile))
		{
			$fileId = $imageFile['FileId'];
			$fileController = new AriFileController(AriConstantsManager::getVar('FileTable', AriQuizComponent::getCodeName()));
			$cacheImageList = $fileController->call('getFileList', $hotspotGroup, array($fileId), true);
			if (!empty($cacheImageList) && count($cacheImageList) > 0)
			{
				$cacheImage = $cacheImageList[0];
				if (!file_exists($cacheDir . $cacheImage->FileId . '.' . $cacheImage->Extension))
				{
					AriFileCache::saveBinaryFile($cacheImage->Content, $cacheDir . $cacheImage->FileId . '.' . $cacheImage->Extension);
				}
				$hotSpotImg = $cacheDir . $cacheImage->FileId . '.' . $cacheImage->Extension;
			}
		}
		else
		{
			$hotSpotImg = $cacheDir . $cacheFile;
		}

		$oldMQR = get_magic_quotes_runtime();
		set_magic_quotes_runtime(0);
		
		if (!file_exists($hotSpotImg)) return $this->_getErrorImage();

		$handle = fopen($hotSpotImg, "rb");			 
		$content = fread($handle, filesize($hotSpotImg));
		fclose($handle);
		
		set_magic_quotes_runtime($oldMQR);
		
		return $content;
	}
	
	function _getErrorImage()
	{
		return '';
	}
}
?>