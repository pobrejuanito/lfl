<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.ControllerBase');
AriKernel::import('Controllers.AriQuiz.QuestionController');
AriKernel::import('Controllers.AriQuiz._Templates.ExportTemplates');
AriKernel::import('Data.Export.ExportController');
AriKernel::import('Xml.SimpleXml');
AriKernel::import('System.System');

class AriQuizExportController extends AriControllerBase 
{
	function createExportProfileInstance()
	{
		return AriEntityFactory::createInstance('AriQuizExportProfileEntity', AriGlobalPrefs::getEntityGroup());
	}
	
	function clearExportQuizzes($profileId)
	{
		$database =& JFactory::getDBO();

		$query = 'DELETE FROM #__ariquiz_export_quiz WHERE ProfileId = ' . $profileId;
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt clear export quiz properties.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function deleteExportQuiz($profileId, $idList)
	{
		$database =& JFactory::getDBO();
		
		$profileId = @intval($profileId, 10);
		if ($profileId < 1) return true;
		
		$idList = $this->_fixIdList($idList);
		if (empty($idList)) return true;
		
		$error = 'ARI: Couldnt delete export quizzes.';
		
		$quizIdStr = join(',', $this->_quoteValues($idList));
		$query = 'DELETE FROM #__ariquiz_export_quiz WHERE ProfileId = ' . $profileId . ' AND QuizId IN (' . $quizIdStr . ')';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		return true;
	}
	
	function addExportQuiz($profileId, $idList)
	{
		$profileId = @intval($profileId, 10);
		if ($profileId < 1) return true;
		
		$idList = $this->_fixIdList($idList);
		if (empty($idList)) return true;
		
		$database =& JFactory::getDBO();
		
		$values = array();
		foreach ($idList as $id)
		{
			$values[] = sprintf('(%d,%d)', $profileId, $id);
		}
		
		$query = 'INSERT INTO #__ariquiz_export_quiz (ProfileId,QuizId) VALUES' . join(',', $values);
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt add export quiz.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function getExportQuizCount($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();

		$query = 'SELECT COUNT(*)'.
			' FROM #__ariquiz_export_quiz EQ INNER JOIN #__ariquiz Q ON EQ.QuizId = Q.QuizId' .
			' WHERE EQ.ProfileId = ' . $profileId . ' AND Q.Status <> ' . AriConstantsManager::getVar('Status.Delete', AriQuizControllerConstants::getClassName());
		$query = $this->_applyDbCountFilter($query, $filter);
		
		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get export quiz count.', E_USER_ERROR);
			return 0;
		}
		
		return $count;
	}

	function getExportQuizList($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();

		$query = 'SELECT Q.QuizName,EQ.QuizId,EQ.ExportResults' . 
			' FROM #__ariquiz_export_quiz EQ INNER JOIN #__ariquiz Q' .
			' ON EQ.QuizId = Q.QuizId' .
			' WHERE EQ.ProfileId = ' . $profileId . ' AND Q.Status <> ' . AriConstantsManager::getVar('Status.Delete', AriQuizControllerConstants::getClassName());
		$query = $this->_applyFilter($query, $filter);
		
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get export quiz list.', E_USER_ERROR);
			return null;
		}
		
		return $rows;
	}

	function getAvailableQuizCount($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();

		$query = sprintf('SELECT COUNT(*)' . 
			' FROM #__ariquiz Q LEFT JOIN #__ariquiz_export_quiz EQ' .
			' 	ON Q.QuizId = EQ.QuizId AND EQ.ProfileId = %d' .
			' WHERE EQ.QuizId IS NULL AND Q.Status <> %d',
			$profileId,
			AriConstantsManager::getVar('Status.Delete', AriQuizControllerConstants::getClassName()));
		$query = $this->_applyDbCountFilter($query, $filter);
		
		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get quiz count.', E_USER_ERROR);
			return 0;
		}
		
		return $count;
	}

	function getAvailableQuizList($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();

		$query = sprintf('SELECT Q.QuizId, Q.QuizName' . 
			' FROM #__ariquiz Q LEFT JOIN #__ariquiz_export_quiz EQ' .
			' 	ON Q.QuizId = EQ.QuizId AND EQ.ProfileId = %d' .
			' WHERE EQ.QuizId IS NULL AND Status <> %d',
			$profileId,
			AriConstantsManager::getVar('Status.Delete', AriQuizControllerConstants::getClassName()));
		$query = $this->_applyFilter($query, $filter);
		
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get quiz list.', E_USER_ERROR);
			return null;
		}

		return $rows;
	}
	
	function _applyBankFilter($query, $filter)
	{
		$quizId = 0;
		$notLoadUsedQuestions = false;
		if ($filter)
		{
			$filterPredicates = $filter->getConfigValue('filter');
			if (isset($filterPredicates['CategoryId']) && $filterPredicates['CategoryId'] !== null && $filterPredicates['CategoryId'] !== '')
			{				
				$categoryId = @intval($filterPredicates['CategoryId'], 10);
				if ($categoryId)
				{
					$query .= ' AND QBC.CategoryId=' . $categoryId;
				}
				else
				{
					$query .= ' AND (IFNULL(QBC.CategoryId, 0) = 0)';
				}
			}

			if (!empty($filterPredicates['QuizId']))
			{
				$quizId = $filterPredicates['QuizId'];
				$notLoadUsedQuestions = !empty($filterPredicates['NotLoadUsedQuestions']);
			}
		}
		
		$query = sprintf($query, $quizId);
		$query .= ' GROUP BY SQ.QuestionId';
		if ($notLoadUsedQuestions) $query .= ' HAVING QuestionCount = 0';

		return $query;
	}
	
	function clearSettings($profileId)
	{
		return ($this->clearExportQuestions($profileId) && $this->clearExportQuizzes($profileId));
	}
	
	function clearExportQuestions($profileId)
	{
		$database =& JFactory::getDBO();

		$query = 'DELETE FROM #__ariquiz_export_bankquestion WHERE ProfileId=' . $profileId;
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt clear export question properties.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function deleteExportBankQuestion($profileId, $idList)
	{
		$database =& JFactory::getDBO();
		
		$idList = $this->_fixIdList($idList);
		if (empty($idList)) return true;
		
		$error = 'ARI: Couldnt delete export questions.';
		
		$quizIdStr = join(',', $this->_quoteValues($idList));
		$query = 'DELETE FROM #__ariquiz_export_bankquestion WHERE ProfileId = ' . $profileId . ' AND QuestionId IN (' . $quizIdStr . ')';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		return true;
	}
	
	function addExportBankQuestion($profileId, $idList)
	{
		$idList = $this->_fixIdList($idList);
		if (empty($idList)) return true;
		
		$database =& JFactory::getDBO();
		
		$values = array();
		foreach ($idList as $id)
		{
			$values[] = sprintf('(%d,%d)',
				$profileId,
				$id);
		}
		
		$query = 'INSERT INTO #__ariquiz_export_bankquestion (ProfileId,QuestionId) VALUES' . join(',', $values);
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt add export question.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function getExportBankQuestionCount($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT COUNT(BQ.QuestionId) AS QuestionCount,SQ.QuestionId' . 
			' FROM #__ariquizquestion SQ INNER JOIN #__ariquiz_export_bankquestion EBQ' .
			' 	ON SQ.QuestionId = EBQ.QuestionId' . 
			' INNER JOIN #__ariquizquestionversion SQV' . 
			' 	ON SQ.QuestionVersionId = SQV.QuestionVersionId' .
			' INNER JOIN #__ariquizquestiontype QQT' .
			'	ON SQV.QuestionTypeId = QQT.QuestionTypeId' .
			' LEFT JOIN #__ariquizbankcategory QBC' .
			'	ON SQ.QuestionCategoryId = QBC.CategoryId' .
			' LEFT JOIN #__ariquizquestion BQ ' .
			'	ON BQ.BankQuestionId = SQ.QuestionId AND BQ.`Status` = %1$d AND (%%1$s = 0 OR BQ.QuizId = %%1$s)' . 
			' WHERE EBQ.ProfileId = %2$d AND SQ.Status = %1$d AND SQ.QuizId = 0',
			AriConstantsManager::getVar('Status.Active', AriQuizQuestionControllerConstants::getClassName()),
			$profileId);
		$query = $this->_applyBankFilter($query, $filter);
		$query = $this->_applyDbCountFilter($query, $filter);
		$query = 'SELECT COUNT(*) FROM (' . $query . ') T';

		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get count bank question.', E_USER_ERROR);
			return 0;
		}
	
		return $count;
	}
	
	function getExportBankQuestionList($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT COUNT(BQ.QuestionId) AS QuestionCount, SQ.QuestionId, SQ.QuestionId AS BankQuestionId, SQV.Question, QQT.QuestionType, SQV.Created, QBC.CategoryName' . 
			' FROM #__ariquizquestion SQ INNER JOIN #__ariquiz_export_bankquestion EBQ' .
			' 	ON SQ.QuestionId = EBQ.QuestionId' . 
			' INNER JOIN #__ariquizquestionversion SQV' . 
			' 	ON SQ.QuestionVersionId = SQV.QuestionVersionId' .
			' INNER JOIN #__ariquizquestiontype QQT' .
			'	ON SQV.QuestionTypeId = QQT.QuestionTypeId' .
			' LEFT JOIN #__ariquizbankcategory QBC' .
			'	ON SQ.QuestionCategoryId = QBC.CategoryId' .
			' LEFT JOIN #__ariquizquestion BQ ' .
			'	ON BQ.BankQuestionId = SQ.QuestionId AND BQ.`Status` = %1$d AND (%%1$s = 0 OR BQ.QuizId = %%1$s)' .
			' WHERE EBQ.ProfileId = %2$d AND SQ.Status = %1$d AND SQ.QuizId = 0',
			AriConstantsManager::getVar('Status.Active', AriQuizQuestionControllerConstants::getClassName()),
			$profileId);
		$query = $this->_applyBankFilter($query, $filter);
		$query = $this->_applyFilter($query, $filter);

		$database->setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get bank question list.', E_USER_ERROR);
			return null;
		}

		return $rows;
	}
	
	function getAvailableBankQuestionCount($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT COUNT(BQ.QuestionId) AS QuestionCount,SQ.QuestionId' . 
			' FROM #__ariquizquestion SQ LEFT JOIN #__ariquiz_export_bankquestion EBQ' .
			' 	ON SQ.QuestionId = EBQ.QuestionId AND EBQ.ProfileId = %2$d' . 
			' INNER JOIN #__ariquizquestionversion SQV' . 
			' 	ON SQ.QuestionVersionId = SQV.QuestionVersionId' .
			' INNER JOIN #__ariquizquestiontype QQT' .
			'	ON SQV.QuestionTypeId = QQT.QuestionTypeId' .
			' LEFT JOIN #__ariquizbankcategory QBC' .
			'	ON SQ.QuestionCategoryId = QBC.CategoryId' .
			' LEFT JOIN #__ariquizquestion BQ ' .
			'	ON BQ.BankQuestionId = SQ.QuestionId AND BQ.`Status` = %1$d AND (%%1$s = 0 OR BQ.QuizId = %%1$s)' . 
			' WHERE EBQ.QuestionId IS NULL AND SQ.Status = %1$d AND SQ.QuizId = 0',
			AriConstantsManager::getVar('Status.Active', AriQuizQuestionControllerConstants::getClassName()),
			$profileId);
		$query = $this->_applyBankFilter($query, $filter);
		$query = $this->_applyDbCountFilter($query, $filter);
		$query = 'SELECT COUNT(*) FROM (' . $query . ') T';

		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get count bank question.', E_USER_ERROR);
			return 0;
		}
	
		return $count;
	}
	
	function getAvailableBankQuestionList($profileId, $filter = null)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT COUNT(BQ.QuestionId) AS QuestionCount, SQ.QuestionId, SQ.QuestionId AS BankQuestionId, SQV.Question, QQT.QuestionType, SQV.Created, QBC.CategoryName' . 
			' FROM #__ariquizquestion SQ LEFT JOIN #__ariquiz_export_bankquestion EBQ' .
			' 	ON SQ.QuestionId = EBQ.QuestionId AND EBQ.ProfileId = %2$d' . 
			' INNER JOIN #__ariquizquestionversion SQV' . 
			' 	ON SQ.QuestionVersionId = SQV.QuestionVersionId' .
			' INNER JOIN #__ariquizquestiontype QQT' .
			'	ON SQV.QuestionTypeId = QQT.QuestionTypeId' .
			' LEFT JOIN #__ariquizbankcategory QBC' .
			'	ON SQ.QuestionCategoryId = QBC.CategoryId' .
			' LEFT JOIN #__ariquizquestion BQ ' .
			'	ON BQ.BankQuestionId = SQ.QuestionId AND BQ.`Status` = %1$d AND (%%1$s = 0 OR BQ.QuizId = %%1$s)' .
			' WHERE EBQ.QuestionId IS NULL AND SQ.Status = %1$d AND SQ.QuizId = 0',
			AriConstantsManager::getVar('Status.Active', AriQuizQuestionControllerConstants::getClassName()),
			$profileId);
		$query = $this->_applyBankFilter($query, $filter);
		$query = $this->_applyFilter($query, $filter);

		$database->setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get bank question list.', E_USER_ERROR);
			return null;
		}

		return $rows;
	}

	function getExportData($profileId, $configFile, $outputEncoding = 'UTF-8')
	{
		$exportController = new AriExportDataController($configFile, $outputEncoding);
		$profile = $this->getExportProfile($profileId);

		if ($this->_isError(true, false) || !$profile)
		{
			return null;
		}

		$database =& JFactory::getDBO();
		
		@set_time_limit(9999);		
		AriSystem::setOptimalMemoryLimit('16M', '16M', '128M');
		
		$query = 'SET SESSION SQL_BIG_SELECTS=1';
		$database->setQuery($query);
		$database->query();
		
		if (($profile->ExportQuizzes && !$this->getExportQuizData($exportController, $profile)) ||
			($profile->ExportBankQuestions && !$this->getExportQuestionData($exportController, $profile))) 
		{
			return null;
		}

		return $exportController->getExportXml();
	}

	function getExportQuizData(&$exportController, $profile)
	{
		if (!$this->_addExportQuizData($exportController, $profile) ||
			!$this->_addExportQuizAccessData($exportController, $profile) ||
			!$this->_addExportQuizCategoryData($exportController, $profile) ||
			!$this->_addExportQuizProperties($exportController, $profile) ||
			!$this->_addExportQuizQuestions($exportController, $profile) ||
			!$this->_addExportQuizResultScale($exportController, $profile) ||
			!$this->_addExportQuizFiles($exportController, $profile) ||
			!$this->_addExportQuizResults($exportController, $profile) ||
			!$this->_addExportTextTemplate($exportController, $profile)
		)
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportQuizData(&$exportController, $profile)
	{
		$query = 'SELECT Q.*' .
			' FROM #__ariquiz Q';
		if (!$profile->ExportAllQuizzes)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}

		if (!$exportController->addRecordsGroup($query, 'quiz'))
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportTextTemplate(&$exportController, $profile)
	{
		$database =& JFactory::getDBO();
		
		$allQuiz = $profile->ExportAllQuizzes;
		$query = 'SELECT DISTINCT TT.*' .
			' FROM #__arigenerictemplate TT INNER JOIN #__arigenerictemplateentitymap TTEM ON TT.TemplateId = TTEM.TemplateId' .
			' INNER JOIN #__ariquiz Q ON TTEM.EntityId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		$query .= ' WHERE TTEM.EntityName = ' . $database->Quote(AriConstantsManager::getVar('EntityKey', AriQuizComponent::getCodeName()));
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId = ' . $profile->ProfileId;
		}

		if (!$exportController->addRecordsGroup($query, 'generictemplate'))
		{
			return false;
		}
		
		$query = 'SELECT DISTINCT TTEM.*' .
			' FROM #__arigenerictemplateentitymap TTEM INNER JOIN #__ariquiz Q ON TTEM.EntityId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		$query .= ' WHERE TTEM.EntityName = ' . $database->Quote(AriConstantsManager::getVar('EntityKey', AriQuizComponent::getCodeName()));
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId = ' . $profile->ProfileId;
		}
		if (!$exportController->addRecordsGroup($query, 'generictemplateentitymap'))
		{
			return false;
		}
		
		$query = 'SELECT DISTINCT MT.*' .
			' FROM #__ariquizmailtemplate MT INNER JOIN #__arigenerictemplate TT ON MT.TextTemplateId = TT.TemplateId' .
			' INNER JOIN #__arigenerictemplateentitymap TTEM ON TT.TemplateId = TTEM.TemplateId' .
			' INNER JOIN #__ariquiz Q ON TTEM.EntityId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		$query .= ' WHERE TTEM.EntityName = ' . $database->Quote(AriConstantsManager::getVar('EntityKey', AriQuizComponent::getCodeName()));
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId = ' . $profile->ProfileId;
		}
		if (!$exportController->addRecordsGroup($query, 'mailtemplate'))
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportQuizAccessData(&$exportController, $profile)
	{
		$query = 'SELECT QA.*' .
			' FROM #__ariquizaccess QA';
		if (!$profile->ExportAllQuizzes)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON QA.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'quizaccess'))
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportQuizCategoryData(&$exportController, $profile)
	{
		$allQuiz = $profile->ExportAllQuizzes;
		$query = 'SELECT QQC.*' .
			' FROM #__ariquizquizcategory QQC';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON QQC.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'quizquizcategory'))
		{
			return false;
		}
		
		$query = 'SELECT QC.*' .
			' FROM #__ariquizcategory QC INNER JOIN #__ariquizquizcategory QQC ON QC.CategoryId = QQC.CategoryId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON QQC.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'quizcategory'))
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportQuizProperties(&$exportController, $profile)
	{
		$query = 'SELECT QP.*' .
			' FROM #__ariquiz_property_value QP INNER JOIN #__ariquiz Q ON QP.EntityKey = Q.QuizId';
		if (!$profile->ExportAllQuizzes)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;;
		}
		
		if (!$exportController->addRecordsGroup($query, 'quizpropertyvalue'))
		{
			return false;
		}
		
		return true;
	}

	function _addExportQuizQuestions(&$exportController, $profile)
	{
		$allQuiz = $profile->ExportAllQuizzes;
		$query = 'SELECT QQ.*' .
			' FROM #__ariquizquestion QQ INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'question'))
		{
			return false;
		}
		
		$query = 'SELECT BQ.*' .
			' FROM #__ariquizquestion BQ INNER JOIN #__ariquizquestion QQ ON BQ.QuestionId = QQ.BankQuestionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'bankquestion'))
		{
			return false;
		}
		
		// Question category data
		$query = 'SELECT DISTINCT QC.*' .
			' FROM #__ariquizquestioncategory QC INNER JOIN #__ariquizquestion QQ ON QC.QuestionCategoryId = QQ.QuestionCategoryId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'questioncategory'))
		{
			return false;
		}
		
		// Bank category data
		$query = 'SELECT DISTINCT BC.*' .
			' FROM #__ariquizbankcategory BC INNER JOIN #__ariquizquestion BQ ON BC.CategoryId = BQ.QuestionCategoryId' .
			' INNER JOIN #__ariquizquestion QQ ON BQ.QuestionId = QQ.BankQuestionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'bankcategory'))
		{
			return false;
		}
		
		// Question version data
		$query = 'SELECT DISTINCT QQV.*' .
			' FROM #__ariquizquestion QQ INNER JOIN #__ariquizquestionversion QQV ON QQ.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
	
		if (!$exportController->addRecordsGroup($query, 'questionversion'))
		{
			return false;
		}
		
		$query = 'SELECT DISTINCT QQV.*' .
			' FROM #__ariquizquestion BQ INNER JOIN #__ariquizquestion QQ ON BQ.QuestionId = QQ.BankQuestionId' .
			' INNER JOIN #__ariquizquestionversion QQV ON BQ.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'bankquestionversion'))
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportQuizResultScale(&$exportController, $profile)
	{
		$allQuiz = $profile->ExportAllQuizzes;
		$query = 'SELECT RS.*' .
			' FROM #__ariquiz_result_scale RS INNER JOIN #__ariquiz Q ON Q.ResultScaleId = RS.ScaleId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'resultscale'))
		{
			return false;
		}
		
		$query = 'SELECT RSI.*' .
			' FROM #__ariquiz_result_scale_item RSI INNER JOIN #__ariquiz_result_scale RS ON RSI.ScaleId = RS.ScaleId' .
			' INNER JOIN #__ariquiz Q ON Q.ResultScaleId = RS.ScaleId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		if (!$exportController->addRecordsGroup($query, 'resultscaleitem'))
		{
			return false;
		}
		
		// text template
		$query = 'SELECT DISTINCT TT.*' .
			' FROM #__arigenerictemplate TT INNER JOIN #__ariquiz_result_scale_item RSI ON TT.TemplateId = RSI.TextTemplateId OR TT.TemplateId = RSI.MailTemplateId OR TT.TemplateId = RSI.PrintTemplateId' .
			' INNER JOIN #__ariquiz_result_scale RS ON RSI.ScaleId = RS.ScaleId' .
			' INNER JOIN #__ariquiz Q ON Q.ResultScaleId = RS.ScaleId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		if (!$allQuiz)
		{
			$query .= ' WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}

		if (!$exportController->addRecordsGroup($query, 'generictemplate'))
		{
			return false;
		}
		
		$query = 'SELECT DISTINCT MT.*' .
			' FROM #__ariquizmailtemplate MT INNER JOIN #__ariquiz_result_scale_item RSI ON MT.TextTemplateId = RSI.MailTemplateId' .
			' INNER JOIN #__ariquiz_result_scale RS ON RSI.ScaleId = RS.ScaleId' .
			' INNER JOIN #__ariquiz Q ON Q.ResultScaleId = RS.ScaleId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		if (!$allQuiz)
		{
			$query .= ' WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
		if (!$exportController->addRecordsGroup($query, 'mailtemplate'))
		{
			return false;
		}
		
		return true;
	}
	
	function _addExportQuizFiles(&$exportController, $profile)
	{
		$allQuiz = $profile->ExportAllQuizzes;
		$query = 'SELECT F.*' .
			' FROM #__ariquizfile F INNER JOIN #__ariquiz Q ON F.FileId = Q.CssTemplateId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}

		if (!$exportController->addRecordsGroup($query, 'file'))
		{
			return false;
		}
		
		// Question files relations
		$query = 'SELECT DISTINCT QVF.*' .
			' FROM #__ariquiz_question_version_files QVF INNER JOIN #__ariquizquestion QQ' .
			'	ON QVF.QuestionId = QQ.QuestionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
	
		if (!$exportController->addRecordsGroup($query, 'questionversionfiles'))
		{
			return false;
		}
		
		// Bank questions files relations
		$query = 'SELECT DISTINCT QVF.*' .
			' FROM #__ariquiz_question_version_files QVF INNER JOIN #__ariquizquestionversion QQV' .
			'	ON QVF.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN  #__ariquizquestion QQ' .
			'	ON QQ.BankQuestionId = QQV.QuestionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
	
		if (!$exportController->addRecordsGroup($query, 'questionversionfiles'))
		{
			return false;
		}
		
		// Question files
		$query = 'SELECT DISTINCT F.*' .
			' FROM #__ariquizfile F INNER JOIN #__ariquiz_question_version_files QVF' .
			'	ON F.FileId = QVF.FileId' .
			' INNER JOIN #__ariquizquestion QQ' .
			'	ON QVF.QuestionId = QQ.QuestionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
	
		if (!$exportController->addRecordsGroup($query, 'file'))
		{
			return false;
		}
		
		// Bank questions files
		$query = 'SELECT DISTINCT F.*' .
			' FROM #__ariquizfile F INNER JOIN #__ariquiz_question_version_files QVF' .
			'	ON F.FileId = QVF.FileId' .
			' INNER JOIN #__ariquizquestionversion QQV' .
			'	ON QVF.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN  #__ariquizquestion QQ' .
			'	ON QQ.BankQuestionId = QQV.QuestionId' .
			' INNER JOIN #__ariquiz Q ON QQ.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId WHERE EQ.ProfileId = ' . $profile->ProfileId;
		}
	
		if (!$exportController->addRecordsGroup($query, 'file'))
		{
			return false;
		}
		
		
		return true;
	}
	
	function _addExportQuizResults(&$exportController, $profile)
	{
		$allQuiz = $profile->ExportAllQuizzes;
		if ($allQuiz && !$profile->ExportQuizResults) return true;
		
		$query = 'SELECT QSI.*' .
			' FROM #__ariquizstatisticsinfo QSI INNER JOIN #__ariquiz Q ON QSI.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		$query .= ' WHERE QSI.Status = "Finished"';
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId=' . $profile->ProfileId . ' AND EQ.ExportResults = 1';
		}
		
		if (!$exportController->addRecordsGroup($query, 'quizstatisticsinfo'))
		{
			return false;
		}
		
		$query = 'SELECT QS.*' .
			' FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI ON QS.StatisticsInfoId = QSI.StatisticsInfoId' . 
			' INNER JOIN #__ariquiz Q ON QSI.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		$query .= ' WHERE QSI.Status = "Finished"';
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId=' . $profile->ProfileId . ' AND EQ.ExportResults = 1';
		}
		
		if (!$exportController->addRecordsGroup($query, 'quizstatistics'))
		{
			return false;
		}
		
		// Old question version
		$query = 'SELECT DISTINCT QQV.*' .
			' FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI ON QS.StatisticsInfoId = QSI.StatisticsInfoId' . 
			' LEFT JOIN #__ariquizquestion QQ ON QS.QuestionVersionId = QQ.QuestionVersionId' .
			' INNER JOIN #__ariquizquestionversion QQV ON QS.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN #__ariquiz Q ON QSI.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		$query .= ' WHERE QQ.QuestionId IS NULL AND QSI.Status = "Finished"';
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId=' . $profile->ProfileId . ' AND EQ.ExportResults = 1';
		}

		if (!$exportController->addRecordsGroup($query, 'questionversion'))
		{
			return false;
		}
		
		// Old bank question version
		$query = 'SELECT DISTINCT QBV.*' .
			' FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI ON QS.StatisticsInfoId = QSI.StatisticsInfoId' . 
			' LEFT JOIN #__ariquizquestion QQ ON QS.QuestionVersionId = QQ.QuestionVersionId' .
			' INNER JOIN #__ariquizquestionversion QQV ON QS.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN #__ariquizquestionversion QBV ON QS.BankVersionId = QBV.QuestionVersionId' .
			' INNER JOIN #__ariquiz Q ON QSI.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		$query .= ' WHERE QQ.QuestionId IS NULL AND QSI.Status = "Finished"';
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId=' . $profile->ProfileId . ' AND EQ.ExportResults = 1';
		}

		if (!$exportController->addRecordsGroup($query, 'bankquestionversion'))
		{
			return false;
		}
		
		// Old question category
		$query = 'SELECT DISTINCT QC.*' .
			' FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI ON QS.StatisticsInfoId = QSI.StatisticsInfoId' . 
			' LEFT JOIN #__ariquizquestion QQ ON QS.QuestionVersionId = QQ.QuestionVersionId' .
			' INNER JOIN #__ariquizquestionversion QQV ON QS.QuestionVersionId = QQV.QuestionVersionId' .
			' INNER JOIN #__ariquizquestioncategory QC ON QQV.QuestionCategoryId = QC.QuestionCategoryId' .
			' INNER JOIN #__ariquiz Q ON QSI.QuizId = Q.QuizId';
		if (!$allQuiz)
		{
			$query .= ' INNER JOIN #__ariquiz_export_quiz EQ ON Q.QuizId = EQ.QuizId';
		}
		
		$query .= ' WHERE QQ.QuestionId IS NULL AND QSI.Status = "Finished"';
		if (!$allQuiz)
		{
			$query .= ' AND EQ.ProfileId=' . $profile->ProfileId . ' AND EQ.ExportResults = 1';
		}

		if (!$exportController->addRecordsGroup($query, 'questioncategory'))
		{
			return false;
		}
		
		return true;
	}

	function getExportQuestionData(&$exportController, $profile)
	{
		return $this->_addExportBankQuestionsData($exportController, $profile);
	}	

	function _addExportBankQuestionsData(&$exportController, $profile)
	{
		$allQuestions = $profile->ExportAllBankQuestions;
		
		$query = 'SELECT QB.* FROM #__ariquizquestion QB';
		if (!$allQuestions)
		{
			$query .= ' INNER JOIN #__ariquiz_export_bankquestion EQB ON QB.QuestionId = EQB.QuestionId';
		}
		
		$query .= ' WHERE QB.QuizId = 0';
		if (!$allQuestions)
		{
			$query .= ' AND EQB.ProfileId=' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'bankquestion'/*, array('QuestionCategoryId' => 0)*/))
		{
			return false;
		}
		
		// Bank category data
		$query = 'SELECT DISTINCT BC.*' .
			' FROM #__ariquizbankcategory BC INNER JOIN #__ariquizquestion BQ ON BC.CategoryId = BQ.QuestionCategoryId';
		if (!$allQuestions)
		{
			$query .= ' INNER JOIN #__ariquiz_export_bankquestion EQB ON BQ.QuestionId = EQB.QuestionId';
		}
		
		$query .= ' WHERE BQ.QuizId = 0';
		if (!$allQuestions)
		{
			$query .= ' AND EQB.ProfileId=' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'bankcategory'))
		{
			return false;
		}
		
		$query = 'SELECT QBV.* FROM #__ariquizquestion QB INNER JOIN #__ariquizquestionversion QBV ON QB.QuestionVersionId = QBV.QuestionVersionId';
		if (!$allQuestions)
		{
			$query .= ' INNER JOIN #__ariquiz_export_bankquestion EQB ON QB.QuestionId = EQB.QuestionId';
		}
		
		$query .= ' WHERE QB.QuizId = 0';
		if (!$allQuestions)
		{
			$query .= ' AND EQB.ProfileId=' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'bankquestionversion'/*, array('QuestionCategoryId' => 0)*/))
		{
			return false;
		}
		
		// Files
		$query = 'SELECT QVF.* FROM #__ariquiz_question_version_files QVF INNER JOIN #__ariquizquestion QB' .
			'	ON QVF.QuestionVersionId = QB.QuestionVersionId';
		if (!$allQuestions)
		{
			$query .= ' INNER JOIN #__ariquiz_export_bankquestion EQB ON QB.QuestionId = EQB.QuestionId';
		}
		
		$query .= ' WHERE QB.QuizId = 0';
		if (!$allQuestions)
		{
			$query .= ' AND EQB.ProfileId=' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'questionversionfiles'))
		{
			return false;
		}
		
		$query = 'SELECT F.* FROM #__ariquizfile F INNER JOIN #__ariquiz_question_version_files QVF' .
			'	ON F.FileId = QVF.FileId' .
			' INNER JOIN #__ariquizquestion QB' .
			'	ON QVF.QuestionVersionId = QB.QuestionVersionId';
		if (!$allQuestions)
		{
			$query .= ' INNER JOIN #__ariquiz_export_bankquestion EQB ON QB.QuestionId = EQB.QuestionId';
		}
		
		$query .= ' WHERE QB.QuizId = 0';
		if (!$allQuestions)
		{
			$query .= ' AND EQB.ProfileId=' . $profile->ProfileId;
		}
		
		if (!$exportController->addRecordsGroup($query, 'file'))
		{
			return false;
		}
		
		$query = 'SELECT DISTINCT QC.*' .
			' FROM #__ariquizbankcategory QC INNER JOIN #__ariquizquestion QB ON QC.CategoryId = QB.QuestionCategoryId';
		if (!$allQuestions)
		{
			$query .= ' INNER JOIN #__ariquiz_export_bankquestion EQB ON QB.QuestionId = EQB.QuestionId';
		}
		$query .= ' WHERE QB.QuizId = 0';

		if (!$allQuestions)
		{
			$query .= ' AND EQB.ProfileId=' . $profile->ProfileId;
		}

		if (!$exportController->addRecordsGroup($query, 'bankcategory'))
		{
			return false;
		}
				
		return true;
	}
	
	function saveExportQuizResultSettings($profileId, $values)
	{
		$database =& JFactory::getDBO();

		$profileId = @intval($profileId, 10);
		if ($profileId < 1 || !is_array($values) || count($values) == 0) return true;

		$data = array();
		foreach ($values as $quizId => $needExport)
		{
			$quizId = @intval($quizId, 10);
			if ($quizId < 1 || key_exists($quizId, $data)) continue;
			
			$data[] = sprintf('(%d,%d,%d)',
				$profileId,
				$quizId,
				$needExport ? 1 : 0);
		}
		
		if (count($data) == 0) return true;
		
		$query = sprintf('INSERT INTO #__ariquiz_export_quiz (ProfileId,QuizId,ExportResults) VALUES %s ON DUPLICATE KEY UPDATE ExportResults=VALUES(ExportResults)',
			join(',', $data));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			return false;
		}
		
		return true;
	}
	
	function saveExportProfile($profileId, $fields, $ownerId)
	{
		$database =& JFactory::getDBO();

		$error = 'ARI: Couldnt save export settings.';
		
		$profileId = @intval($profileId, 10);
		$isUpdate = ($profileId > 0);

		$row = $isUpdate ? $this->getExportProfile($profileId) : $this->createExportProfileInstance();
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
		
		$row->ExportAllQuizzes = !empty($fields['ExportAllQuizzes']) ? 1 : 0;
		$row->ExportAllBankQuestions = !empty($fields['ExportAllBankQuestions']) ? 1 : 0;
		$row->ExportQuizzes = !empty($fields['ExportQuizzes']) ? 1 : 0;
		$row->ExportBankQuestions = !empty($fields['ExportBankQuestions']) ? 1 : 0;
		$row->ExportQuizResults = !empty($fields['ExportQuizResults']) ? 1 : 0;

		if (!$row->store())
		{
			trigger_error($error, E_USER_ERROR);
			return null;
		}

		return $row;
	}
	
	function getProfileIdByAlias($alias)
	{
		$database =& JFactory::getDBO();
		
		if (empty($alias)) return 0;

		$query = sprintf('SELECT ProfileId FROM #__ariquiz_export WHERE ProfileAlias = %s LIMIT 0,1',
			$database->Quote($alias));
		$database->setQuery($query);
		$profileId = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get export profile id by alias.', E_USER_ERROR);
			return 0;
		}
		
		return $profileId;
	}
	
	function getExportProfile($profileId)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt get export settings.';

		$profile = $this->createExportProfileInstance();
		if ($profileId > 0)
		{
			if (!$profile->load($profileId))
			{
				trigger_error($errorMessage, E_USER_ERROR);
				return null;
			}
		}

		return $profile;
	}
}
?>