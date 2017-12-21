<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.Controls.Toolbar.Toolbar');

class AriQuizToolbar extends AriToolbar
{
	function security_rulesToolbar()
	{
		$this->_toolbar->resourceTitle('Title.ResultScaleList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('securityrule_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.ResultScaleRemove'),
			'security_rules$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function importToolbar()
	{
		$this->_toolbar->resourceTitle('Title.ImportData');
		$this->_toolbar->startToolbar();
		
		/*
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();*/
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();
		
		$this->_toolbar->endToolbar();
	}
	
	function exportToolbar()
	{
		global $option;
		
		$this->_toolbar->resourceTitle('Title.ExportData');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->custom('export', 'restore.png', 'restore.png', AriWebHelper::translateResValue('Toolbar.Export'), false);
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		$this->_toolbar->back(AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			$option,
			'quiz_list'));
		
		$this->_toolbar->endToolbar();
	}
	
	function resultscale_addToolbar()
	{
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Title.ResultScale'),
			AriWebHelper::translateResValue('Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('resultscale_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('resultscale_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('resultscale_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function resultscale_updateToolbar()
	{
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Title.ResultScale'),
			AriWebHelper::translateResValue('Label.UpdateItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('resultscale_update$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('resultscale_update$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('resultscale_update$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function resultscale_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.ResultScaleList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('resultscale_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.ResultScaleRemove'),
			'resultscale_list$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function mail_templatesToolbar()
	{
		$this->_toolbar->resourceTitle('Title.TemplateList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('mailtemplate_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.TemplateRemove'),
			'mail_templates$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function mailtemplate_addToolbar()
	{
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.MailTemplate'),
			AriWebHelper::translateResValue('Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('mailtemplate_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('mailtemplate_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('mailtemplate_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function mailtemplate_updateToolbar()
	{
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.MailTemplate'),
			AriWebHelper::translateResValue('Label.UpdateItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('mailtemplate_update$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('mailtemplate_update$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('mailtemplate_update$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function quiz_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.QuizList');
		$this->_toolbar->startToolbar();

		$this->_toolbar->apply('quiz_list$ajax|filters', AriWebHelper::translateResValue('Toolbar.Filters'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->custom('copy', 'copy.png', 'copy.png', AriWebHelper::translateResValue('Toolbar.Copy'), false);
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->custom('mass_edit', 'edit.png', 'edit.png', AriWebHelper::translateResValue('Toolbar.MassEdit'), false);

		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();

		$this->_toolbar->publishList('quiz_list$ajax|activate', AriWebHelper::translateResValue('Button.Activate'));
		$this->_toolbar->spacer();
		$this->_toolbar->unpublishList('quiz_list$ajax|deactivate', AriWebHelper::translateResValue('Button.Deactivate'));
		$this->_toolbar->spacer();
		$this->_toolbar->addNewX('quiz_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.QuizRemove'), 
			'quiz_list$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function quiz_addToolbar()
	{
		$quizId = AriRequest::getParam('quizId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Quiz'),
			AriWebHelper::translateResValue($quizId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('quiz_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('quiz_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('quiz_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}

	function resultToolbar()
	{
		global $option;
		
		$quizId = AriRequest::getParam('quizId', 0);

		$this->_toolbar->resourceTitle('Title.Result');
		$printImg = $this->_getPrintImg();
		$previewImg = 'preview.png';
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->custom('result$res_template', $previewImg, $previewImg, AriWebHelper::translateResValue('Toolbar.Preview'), false);
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();			
			$this->_toolbar->custom('results$tocsv', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToCSV'), false);
			$this->_toolbar->spacer();
			$this->_toolbar->custom('results$tohtml', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToHTML'), false);
			$this->_toolbar->spacer();
			$this->_toolbar->custom('results$toexcel', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToExcel'), false);
			$this->_toolbar->spacer();			
			$this->_toolbar->custom('results$toword', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToWord'), false);
			
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			$this->_toolbar->back(AriWebHelper::translateResValue('Toolbar.ResultList'), sprintf('index.php?option=%s&task=%s&quizId=%d',
				$option,
				'results',
				$quizId));
			$this->_toolbar->spacer();
	    $this->_toolbar->endToolbar();
	}
	
	function resultsToolbar()
	{
		global $option;
		
		$this->_toolbar->resourceTitle('Title.QuizResultList');
		
		$this->_toolbar->startToolbar();
			
			$printImg = $this->_getPrintImg();
			$removeImg = $this->_getRemoveImg();
			
			$this->_toolbar->apply('results$ajax|filters', AriWebHelper::translateResValue('Toolbar.Filters'));
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			$this->_toolbar->custom('results$tocsv', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToCSV'), true);
			$this->_toolbar->spacer();
			$this->_toolbar->custom('results$tohtml', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToHTML'), true);
			$this->_toolbar->spacer();
			$this->_toolbar->custom('results$toexcel', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToExcel'), true);
			$this->_toolbar->spacer();
			$this->_toolbar->custom('results$toword', $printImg, $printImg, AriWebHelper::translateResValue('Toolbar.ExportToWord'), true);
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.ResultRemove'), 
				'results$ajax|delete', 
				AriWebHelper::translateResValue('Button.Remove'));
			$this->_toolbar->spacer();
			$this->_toolbar->custom('deleteAll', $removeImg, $removeImg, AriWebHelper::translateResValue('Toolbar.RemoveAll'), false);
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			$this->_toolbar->back(AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
				$option,
				'quiz_list'));
			$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function qtemplate_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.TemplateList');
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->addNewX('qtemplate_add', AriWebHelper::translateResValue('Button.Add'));
			$this->_toolbar->spacer();
			$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.QTemplateRemove'), 
				'qtemplate_list$ajax|delete', 
				AriWebHelper::translateResValue('Button.Remove'));
			
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->back(
				AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
				AriQuizComponent::getCodeName(),
				'quiz_list'));
			$this->_toolbar->spacer();
		$this->_toolbar->endToolbar();
	}
	
	function qtemplate_addToolbar()
	{
		$templateId = AriRequest::getParam('templateId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Title.QuestionTemplate'),
			AriWebHelper::translateResValue($templateId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->save('qtemplate_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
			$this->_toolbar->spacer();
			$this->_toolbar->apply('qtemplate_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('qtemplate_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
			$this->_toolbar->spacer();
		$this->_toolbar->endToolbar();
	}
	
	function bankToolbar()
	{
		$this->_toolbar->resourceTitle('Title.Bank');
		
		$this->_toolbar->startToolbar();
		
			$this->_toolbar->apply('bank$ajax|filters', AriWebHelper::translateResValue('Toolbar.Filters'));
			
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->custom('csv_import', 'upload.png', 'upload.png', AriWebHelper::translateResValue('Toolbar.CSVImport'), false);

			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->custom('mass_edit', 'edit.png', 'edit.png', AriWebHelper::translateResValue('Toolbar.MassEdit'), false);

			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->addNewX('bank_add', AriWebHelper::translateResValue('Button.Add'));
			$this->_toolbar->spacer();
			$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.BankQuestionRemove'), 
				'bank$ajax|delete',
				AriWebHelper::translateResValue('Button.Remove'));
			
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->back(
				AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
				AriQuizComponent::getCodeName(),
				'quiz_list'));
			$this->_toolbar->spacer();
			
		$this->_toolbar->endToolbar();
	}
	
	function bank_addToolbar()
	{
		$questionId = AriRequest::getParam('questionId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Question'),
			AriWebHelper::translateResValue($questionId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->save('bank_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
			$this->_toolbar->spacer();
			$this->_toolbar->apply('bank_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('bank_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
			$this->_toolbar->spacer();
		$this->_toolbar->endToolbar();
	}
	
	function question_listToolbar()
	{
		global $option;
		
		$this->_toolbar->resourceTitle('Title.QuestionList');
		$this->_toolbar->startToolbar();

		$this->_toolbar->custom('copy', 'copy.png', 'copy.png', AriWebHelper::translateResValue('Toolbar.Copy'), false);
		$this->_toolbar->spacer();
		$this->_toolbar->custom('move', 'move.png', 'move.png', AriWebHelper::translateResValue('Toolbar.Move'), false);
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->custom('mass_edit', 'edit.png', 'edit.png', AriWebHelper::translateResValue('Toolbar.MassEdit'), false);

		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
			
		$this->_toolbar->custom('csv_import', 'upload.png', 'upload.png', AriWebHelper::translateResValue('Toolbar.CSVImport'), false);
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->custom('to_bank', 'upload.png', 'upload.png', AriWebHelper::translateResValue('Toolbar.ToBank'), false);
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->custom('from_bank', 'upload.png', 'upload.png', AriWebHelper::translateResValue('Toolbar.FromBank'), false);
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->addNewX('question_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.QuestionRemove'), 
				'question_list$ajax|delete', 
				AriWebHelper::translateResValue('Button.Remove'));
				
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			$option,
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function question_addToolbar()
	{
		$questionId = AriRequest::getParam('questionId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Question'),
			AriWebHelper::translateResValue($questionId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->save('question_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
			$this->_toolbar->spacer();
			$this->_toolbar->apply('question_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('question_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
			$this->_toolbar->spacer();
		$this->_toolbar->endToolbar();
	}
	
	function templatesToolbar()
	{
		$this->_toolbar->resourceTitle('Title.TemplateList');
		$this->_toolbar->startToolbar();

			$this->_toolbar->spacer();
			$this->_toolbar->addNewX('template_add', AriWebHelper::translateResValue('Button.Add'));
			$this->_toolbar->spacer();
			$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.QTemplateRemove'), 
				'templates$ajax|delete', 
				AriWebHelper::translateResValue('Button.Remove'));
			
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->back(
				AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
				AriQuizComponent::getCodeName(),
				'quiz_list'));
			$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function template_addToolbar()
	{
		$fileId = intval(AriRequest::getParam('fileId', 0));
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Title.CSSTemplate'),
			AriWebHelper::translateResValue($fileId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->save('template_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('template_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('template_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();
		$this->_toolbar->endToolbar();
	}
	
	function texttemplate_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.TemplateList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('texttemplate_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.QTemplateRemove'), 
				'texttemplate_list$ajax|delete', 
				AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function texttemplate_addToolbar()
	{
		$templateId = AriRequest::getParam('templateId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Template'),
			AriWebHelper::translateResValue($templateId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			$this->_toolbar->save('texttemplate_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
			$this->_toolbar->spacer();
			$this->_toolbar->apply('texttemplate_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('texttemplate_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
			$this->_toolbar->spacer();
		$this->_toolbar->endToolbar();		
	}

	function securitycategory_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.SecurityCategoryList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('securitycategory_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.CategoryRemove'), 
			'securitycategory_list$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function securitycategory_addToolbar()
	{
		$categoryId = AriRequest::getParam('categoryId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Category'),
			AriWebHelper::translateResValue($categoryId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('securitycategory_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('securitycategory_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('securitycategory_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function bankcategory_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.BankCategoryList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('bankcategory_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.CategoryRemove'), 
			'bankcategory_list$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function bankcategory_addToolbar()
	{
		$categoryId = AriRequest::getParam('categoryId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Category'),
			AriWebHelper::translateResValue($categoryId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('bankcategory_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('bankcategory_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('bankcategory_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function category_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.CategoryList');
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->addNewX('category_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
			AriWebHelper::translateResValue('Warning.CategoryRemove'), 
			'category_list$ajax|delete', 
			AriWebHelper::translateResValue('Button.Remove'));
		
			$this->_toolbar->spacer();
			$this->_toolbar->divider();
			$this->_toolbar->spacer();
			
			$this->_toolbar->back(
				AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
				AriQuizComponent::getCodeName(),
				'quiz_list'));
			$this->_toolbar->spacer();

		$this->_toolbar->endToolbar();
	}
	
	function category_addToolbar()
	{
		$categoryId = AriRequest::getParam('categoryId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Label.Category'),
			AriWebHelper::translateResValue($categoryId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('category_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('category_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('category_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}
	
	function questioncategory_listToolbar()
	{
		$this->_toolbar->resourceTitle('Title.QuestionCategoryList');
		$this->_toolbar->startToolbar();

		$this->_toolbar->custom('mass_edit', 'edit.png', 'edit.png', AriWebHelper::translateResValue('Toolbar.MassEdit'), false);

		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->addNewX('questioncategory_add', AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.QCategoryRemove'), 
				'questioncategory_list$ajax|delete',
				AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();
		
		$this->_toolbar->endToolbar();
	}
	
	function questioncategory_addToolbar()
	{
		$qCategoryId = AriRequest::getParam('qCategoryId', 0);
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Title.QuestionCategory'),
			AriWebHelper::translateResValue($qCategoryId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
			
		    $this->_toolbar->save('questioncategory_add$save', AriWebHelper::translateResValue('Toolbar.Save'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->apply('questioncategory_add$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		    $this->_toolbar->spacer();
		    $this->_toolbar->cancel('questioncategory_add$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));
		    $this->_toolbar->spacer();

	    $this->_toolbar->endToolbar();
	}

	function lang_backendToolbar()
	{
		$this->_lang_list('lang_backend', 'blang_add');
	}
	
	function lang_frontendToolbar()
	{
		$this->_lang_list('lang_frontend', 'flang_add');
	}
	
	function _lang_list($task, $addTask)
	{
		$this->_toolbar->resourceTitle('Title.LangList');
		$this->_toolbar->startToolbar();

		$this->_toolbar->custom($task . '$export', 'restore.png', 'restore.png', AriWebHelper::translateResValue('Toolbar.Export'), true);
		$this->_toolbar->spacer();
		$this->_toolbar->custom('import', 'upload.png', 'upload.png', AriWebHelper::translateResValue('Toolbar.Import'), false);
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
			
		$this->_toolbar->apply($task . '$default', AriWebHelper::translateResValue('Toolbar.Default'));
		$this->_toolbar->spacer();
		$this->_toolbar->addNewX($addTask, AriWebHelper::translateResValue('Button.Add'));
		$this->_toolbar->spacer();
		$this->_toolbar->deleteList(
				AriWebHelper::translateResValue('Warning.QTemplateRemove'), 
				$task . '$ajax|delete', 
				AriWebHelper::translateResValue('Button.Remove'));
		
		$this->_toolbar->spacer();
		$this->_toolbar->divider();
		$this->_toolbar->spacer();
		
		$this->_toolbar->back(
			AriWebHelper::translateResValue('Toolbar.QuizList'), sprintf('index.php?option=%s&task=%s',
			AriQuizComponent::getCodeName(),
			'quiz_list'));
		$this->_toolbar->spacer();
		
		$this->_toolbar->endToolbar();
	}
	
	function blang_addToolbar()
	{
		$this->_lang_add('blang_add');
	}
	
	function flang_addToolbar()
	{
		$this->_lang_add('flang_add');
	}
	
	function _lang_add($task)
	{
		$fileId = intval(AriRequest::getParam('fileId', 0));
		$this->_toolbar->title(sprintf('%s : %s',
			AriWebHelper::translateResValue('Title.BLangResource'),
			AriWebHelper::translateResValue($fileId ? 'Label.UpdateItem' : 'Label.AddItem')));
		
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->save($task . '$save', AriWebHelper::translateResValue('Toolbar.Save'));
		$this->_toolbar->spacer();
		$this->_toolbar->apply($task . '$apply', AriWebHelper::translateResValue('Toolbar.Apply'));
		$this->_toolbar->spacer();
		$this->_toolbar->cancel($task . '$cancel', AriWebHelper::translateResValue('Toolbar.Cancel'));

		$this->_toolbar->endToolbar();
	}
	
	function helpToolbar()
	{
		$this->_back('Title.Help', 'Toolbar.QuizList');
	}
	
	function faqToolbar()
	{
		$this->_back('Title.FAQ', 'Toolbar.QuizList');
	}
	
	function debugToolbar()
	{
		global $option;
		//$this->_toolbar->resourceTitle($resKey);
		
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->back(AriWebHelper::translateResValue('Toolbar.Quizzes'), sprintf('index.php?option=%s&task=%s',
			$option,
			''));
			
		$this->_toolbar->endToolbar();
	}
	
	function _back($resKey = '', $backResKey = 'Button.Back')
	{
		global $option;
		
		$this->_toolbar->resourceTitle($resKey);
		
		$this->_toolbar->startToolbar();
		
		$this->_toolbar->back(AriWebHelper::translateResValue($backResKey), sprintf('index.php?option=%s&task=%s',
			$option,
			''));
		    
		$this->_toolbar->endToolbar();
	}

	function _getPrintImg()
	{		
		return 'archive.png';
	}
	
	function _getRemoveImg()
	{		
		return 'delete.png';
	}
	
	public function addSubmenu($vName)
	{
		if (!class_exists('JSubMenuHelper'))
			return ;
	
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_QUIZZES'),
			'index.php?option=com_ariquiz&task=quiz_list',
			$vName == 'quiz_list'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_QUIZCAT'),
			'index.php?option=com_ariquiz&task=category_list',
			$vName == 'category_list'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_BANKCAT'),
			'index.php?option=com_ariquiz&task=bankcategory_list',
			$vName == 'bankcategory_list'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_QUECAT'),
			'index.php?option=com_ariquiz&task=questioncategory_list',
			$vName == 'questioncategory_list'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_BANK'),
			'index.php?option=com_ariquiz&task=bank',
			$vName == 'bank'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_RESSCALE'),
			'index.php?option=com_ariquiz&task=resultscale_list',
			$vName == 'resultscale_list'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_QUETEMPLATE'),
			'index.php?option=com_ariquiz&task=qtemplate_list',
			$vName == 'qtemplate_list'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_TEXTTEMPLATE'),
			'index.php?option=com_ariquiz&task=texttemplate_list',
			$vName == 'texttemplate_list'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_MAILTEMPLATE'),
			'index.php?option=com_ariquiz&task=mail_templates',
			$vName == 'mail_templates'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_RESULTS'),
			'index.php?option=com_ariquiz&task=results',
			$vName == 'results'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_LANG'),
			'index.php?option=com_ariquiz&task=lang_backend',
			$vName == 'lang_backend'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_FLANG'),
			'index.php?option=com_ariquiz&task=lang_frontend',
			$vName == 'lang_frontend'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_TEMPLATES'),
			'index.php?option=com_ariquiz&task=templates',
			$vName == 'templates'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_EXPORT'),
			'index.php?option=com_ariquiz&task=export',
			$vName == 'export'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_IMPORT'),
			'index.php?option=com_ariquiz&task=import',
			$vName == 'import'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_HELP'),
			'index.php?option=com_ariquiz&task=help',
			$vName == 'help'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_ARIQUIZ_MENU_FAQ'),
			'index.php?option=com_ariquiz&task=faq',
			$vName == 'faq'
		);
	}
}
?>