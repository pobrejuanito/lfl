<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Page.Specific.AdminSecurePageBase');
AriKernel::import('Controllers.AriQuiz.ResultController');
AriKernel::import('TextTemplates.TextTemplateController');
AriKernel::import('Utils.Utils');
AriKernel::import('Date.Date');
AriKernel::import('Components.AriQuiz.Util');

class texttemplate_previewAriPage extends AriAdminSecurePageBase 
{	
	function _init()
	{
		$this->isSimple = true;
		
		parent::_init();
	}
	
	function execute()
	{
		$sid = AriRequest::getParam('sid', 0);
		$templateId = AriRequest::getParam('templateId', 0);
		if (!empty($templateId))
		{
			$templateController = new AriTextTemplateController(AriConstantsManager::getVar('TextTemplateTable', AriQuizComponent::getCodeName()));
			$template = $templateController->call('getTemplate', $templateId);
			if ($template && $template->TemplateId)
			{
				$resultController = new AriQuizResultController();
				$result = $resultController->call('getFormattedFinishedResultById', $sid);
				
				$cssFile = AriQuizUtils::getCssFile(isset($result['CssTemplateId']) ? $result['CssTemplateId'] : null);
				echo '<link rel="stylesheet" type="text/css" href="'. $cssFile . '" />';
				if (strpos($template->Value, 'StatByCategories') !== false) 
				{
					$result['StatByCategories'] = AriQuizUtils::getStatByCategoriesHtml($resultController->call('getFinishedInfoByCategory', $result['StatisticsInfoId']));
				}

				$resText = $template->parse($result);
				AriWebHelper::displayDbValue($resText, false);
			}
		}
		
		parent::execute();
	}
}
?>