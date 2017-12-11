<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.ControllerBase');
AriKernel::import('Controllers.AriQuiz.QuizController');
AriKernel::import('Controllers.AriQuiz.QuestionCategoryController');
AriKernel::import('Controllers.AriQuiz.QuestionController');
AriKernel::import('Security.Security');

class AriUserQuizControllerConstants extends AriClassConstants 
{
	var $ErrorCode = array(
		'TakeQuiz' => array(
			'None' => 0,
			'LagTime' => 1,
			'AttemptCount' => 2,
			'NotRegistered' => 3,
			'NotHavePermissions' => 4,
			'UnknownError' => 5,
			'HasPausedQuiz' => 6,
			'DateAccess' => 7
			));
	
	function getClassName()
	{
		return strtolower('AriUserQuizControllerConstants');
	}
}

new AriUserQuizControllerConstants();

class AriUserQuizController extends AriControllerBase
{
	var $QUESTION_PART_COUNT = 100;
	
	function getQuestionAttemptsData($statisticsId)
	{
		$database =& JFactory::getDBO();

		$statisticsId = @intval($statisticsId, 10);
		
		$query = sprintf('SELECT Data,CreatedDate FROM #__ariquizstatistics_attempt WHERE StatisticsId = %d ORDER BY CreatedDate ASC',
			$statisticsId);
		$database->setQuery($query);
		$data = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt save question attempt.', E_USER_ERROR);
			return null;
		}
		
		return $data;
	}
	
	function saveQuestionAttempt($statisticsId, $data)
	{
		$database =& JFactory::getDBO();

		$statisticsId = @intval($statisticsId, 10);
		$date = ArisDate::getDbUTC();
		
		$query = sprintf('INSERT INTO #__ariquizstatistics_attempt (StatisticsId, Data, CreatedDate) VALUES(%d, %s, %d)',
			$statisticsId,
			$database->Quote($data),
			$database->Quote($date));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt save question attempt.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}

	function stopQuiz($sid, $userId)
	{
		$database =& JFactory::getDBO();

		$userId = @intval($userId, 10);
		if ($userId < 1 || $sid < 1) return false;

		$statisticsId = $this->getCurrentStatisticsId($sid, $userId);
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		if (empty($statisticsId)) return false;
		$stopDate = ArisDate::getDbUTC();
		
		$query = sprintf('UPDATE #__ariquizstatisticsinfo SET Status = "Pause",CurrentStatisticsId=%d,ModifiedDate=%s WHERE StatisticsInfoId = %d AND `Status` = "Process"',
			$statisticsId,
			$database->Quote($stopDate),
			$sid);
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		return true;
	}

	function hasPausedQuiz($quizId, $userId)
	{
		$database =& JFactory::getDBO();
		
		$quizId = @intval($quizId, 10);
		if ($quizId < 1) return false;
		
		$userId = @intval($userId, 10);
		if ($userId < 1) return false;
		
		$query = sprintf('SELECT COUNT(*)' .
			' FROM #__ariquizstatisticsinfo' .
			' WHERE UserId = %d AND QuizId = %d AND `Status` = "Pause"',
			$userId,
			$quizId);
		$database->setQuery($query);
		$result = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get count of paused quiz.', E_USER_ERROR);
			return false;
		}
		
		return ($result > 0);
	}
	
	function getPausedId($quizId, $userId)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt get ticket id for paused quiz.';
		
		$quizId = @intval($quizId, 10);
		if ($quizId < 1) return null;
		
		$userId = @intval($userId, 10);
		if ($userId < 1) return null;
		
		$query = sprintf('SELECT TicketId FROM #__ariquizstatisticsinfo WHERE QuizId = %d AND UserId = %d AND `Status` = "Pause" LIMIT 0,1',
			$quizId,
			$userId);
		$database->setQuery($query);
		$ticketId = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return null;
		}
		
		return $ticketId;
	}
	
	function resumeQuizById($ticketId, $userId)
	{
		$database =& JFactory::getDBO();
		
		$userId = @intval($userId, 10);
		if (empty($ticketId) || $userId < 1) return false;
		
		$now = ArisDate::getDbUTC();		
		$query = sprintf('UPDATE #__ariquizstatisticsinfo QSI INNER JOIN #__ariquizstatistics QS' .
			' ON QSI.CurrentStatisticsId = QS.StatisticsId' .
			' SET QSI.Status = "Process", QSI.UsedTime = QSI.UsedTime + (UNIX_TIMESTAMP(QSI.ModifiedDate) - UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate, QSI.StartDate))), QS.UsedTime = QS.UsedTime + (UNIX_TIMESTAMP(QSI.ModifiedDate) - UNIX_TIMESTAMP(QS.StartDate)), QS.StartDate = %1$s, QSI.ResumeDate = %1$s, QSI.CurrentStatisticsId = NULL' .
			' WHERE QSI.TicketId = %2$s AND QSI.Status = "Pause"',
			$database->Quote($now),
			$database->Quote($ticketId));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt resume quiz.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function resumeQuiz($quizId, $userId)
	{
		$ticketId = $this->getPausedId($quizId, $userId);
		if (empty($ticketId)) return null;
		
		$result = $this->resumeQuizById($ticketId, $userId);
		if ($this->_isError(true, false))
		{
			trigger_error('ARI: Couldnt resume quiz.', E_USER_ERROR);
			return null;
		}
		
		return $result ? $ticketId : null;
	}
	
	function getQuizByTicketId($ticketId)
	{
		$database =& JFactory::getDBO();

		$error = 'ARI: Couldnt get quiz by ticket ID.';
		
		$quiz = AriEntityFactory::createInstance('AriQuizEntity', AriGlobalPrefs::getEntityGroup());
		$query = sprintf('SELECT Q.*' .
			' FROM #__ariquiz Q INNER JOIN #__ariquizstatisticsinfo QSI' .
			' 	ON Q.QuizId = QSI.QuizId' .
			' WHERE QSI.TicketId = %s LIMIT 0,1',
			$database->Quote($ticketId));
		$database->setQuery($query);
		$quizFields = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return null;
		}
		
		if (!empty($quizFields) && count($quizFields) > 0)
		{
			if (!$quiz->bind($quizFields[0]))
			{
				trigger_error($error, E_USER_ERROR);
				return null;
			}
		}

		return $quiz;
	}

	function markQuizAsFinished($ticketId, $userId = 0)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt mark quiz as finished.';
		$statisticsInfoId = $this->getStatisticsInfoIdByTicketId($ticketId, $userId, 'Process');
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		if (!empty($statisticsInfoId))
		{
			$resultController = new AriQuizResultController();
			
			$finishedInfo = $resultController->getFinishedInfo($statisticsInfoId);
			if ($this->_isError(true, false))
			{
				trigger_error($error, E_USER_ERROR);
				return false;
			}
			
			$finishedDate = $this->getFinishedQuizDate($statisticsInfoId);
			if ($this->_isError(true, false))
			{
				trigger_error($error, E_USER_ERROR);
				return false;
			}

			$query = sprintf('UPDATE #__ariquizstatisticsinfo SET Status = "Finished",EndDate = %s,MaxScore = %d,UserScore = %d,Passed = %d WHERE StatisticsInfoId = %d',
				$database->Quote($finishedDate),
				$finishedInfo['MaxScore'],
				$finishedInfo['UserScore'],
				$finishedInfo['Passed'],
				$statisticsInfoId);
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error($error, E_USER_ERROR);
				return false;
			}
			
			return true;
		}
		
		return false;
	}
	
	function getFinishedQuizDate($statisticsInfoId)
	{
		$database =& JFactory::getDBO();
		$query = sprintf('SELECT IF(QSI.TotalTime > 0, FROM_UNIXTIME(UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate,QSI.StartDate)) + QSI.TotalTime - QSI.UsedTime), NULL) AS EndDate2, IF(QS.QuestionTime > 0, FROM_UNIXTIME(UNIX_TIMESTAMP(QS.StartDate) + QS.QuestionTime - QS.UsedTime), NULL) AS EndDate1, QS.EndDate FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI ON QS.StatisticsInfoId = QSI.StatisticsInfoId WHERE QS.StatisticsInfoId = %d ORDER BY QS.StartDate DESC LIMIT 0,1',
			$statisticsInfoId);
		$database->setQuery($query);
		$date = null;
		$obj = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get finished quiz date.', E_USER_ERROR);
			return false;
		}

		if (!empty($obj) && count($obj) > 0)
		{
			$obj = $obj[0];
			if (!empty($obj['EndDate']))
			{
				$date = $obj['EndDate'];
			}
			else
			{
				$endDate1 = $obj['EndDate1'];
				$endDate2 = $obj['EndDate2'];
				$date = (empty($endDate2) || ($endDate1 && $endDate1 < $endDate2))
					? $endDate1
					: $endDate2;
			}
		}

		return $date;
	}

	function updateStatisticsInfo($statistics)
	{
		if ($statistics && !$statistics->store())
		{
			trigger_error('ARI: Couldnt update statistics.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function skipQuestion($statisticsId, $skipDate = null, $data = null)
	{
		$database =& JFactory::getDBO();
		
		if (empty($skipDate)) $skipDate = ArisDate::getDbUTC();
		$skipDate = $database->Quote($skipDate);
		
		$query = sprintf('UPDATE #__ariquizstatistics' .
			' SET UsedTime = UsedTime + (UNIX_TIMESTAMP(%s) - UNIX_TIMESTAMP(StartDate)),' .
			' SkipCount = SkipCount + 1,SkipDate = %s,StartDate = NULL,`Data`=%s' .
			' WHERE StatisticsId = %d', 
			$skipDate,
			$skipDate, 
			!empty($data) ? $database->Quote($data) : 'NULL',
			intval($statisticsId));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt skip question.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function getQuizIdByTicketId($ticketId)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT QuizId FROM #__ariquizstatisticsinfo WHERE TicketId = %s LIMIT 0, 1',
			$database->Quote($ticketId));
		$database->setQuery($query);
		$quizId = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get quiz id by ticket id.', E_USER_ERROR);
			return 0;
		}
		
		return $quizId;
	}
	
	function getCurrentQuestion($sid, $userId = 0)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt get current question.';

		$entityGroup = AriGlobalPrefs::getEntityGroup();
		$questionEntity = AriEntityFactory::createInstance('AriQuizQuestionEntity', $entityGroup);
		$questionVersionEntity = AriEntityFactory::createInstance('AriQuizQuestionVersionEntity', $entityGroup);
		$questionTypeEntity = AriEntityFactory::createInstance('AriQuizQuestionTypeEntity', $entityGroup);
		
		$fieldsStr = $this->_getModifiedFields($questionEntity, 'QQ', '_1') .
			',' . $this->_getModifiedFields($questionVersionEntity, 'QQV', '_2') .
			',' . $this->_getModifiedFields($questionTypeEntity, 'QQT', '_3') .
			',' . $this->_getModifiedFields($questionVersionEntity, 'QQVB', '_4');
		
		$userId = intval($userId, 10);
		$query = sprintf('SELECT SS.*,' . $fieldsStr .
			' FROM' . 
			' #__ariquizstatisticsinfo SSI INNER JOIN #__ariquizstatistics SS' . 
			' 	ON SSI.StatisticsInfoId = SS.StatisticsInfoId' .
		    ' INNER JOIN #__ariquizquestion QQ' .
		    '	ON SS.QuestionId = QQ.QuestionId' .
		    ' INNER JOIN #__ariquizquestionversion QQV' .
		    '	ON SS.QuestionVersionId = QQV.QuestionVersionId' .
		    ' LEFT JOIN #__ariquizquestionversion QQVB' .
		    '	ON SS.BankVersionId = QQVB.QuestionVersionId' .
		    ' INNER JOIN #__ariquizquestiontype QQT' .
		    '	ON QQT.QuestionTypeId = IFNULL(QQVB.QuestionTypeId,QQV.QuestionTypeId)' .
			' WHERE SSI.StatisticsInfoId = %1$d AND' .
			' (%2$d = 0 OR SSI.UserId = %2$d) AND' .
			' SS.StartDate IS NOT NULL AND' .
			' SS.EndDate IS NULL AND' .
			' (SS.QuestionTime = 0 OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(SS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(SS.StartDate), 0) + SS.UsedTime < SS.QuestionTime)) AND' .
			' (SSI.TotalTime = 0 OR SSI.StartDate IS NULL OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), 0) + SSI.UsedTime) < SSI.TotalTime)' .
			' ORDER BY SS.SkipDate ASC,SS.QuestionIndex ASC' . 
			' LIMIT 0,1', 
			$sid, 
			$userId);
		$database->setQuery($query);
		$fields = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get current statistics.', E_USER_ERROR);
			return 0;
		}

		if (empty($fields) || count($fields) < 1) return null;
		
		$fields = $this->_modifySource($fields[0],
			array(
				array(
					'Entity' => $questionEntity,
					'Postfix' => '_1',
					'Key' => 'Question'
				),
				array(
					'Entity' => $questionVersionEntity,
					'Postfix' => '_2',
					'Key' => 'QuestionVersion',
					'Parent' => 'Question'
				),
				array(
					'Entity' => $questionTypeEntity,
					'Postfix' => '_3',
					'Key' => 'QuestionType',
					'Parent' => array('QuestionVersion', 'BankQuestionVersion')
				),
				array(
					'Entity' => $questionVersionEntity,
					'Postfix' => '_4',
					'Key' => 'BankQuestionVersion',
					'Parent' => 'Question'
				),
			));

		$statistics = AriEntityFactory::createInstance('AriQuizStatisticsEntity', AriGlobalPrefs::getEntityGroup());
		$statistics->bind($fields, array(), true);

		return $statistics;
	}
	
	function getCurrentStatisticsId($sid, $userId = 0)
	{
		$database =& JFactory::getDBO();
		
		$userId = intval($userId, 10);
		$query = sprintf('SELECT SS.StatisticsId FROM' . 
			' #__ariquizstatisticsinfo SSI INNER JOIN #__ariquizstatistics SS' . 
			' 	ON SSI.StatisticsInfoId = SS.StatisticsInfoId' . 
			' WHERE SSI.StatisticsInfoId = %1$d AND' .
			' (%2$d = 0 OR SSI.UserId = %2$d) AND' .
			' SS.StartDate IS NOT NULL AND' .
			' SS.EndDate IS NULL AND' .
			' (SS.QuestionTime = 0 OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(SS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(SS.StartDate), 0) + SS.UsedTime < SS.QuestionTime)) AND' .
			' (SSI.TotalTime = 0 OR SSI.StartDate IS NULL OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), 0) + SSI.UsedTime) < SSI.TotalTime)' .
			' ORDER BY SS.SkipDate ASC,SS.QuestionIndex ASC' . 
			' LIMIT 0,1', 
			$sid, 
			$userId);
		$database->setQuery($query);
		$result = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get current statistics id.', E_USER_ERROR);
			return 0;
		}
		
		return $result;
	}

	function setSafeQuizStartDate($sid, $startDate = null)
	{
		$database =& JFactory::getDBO();
		
		if (empty($startDate)) $startDate = ArisDate::getDbUTC();
		
		$query = sprintf('UPDATE #__ariquizstatisticsinfo SET StartDate = %s WHERE StatisticsInfoId = %d AND StartDate IS NULL', 
			$database->Quote($startDate),
			$sid);
		$database->setQuery($query);
		$database->query();
		
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt set quiz start date.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function setStatisticsStart($statisticsId, $ip, $startDate = null)
	{
		$database =& JFactory::getDBO();
		
		if (empty($startDate)) $startDate = ArisDate::getDbUTC();
		
		$query = sprintf('UPDATE #__ariquizstatistics SET StartDate = %s,IpAddress = %d WHERE StatisticsId = %d', 
			$database->Quote($startDate),
			ip2long($ip), 
			intval($statisticsId));
		$database->setQuery($query);
		$database->query();
		
		if ($database->getErrorNum())
		{
			trigger_error('ARI: couldnt set statistics start date.', E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	function getUserCompletedQuestion($sid)
	{
		$database =& JFactory::getDBO();

		$query = sprintf('SELECT COUNT(*) FROM #__ariquizstatistics SS' . 
			' WHERE SS.StatisticsInfoId = %d AND' . 
			' (SS.EndDate IS NOT NULL OR' . 
			' (SS.StartDate IS NOT NULL AND (SS.QuestionTime IS NOT NULL AND SS.QuestionTime > 0) AND (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(SS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(SS.StartDate), 0) + SS.UsedTime) >= SS.QuestionTime))', 
			$sid);
		$database->setQuery($query);
		$result = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get user completed question count.', E_USER_ERROR);
			return 0;
		}
		
		return $result;
	}

	function getUserQuizInfo($sid)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT QSI.QuizId,QSI.TotalTime,QSI.UsedTime, IFNULL(QSI.ResumeDate, QSI.StartDate) AS RealStartDate, UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate, QSI.StartDate)) AS StartDate, UNIX_TIMESTAMP(UTC_TIMESTAMP()) AS Now, Q.QuizName,Q.CanSkip,Q.CanStop,Q.UseCalculator,Q.ShowCorrectAnswer,Q.ShowExplanation,Q.CssTemplateId,Q.ParsePluginTag,Q.QuestionOrderType,QSI.QuestionCount' .
				' FROM #__ariquizstatisticsinfo QSI INNER JOIN #__ariquiz Q' .
				'	ON QSI.QuizId = Q.QuizId' .
				' WHERE QSI.StatisticsInfoId = %d AND QSI.Status = "Process" LIMIT 0,1',
				$sid);
		$database->setQuery($query);
		$result = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get user quiz info.', E_USER_ERROR);
			return null;
		}
		
		return $result && count($result) > 0 ? $result[0] : null;
	}

	function isQuizFinished($sid)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt check that quiz finished.';
		
		$query = sprintf('SELECT COUNT(*) FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI' .
			' 	ON QS.StatisticsInfoId = QSI.StatisticsInfoId' . 
			' WHERE QS.StatisticsInfoId = %d AND' . 
			' (QS.StartDate IS NULL OR' .
			' (QS.EndDate IS NULL AND' . 
			' (QS.QuestionTime = 0 OR' . 
			' IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(QS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(QS.StartDate), 0) + QS.UsedTime < QS.QuestionTime ))) AND' .
			' (QSI.TotalTime = 0 OR QSI.StartDate IS NULL OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate, QSI.StartDate)), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate, QSI.StartDate)), 0) + QSI.UsedTime) < QSI.TotalTime)' .
			' ORDER BY NULL' . 
			' LIMIT 0,1', 
			$sid);
		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return false;			
		}
		
		return ($count === 0 || $count === '0');
	}
	
	function isQuizFinishedByTicketId($ticketId)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt check that quiz finished.'; 

		$query = sprintf('SELECT COUNT(*) FROM #__ariquizstatistics QS INNER JOIN #__ariquizstatisticsinfo QSI' .
			' 	ON QS.StatisticsInfoId = QSI.StatisticsInfoId' . 
			' WHERE QSI.TicketId = %s AND' . 
			' (QS.StartDate IS NULL OR' .
			' (QS.EndDate IS NULL AND' . 
			' (QS.QuestionTime = 0 OR' . 
			' IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(QS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(QS.StartDate), 0) + QS.UsedTime < QS.QuestionTime ))) AND' .
			' (QSI.TotalTime = 0 OR QSI.StartDate IS NULL OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate, QSI.StartDate)), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(IFNULL(QSI.ResumeDate, QSI.StartDate)), 0) + QSI.UsedTime) < QSI.TotalTime)' .
			' ORDER BY NULL' .
			' LIMIT 0,1', 
			$database->Quote($ticketId));
		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return false;			
		}
		
		return ($count === 0 || $count === '0');
	}
	
	function getNextQuestion($sid, $userId = 0)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt get next question.';

		$entityGroup = AriGlobalPrefs::getEntityGroup();
		$questionEntity = AriEntityFactory::createInstance('AriQuizQuestionEntity', $entityGroup);
		$questionVersionEntity = AriEntityFactory::createInstance('AriQuizQuestionVersionEntity', $entityGroup);
		$questionTypeEntity = AriEntityFactory::createInstance('AriQuizQuestionTypeEntity', $entityGroup);
		
		$fieldsStr = $this->_getModifiedFields($questionEntity, 'QQ', '_1') .
			',' . $this->_getModifiedFields($questionVersionEntity, 'QQV', '_2') .
			',' . $this->_getModifiedFields($questionTypeEntity, 'QQT', '_3') .
			',' . $this->_getModifiedFields($questionVersionEntity, 'QQVB', '_4');
		
		$userId = intval($userId, 10);
		$query = sprintf('SELECT SS.*,' . $fieldsStr .
			' FROM' . 
			' #__ariquizstatisticsinfo SSI INNER JOIN #__ariquizstatistics SS' . 
			' 	ON SSI.StatisticsInfoId = SS.StatisticsInfoId' .
		    ' INNER JOIN #__ariquizquestion QQ' .
		    '	ON SS.QuestionId = QQ.QuestionId' .
		    ' INNER JOIN #__ariquizquestionversion QQV' .
		    '	ON SS.QuestionVersionId = QQV.QuestionVersionId' .
		    ' LEFT JOIN #__ariquizquestionversion QQVB' .
		    '	ON SS.BankVersionId = QQVB.QuestionVersionId' .
		    ' INNER JOIN #__ariquizquestiontype QQT' .
		    '	ON QQT.QuestionTypeId = IFNULL(QQVB.QuestionTypeId,QQV.QuestionTypeId)' .
			' WHERE SSI.StatisticsInfoId = %1$d AND' .
			' (%2$d = 0 OR SSI.UserId = %2$d) AND' . 
			' SS.EndDate IS NULL AND' . 
			' (SS.StartDate IS NULL OR (SS.QuestionTime = 0) OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(SS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(SS.StartDate), 0) + SS.UsedTime) < SS.QuestionTime) AND' .
			' (SSI.TotalTime = 0 OR SSI.StartDate IS NULL OR (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), 0) + SSI.UsedTime) < SSI.TotalTime)' . 
			' ORDER BY SS.SkipDate ASC,SS.QuestionIndex ASC' . 
			' LIMIT 0,1', 
			$sid, 
			$userId);
		$database->setQuery($query);
		$fields = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return 0;
		}

		if (empty($fields) || count($fields) < 1) return null;
		
		$fields = $this->_modifySource($fields[0],
			array(
				array(
					'Entity' => $questionEntity,
					'Postfix' => '_1',
					'Key' => 'Question'
				),
				array(
					'Entity' => $questionVersionEntity,
					'Postfix' => '_2',
					'Key' => 'QuestionVersion',
					'Parent' => 'Question'
				),
				array(
					'Entity' => $questionTypeEntity,
					'Postfix' => '_3',
					'Key' => 'QuestionType',
					'Parent' => array('QuestionVersion', 'BankQuestionVersion')
				),
				array(
					'Entity' => $questionVersionEntity,
					'Postfix' => '_4',
					'Key' => 'BankQuestionVersion',
					'Parent' => 'Question'
				),
			));

		$statistics = AriEntityFactory::createInstance('AriQuizStatisticsEntity', AriGlobalPrefs::getEntityGroup());
		$statistics->bind($fields, array(), true);

		return $statistics;
	}
	
	function getStatisticsByQuestionId($sid, $questionId, $userId = 0)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Couldnt get statistics by question id.';

		$entityGroup = AriGlobalPrefs::getEntityGroup();
		$questionEntity = AriEntityFactory::createInstance('AriQuizQuestionEntity', $entityGroup);
		$questionVersionEntity = AriEntityFactory::createInstance('AriQuizQuestionVersionEntity', $entityGroup);
		$questionTypeEntity = AriEntityFactory::createInstance('AriQuizQuestionTypeEntity', $entityGroup);
		
		$fieldsStr = $this->_getModifiedFields($questionEntity, 'QQ', '_1') .
			',' . $this->_getModifiedFields($questionVersionEntity, 'QQV', '_2') .
			',' . $this->_getModifiedFields($questionTypeEntity, 'QQT', '_3') .
			',' . $this->_getModifiedFields($questionVersionEntity, 'QQVB', '_4');
		
		$userId = intval($userId, 10);
		$query = sprintf('SELECT SS.*,' . $fieldsStr .
			' FROM' . 
			' #__ariquizstatisticsinfo SSI INNER JOIN #__ariquizstatistics SS' . 
			' 	ON SSI.StatisticsInfoId = SS.StatisticsInfoId' .
		    ' INNER JOIN #__ariquizquestion QQ' .
		    '	ON SS.QuestionId = QQ.QuestionId' .
		    ' INNER JOIN #__ariquizquestionversion QQV' .
		    '	ON SS.QuestionVersionId = QQV.QuestionVersionId' .
		    ' LEFT JOIN #__ariquizquestionversion QQVB' .
		    '	ON SS.BankVersionId = QQVB.QuestionVersionId' .
		    ' INNER JOIN #__ariquizquestiontype QQT' .
		    '	ON QQT.QuestionTypeId = IFNULL(QQVB.QuestionTypeId,QQV.QuestionTypeId)' .
			' WHERE SSI.StatisticsInfoId = %1$d AND' .
			' SSI.Status = "Process" AND' . 
			' SS.QuestionId = %3$d AND' .
			' (%2$d = 0 OR SSI.UserId = %2$d) AND' . 
			' (' .
			'	SS.EndDate IS NOT NULL OR' . 
			' 	(SS.StartDate IS NOT NULL AND (SS.QuestionTime > 0) AND (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(SS.StartDate), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(SS.StartDate), 0) + SS.UsedTime) >= SS.QuestionTime) OR' .
			' 	(SSI.TotalTime > 0 AND SSI.StartDate IS NOT NULL AND (IF(UNIX_TIMESTAMP(UTC_TIMESTAMP()) > UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(IFNULL(SSI.ResumeDate, SSI.StartDate)), 0) + SSI.UsedTime) >= SSI.TotalTime)' .
			' )' . 
			' ORDER BY NULL' . 
			' LIMIT 0,1', 
			$sid, 
			$userId,
			$questionId);
		$database->setQuery($query);
		$fields = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return 0;
		}

		if (empty($fields) || count($fields) < 1) return null;
		
		$fields = $this->_modifySource($fields[0],
			array(
				array(
					'Entity' => $questionEntity,
					'Postfix' => '_1',
					'Key' => 'Question'
				),
				array(
					'Entity' => $questionVersionEntity,
					'Postfix' => '_2',
					'Key' => 'QuestionVersion',
					'Parent' => 'Question'
				),
				array(
					'Entity' => $questionTypeEntity,
					'Postfix' => '_3',
					'Key' => 'QuestionType',
					'Parent' => array('QuestionVersion', 'BankQuestionVersion')
				),
				array(
					'Entity' => $questionVersionEntity,
					'Postfix' => '_4',
					'Key' => 'BankQuestionVersion',
					'Parent' => 'Question'
				),
			));

		$statistics = AriEntityFactory::createInstance('AriQuizStatisticsEntity', AriGlobalPrefs::getEntityGroup());
		$statistics->bind($fields, array(), true);

		return $statistics;
	}
	
	function isComposedUserQuiz($ticketId)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT COUNT(*) FROM #__ariquizstatisticsinfo WHERE TicketId = %s AND Status <> "Prepare" LIMIT 0, 1', 
			$database->Quote($ticketId));
		$database->setQuery($query);
		$count = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt check thar quiz composed.', E_USER_ERROR);
			return false;
		}
		
		return ($count > 0);
	}

	function composeUserQuiz($quizId, $ticketId, $userId, &$rQuestionCount)
	{
		$database =& JFactory::getDBO();
		
		$rQuestionCount = -1;
		$error = 'ARI: Couldnt compose user quiz.';
		
		$quizId = intval($quizId, 10);
		$userId = intval($userId);
		
		if ($this->isComposedUserQuiz($ticketId))
		{
			return true;
		}
		
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		$quizController = new AriQuizController();
		$quiz = $quizController->getQuiz($quizId);
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		if (empty($quiz->QuizId))
		{
			return false;
		}
		
		$statisticsId = $this->getStatisticsInfoIdByTicketId($ticketId, 0, 'Prepare');
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		if (empty($statisticsId))
		{
			return false;
		}
		
		$questionCatController = new AriQuizQuestionCategoryController();
		$qCategoryList = $questionCatController->getQuestionCategoryList($quizId);
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		if (!is_array($qCategoryList))
			$qCategoryList = array();
			
		// add uncategory questions
		$uncategory = new stdClass();
		$uncategory->QuestionCategoryId = 0;
		$uncategory->QuestionCount = 0;//$quiz->QuestionCount;
		$uncategory->QuestionTime = $quiz->QuestionTime;
		$qCategoryList[] = $uncategory;

		$defaultQuestionTime = $quiz->QuestionTime;
		$questions = $this->_composeQuestions($quizId, $quiz->RandomQuestion, $qCategoryList, $defaultQuestionTime);
		if ($this->_isError(true, false))
		{			
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		$questionCount = !empty($questions) ? count($questions) : 0;		
		if ($questionCount > 0)
		{
			if ($quiz->QuestionCount > 0 && $questionCount > $quiz->QuestionCount)
			{
				$queKeys = array_rand($questions, $quiz->QuestionCount);
				if (!is_array($queKeys)) $queKeys = array($queKeys);
				$tempQuestions = array();
				foreach ($queKeys as $key)
				{
					$tempQuestions[] = $questions[$key];
				}
				$questions = $tempQuestions;	
				$questionCount = $quiz->QuestionCount;
			}
			$queryList = array();
			$index = 0;
			
			$queryList[] = sprintf('DELETE FROM #__ariquizstatistics WHERE StatisticsInfoId = %d', $statisticsId);
			$queryValues = array();
			foreach ($questions as $question)
			{
				$queryValues[] = sprintf('(%d,%d,%d,%d,%d,%d,%d,%d)',
					$question->QuestionId, 
					$question->QuestionVersionId, 
					$statisticsId, 
					$index,
					isset($question->QuestionTime) ? $question->QuestionTime : 0, 
					$question->QuestionCategoryId,
					!empty($question->BankQuestionId) ? $question->BankQuestionId : 0,
					!empty($question->BankVersionId) ? $question->BankVersionId : 0);
				++$index;

				if ($index % $this->QUESTION_PART_COUNT == 0)
				{
					$queryList[] = 'INSERT INTO #__ariquizstatistics (QuestionId,QuestionVersionId,StatisticsInfoId,QuestionIndex,QuestionTime,QuestionCategoryId,BankQuestionId,BankVersionId) VALUES' . join(',', $queryValues);
					$queryValues = array();
				}
			}

			if ($index % $this->QUESTION_PART_COUNT != 0 && count($queryValues) > 0)
			{
				$queryList[] = 'INSERT INTO #__ariquizstatistics (QuestionId,QuestionVersionId,StatisticsInfoId,QuestionIndex,QuestionTime,QuestionCategoryId,BankQuestionId,BankVersionId) VALUES' . join(',', $queryValues);
			}
			
			$queryList[] = sprintf('UPDATE #__ariquizstatisticsinfo' . 
				' SET Status = "Process", StartDate = NULL, PassedScore = %d, QuestionCount = %d, TotalTime = %s' .
				' WHERE StatisticsInfoId = %d AND Status = "Prepare"', 
				//$database->Quote(ArisDate::getDbUTC()),
				$quiz->PassedScore,
				$questionCount,
				is_null($quiz->TotalTime) ? 'NULL' : $quiz->TotalTime, 
				$statisticsId);
				
			$database->setQuery(join($queryList, ';'));
			$database->queryBatch();

			if ($database->getErrorNum())
			{
				trigger_error($error, E_USER_ERROR);
				return false;
			}
		}
		
		$rQuestionCount = $questionCount;
		
		return true;
	}
	
	function _composeQuestions($quizId, $randomQuestion, $qCategoryList, $defaultQuestionTime)
	{
		$error = 'ARI: Couldnt compose questions.';
		$questions = array();
		if (!empty($qCategoryList))
		{
			foreach ($qCategoryList as $qCategory)
			{
				$curQuestionTime = !empty($qCategory->QuestionTime) ? $qCategory->QuestionTime : $defaultQuestionTime;
				$questionCount = $qCategory->QuestionCount;
				$categoryId = $qCategory->QuestionCategoryId;
				$catQuestions = $randomQuestion 
					? $this->getRandomQuestions($quizId, $questionCount, $categoryId)
					: $this->getOrderedQuestions($quizId, $questionCount, $categoryId);
				if ($this->_isError(true, false))
				{
					trigger_error($error, E_USER_ERROR);
					return null;
				}
					
				$count = is_array($catQuestions) ? count($catQuestions) : 0;
				
				if ($count > 0)
				{
					if (!empty($curQuestionTime))
					{
						for ($i = 0; $i < $count; $i++)
						{
							$question =& $catQuestions[$i];
							if (empty($question->QuestionTime))
								$question->QuestionTime = $curQuestionTime;
						}
					}
					
					$questions = array_merge($questions, $catQuestions);
				}
			}

			$questions = $randomQuestion
				? $this->_normalizeRandomQuestions($questions)
				: $this->_normalizeOrderedQuestions($questions);
		}
		
		return $questions;
	}
	
	function _normalizeOrderedQuestions($questions)
	{
		$newQuestions = array();
		if (!empty($questions))
		{
			foreach ($questions as $question)
			{
				$newQuestions[$question->QuestionIndex] = $question;
			}
			
			ksort($newQuestions);
			$newQuestions = array_values($newQuestions); 
		}
		
		return $newQuestions;
	}
	
	function _normalizeRandomQuestions($questions)
	{
		if (!empty($questions))
		{
			// init rand mechanism for php < 4.2.0 version
			srand((float) microtime() * 10000000);
			shuffle($questions);
		}
		
		return $questions;
	}
	
	function getOrderedQuestions($quizId, $questionCount = null, $qCategoryId = 0)
	{
		$results = $this->_getQuestionForUserQuiz($quizId, ' QuestionIndex', $questionCount, $qCategoryId);
		if ($this->_isError(true, false))
		{
			trigger_error('ARI: Couldnt get ordered questions.', E_USER_ERROR);
			return null;
		}
		
		return $results;
	}
	
	function getRandomQuestions($quizId, $questionCount = null, $qCategoryId = 0)
	{
		$results = $this->_getQuestionForUserQuiz($quizId, ' RAND()', $questionCount, $qCategoryId);
		if ($this->_isError(true, false))
		{
			trigger_error('ARI: Couldnt get ordered questions.', E_USER_ERROR);
			return null;
		}
		
		return $results;
	}

	function _getQuestionForUserQuiz($quizId, $orderStr, $questionCount = null, $qCategoryId = 0)
	{
		$database =& JFactory::getDBO();
		
		$catPredicate = '';
		if ($qCategoryId !== null)
		{
			if (empty($qCategoryId)) $qCategoryId = 0;
			$catPredicate = sprintf(' AND SQ.QuestionCategoryId = %d', $qCategoryId);
		}
		
		$query = sprintf('SELECT SQ.QuestionId,SQ.QuestionVersionId,SQ.QuestionIndex,SQ.QuestionCategoryId,SQ2.QuestionId AS BankQuestionId, SQ2.QuestionVersionId AS BankVersionId' . 
			' FROM #__ariquizquestion SQ LEFT JOIN #__ariquizquestion SQ2' . 
        	' 	ON SQ.BankQuestionId = SQ2.QuestionId' .
			' WHERE SQ.Status = %d AND SQ.QuizId = %d %s' . 
			' ORDER BY %s' . 
			' %s', 
			AriConstantsManager::getVar('Status.Active', AriQuizQuestionControllerConstants::getClassName()),
			$quizId, 
			$catPredicate,
			$orderStr, 
			$this->_getLimit(!empty($questionCount) ? 0 : null, $questionCount));

		$database->setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get questions for user quiz.', E_USER_ERROR);
			return null;
		}

		return $rows;
	}
	
	function getStatisticsInfoByTicketId($ticketId, $userId = 0, $status = null, $quizId = null)
	{
		$database =& JFactory::getDBO();
		
		$userId = intval($userId);
		if ($status != null && !is_array($status)) $status = array($status);

		$query = sprintf('SELECT *' .
			' FROM #__ariquizstatisticsinfo' .
			' WHERE TicketId = %s AND (%d = 0 OR UserId = %d) AND (%s IS NULL OR Status IN (%s)) AND (IFNULL(%s, 0) = 0 OR QuizId = %s)' .
			' LIMIT 0,1', 
			$database->Quote($ticketId), 
			$userId, 
			$userId, 
			$status == null ? 'NULL' : '""',
			$status == null ? 'NULL' : join(',', $this->_quoteValues($status)),
			$quizId == null ? 'NULL' : $quizId,
			$quizId == null ? 'NULL' : $quizId);
		$database->setQuery($query);
		$result = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt statistics info entity by ticket ID.', E_USER_ERROR);
			return null;
		}
		
		if (!is_array($result) || count($result) < 1) 
			return null;
			
		$statistics = AriEntityFactory::createInstance('AriQuizStatisticsInfoEntity', AriGlobalPrefs::getEntityGroup());
		if (!$statistics->bind($result[0]))
			return null;

		return $statistics;
	}
	
	function getStatisticsInfoIdByTicketId($ticketId, $userId = 0, $status = null, $quizId = null)
	{
		$database =& JFactory::getDBO();
		
		$userId = intval($userId);
		if ($status != null && !is_array($status)) $status = array($status);

		$query = sprintf('SELECT StatisticsInfoId' .
			' FROM #__ariquizstatisticsinfo' .
			' WHERE TicketId = %s AND (%d = 0 OR UserId = %d) AND (%s IS NULL OR Status IN (%s)) AND (IFNULL(%s, 0) = 0 OR QuizId = %s)' .
			' LIMIT 0,1', 
			$database->Quote($ticketId), 
			$userId, 
			$userId, 
			$status == null ? 'NULL' : '""',
			$status == null ? 'NULL' : join(',', $this->_quoteValues($status)),
			$quizId == null ? 'NULL' : $quizId,
			$quizId == null ? 'NULL' : $quizId);
		$database->setQuery($query);
		$result = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt statistics info entity by ticket ID.', E_USER_ERROR);
			return null;
		}
		
		return $result;
	}
	
	function createTicketId($quizId, $userId = 0, $extraData = null)
	{
		$database =& JFactory::getDBO();
		
		$quizId = intval($quizId);
		$userId = intval($userId);
		$ticketId = $this->_generateTicketId();
		$createdDate = ArisDate::getDbUTC();
		
				$statisticsInfo = AriEntityFactory::createInstance('AriQuizStatisticsInfoEntity', AriGlobalPrefs::getEntityGroup());
		$extraDataXml = $statisticsInfo->getExtraDataXml($extraData);
		$query = sprintf('INSERT INTO #__ariquizstatisticsinfo (QuizId,UserId,Status,TicketId,CreatedDate,ExtraData)' . 
			' VALUES(%d,%d,"Prepare",%s,%s,%s)', 
			$quizId, 
			$userId,
			$database->Quote($ticketId),
			$database->Quote($createdDate),
			empty($extraDataXml) ? 'NULL' : $database->Quote($extraDataXml));
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt create ticket ID.', E_USER_ERROR);
			return '';
		}
		
		return $ticketId;
	}
	
	function _generateTicketId()
	{
		mt_srand((float)microtime() * 1000000);
		$key = mt_rand();
		
		return md5(uniqid($key, true));
	}	

	function getNotFinishedTicketId($quizId, $userId)
	{
		$database =& JFactory::getDBO();
		
		$ticketId = '';
		if (!empty($userId))
		{
			$query = sprintf('SELECT QSI.TicketId' .
				' FROM #__ariquizstatisticsinfo QSI' .
				' WHERE (QSI.Status = "Process" OR QSI.Status = "Prepare") AND UserId = %d AND QuizId = %d ORDER BY StatisticsInfoId DESC LIMIT 0,1',
				$userId,
				$quizId);
			$database->setQuery($query);
			$ticketId = $database->loadResult();
			if ($database->getErrorNum())
			{
				trigger_error('ARI: Couldnt get not finished ticket id.', E_USER_ERROR);
				return '';
			}
		}
		
		return $ticketId;
	}
	
	function canTakeQuizByTicketId($ticketId, $userId, $group, $checkPaused = true)
	{
		$database =& JFactory::getDBO();
		
		$error = 'ARI: Cant check quiz availability by ticket id.';
		
		$query = sprintf('SELECT QuizId FROM #__ariquizstatisticsinfo WHERE TicketId = %s AND (UserId = 0 OR UserId IS NULL OR UserId = %d) LIMIT 0,1',
			$database->Quote($ticketId),
			intval($userId));
		$database->setQuery($query);
		$quizId = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		$canTake = $this->canTakeQuiz($quizId, $userId, $group, $checkPaused);
		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		return $canTake;
	}
	
	function canTakeQuiz($quizId, $userId, $group, $checkPaused = true)
	{
		$code = $this->canTakeQuiz2($quizId, $userId, $group, $checkPaused);
		if ($this->_isError(true, false))
		{
			return false;
		}
		
		$errorCodeList = AriConstantsManager::getVar('ErrorCode.TakeQuiz', AriUserQuizControllerConstants::getClassName());
		return ($code == $errorCodeList['None']);
	}
	
	function canTakeQuiz2($quiz, $userId, $group, $checkPaused = true)
	{
		$database =& JFactory::getDBO();

		$errorCodeList = AriConstantsManager::getVar('ErrorCode.TakeQuiz', AriUserQuizControllerConstants::getClassName()); 
		$error = 'ARI: Cant check quiz availability.';
		
		$quizController = new AriQuizController();
		if (!is_object($quiz)) $quiz = $quizController->getQuiz($quiz);
		$quizId = $quiz->QuizId;

		if ($this->_isError(true, false))
		{
			trigger_error($error, E_USER_ERROR);
			return $errorCodeList['UnknownError'];
		}
		
		if (!empty($quiz) && !empty($quiz->QuizId))
		{
			if ($quiz->Status == AriConstantsManager::getVar('Status.Active', AriQuizControllerConstants::getClassName()))
			{
				// check quiz count and lag time
				if (!empty($userId) && (!empty($quiz->LagTime) || !empty($quiz->AttemptCount)))
				{
					$query = sprintf('SELECT IFNULL(COUNT(QuizId), 0) AS QuizCount, IFNULL((UNIX_TIMESTAMP(UTC_TIMESTAMP()) - UNIX_TIMESTAMP(MAX(EndDate))), 0) AS LagTime' .
						' FROM #__ariquizstatisticsinfo' .
						' WHERE Status = "Finished" AND UserId = %d AND QuizId = %d' .
						' GROUP BY QuizId' .
						' LIMIT 0,1',
						$userId,
						$quizId);
					$database->setQuery($query);
					$result = $database->loadAssocList();
					if ($database->getErrorNum())
					{
						trigger_error($error, E_USER_ERROR);
						return $errorCodeList['UnknownError'];
					}
					
					$result = count($result) > 0
						? $result[0]
						: array('QuizCount' => 0, 'LagTime' => 0);

					if ($quiz->AttemptCount > 0 && $result['QuizCount'] >= $quiz->AttemptCount)
					{
						return $errorCodeList['AttemptCount'];
					}
					else if ($quiz->LagTime > 0 && $result['QuizCount'] > 0 && $result['LagTime'] < $quiz->LagTime)
					{
						return $errorCodeList['LagTime'];
					}
				}

				$quiz->StartDate = AriJoomlaBridge::getDate($quiz->StartDate);
				$quiz->EndDate = AriJoomlaBridge::getDate($quiz->EndDate);
				if ($quiz->StartDate || $quiz->EndDate)
				{
					$currentTs = strtotime(gmdate("M d Y H:i:s", time())) + 60 * 60;
					//$tz = ArisDate::getTimeZone() * 60 * 60;
					if ($quiz->StartDate)
					{
						$startDate = strtotime($quiz->StartDate . ' UTC')/* + $tz*/;
						if ($startDate > $currentTs)
							return $errorCodeList['DateAccess'];
					}
					
					if ($quiz->EndDate)
					{
						$endDate = strtotime($quiz->EndDate . ' UTC')/* + $tz*/;

						if ($endDate < $currentTs)
							return $errorCodeList['DateAccess'];
					}
				}
				
				$accessList = $quiz->AccessList;
				if (!empty($accessList))
				{
					$acl =& JFactory::getACL();
					if (!J1_6)
					{
						$uah = new AriUserAccessHelper($acl);
						$regGroupId = AriConstantsManager::getVar('Id.Registered', AriUserAccessHelperConstants::getClassName());
						$forRegistered = false;
						$errorCode = $errorCodeList['NotHavePermissions'];
						foreach ($accessList as $accessItem)
						{
							if ($accessItem->value == $regGroupId)
							{
								$forRegistered = true;
							}
						
							if ((!empty($userId) && $accessItem->value == $regGroupId) ||
								$uah->isGroupOrChildOfGroup($group, $accessItem->value))
							{
								$errorCode = $errorCodeList['None'];
								break;
							}
						}
						
						if ($forRegistered && empty($userId)) $errorCode = $errorCodeList['NotRegistered'];
						if ($errorCode != $errorCodeList['None']) return $errorCode;
					}
					else
					{
						$user =& JFactory::getUser();
						$userId = $user->get('id');
						$groups = $acl->getGroupsByUser($userId);
						$errorCode = $errorCodeList['NotHavePermissions'];
						foreach ($accessList as $accessItem)
						{
							if (in_array($accessItem->value, $groups) ||
								($accessItem->value == 2 && $userId > 0))
							{
								$errorCode = $errorCodeList['None'];
								break;
							}
						}

						if ($errorCode != $errorCodeList['None']) return $errorCode;
					}
				}
				
				if ($checkPaused && !empty($userId))
				{
					if ($this->hasPausedQuiz($quiz->QuizId, $userId))
					{
						return $errorCodeList['HasPausedQuiz'];
					}
				}
				
				return $errorCodeList['None'];
			}
		}
		
		return $errorCodeList['UnknownError'];
	}
	
	function getUserQuizList($categoryId = null)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT QC.CategoryId,QC.CategoryName,Q.QuizName,Q.QuizId' .
			' FROM #__ariquiz Q LEFT JOIN #__ariquizquizcategory QQC' .
			' 	ON Q.QuizId = QQC.QuizId' .
			' LEFT JOIN #__ariquizcategory QC' .
			' 	ON QC.CategoryId = QQC.CategoryId' .
			' WHERE Q.Status = %d %s' .
			' ORDER BY QC.CategoryName ASC, Q.QuizOrder ASC',
			AriConstantsManager::getVar('Status.Active', AriQuizControllerConstants::getClassName()),
			!is_null($categoryId) ? ' AND IFNULL(QC.CategoryId, 0) = ' . @intval($categoryId, 10) : '');
		$database->setQuery($query);

		$rows = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get quiz for user.', E_USER_ERROR);
			return null;
		}
		
		return $rows;
	}
	
	function getQuizQuestions($sid)
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('SELECT IF(QV2.QuestionId,QV2.Question,QV.Question) AS Question,IF(QV2.QuestionId,QV2.Note,QV.Note) AS QuestionNote' .
			' FROM #__ariquizstatisticsinfo SI INNER JOIN #__ariquizstatistics S' .
			' 	ON SI.StatisticsInfoId = S.StatisticsInfoId' . 
			' INNER JOIN #__ariquizquestionversion QV' .
			'	ON S.QuestionVersionId = QV.QuestionVersionId' .
			' LEFT JOIN #__ariquizquestionversion QV2' . 
			' 	ON S.BankVersionId = QV2.QuestionVersionId' .
			' WHERE SI.StatisticsInfoId = %d',
			$sid);
		$database->setQuery($query);
		$questions = $database->loadObjectList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get quiz questions.', E_USER_ERROR);
			return null;
		}
		
		return $questions;
	}
	/** Modifications by Mike, improved by Ki */
	// Added by Mike
	function userPassed($userId, $quizId)
	{
		$database =& JFactory::getDBO();
		$query = sprintf("SELECT Passed FROM #__ariquizstatisticsinfo WHERE QuizId = '". $quizId. "' AND UserId = '". $userId. "' AND Passed = '1' AND Status='Finished'");
		$database->setQuery($query);
		$database->query();
		if($database->getNumRows() == 0)
			return TRUE;
		else
			return FALSE;
	}
	// Added by Mike
	function getPassedQuizes($userId)
	{
		$database =& JFactory::getDBO();
		$query = sprintf("SELECT * FROM #__ariquizstatisticsinfo WHERE UserId = '". $userId. "' ORDER BY StatisticsInfoId ASC");
		$database->setQuery($query);
		$database->query();
		$rows = $database->loadObjectList();
		if ($database->getErrorNum()) 
		{
			trigger_error('ARI: Could NOT get passed quiz for user.', E_USER_ERROR);
			return null; 
		}
		foreach($rows as $quiz)
		{
			/*
			if(!isset($passed[$quiz->QuizId]))
			{
				$passed[$quiz->QuizId] = array("status" => $quiz->Status, "passed" => $quiz->Passed, "score" => $quiz->UserScore);
			}
			else
			{
				if($quiz->status == "Process")
				{
					$passed[$quiz->QuizId] = array("status" => $quiz->Status, "passed" => $quiz->Passed, "score" => $quiz->UserScore);
				}
				elseif($quiz->Passed == 0)
				{
					$passed[$quiz->QuizId] = array("status" => $quiz->Status, "passed" => $quiz->Passed, "score" => $quiz->UserScore);
				}
				elseif($quiz->UserScore >= $passed[$quiz->QuizId]["score"])
				{
					$passed[$quiz->QuizId] = array("status" => $quiz->Status, "passed" => $quiz->Passed, "score" => $quiz->UserScore);
				}
			}
			*/
			$passed[$quiz->QuizId] = array("status" => $quiz->Status, "passed" => $quiz->Passed, "score" => $quiz->UserScore, "TicketId" => $quiz->TicketId);
		}
		return $passed;
	}
	// Added By Ki
	function getNextQuiz($userId, $categoryId) {
		
		$query = "SELECT quiz.Next_Quiz_id FROM #__ariquizstatisticsinfo as stat
						  LEFT JOIN #__ariquiz as quiz 
						  ON stat.QuizId = quiz.QuizId 
						  LEFT JOIN #__ariquizquizcategory as qcat
						  ON stat.QuizId = qcat.QuizId
						  WHERE stat.UserId = {$userId} AND qcat.CategoryId = {$categoryId}
						  ORDER BY quiz.QuizOrder DESC LIMIT 1";
						  
		$database =& JFactory::getDBO();
		$database->setQuery($query);
		$next = $database->loadResult();
		if ( empty($next) )
			$next = 0;
		return $next;
	}
	
	/*
	function getNextQuiz($userId, $categoryId)
	{
		$database =& JFactory::getDBO();

		// First get quiz order
		$query = sprintf("SELECT QuizId FROM #__ariquizquizcategory WHERE CategoryId = '". $categoryId. "'");
		$database->setQuery($query);
		$database->query();
		$rows = $database->loadAssocList("QuizId");
		if ($database->getErrorNum()) 
		{
			trigger_error('ARI: Couldn\'t get next quiz for user.', E_USER_ERROR);
			return null; 
		}
		foreach($rows as $key => $quizId)
		{
			$rows[$key] = $key;
		}
		foreach($rows as $key => $quizId)
		{
			$count = 0;
			while($quizId)
			{
				$count++;
				$query = sprintf("SELECT Next_quiz_id FROM #__ariquiz WHERE QuizId = '". $quizId. "'");
				$database->setQuery($query);
				$quizId = $database->loadResult();
				$var[$key][] = $quizId;
				//If this loop continues for 5000 times then most likely it's an infinite loop.
				if($count > 5000) $quizId = FALSE;
			}
		}
		foreach($var as $key => $list)
		{
			if(count($list) > $longest){
				$longest = count($list);
				$quizId = $key;
			}
		}
		array_pop($var[$quizId]);
		array_unshift($var[$quizId], $quizId);
		$orderedList = $var[$quizId];

		// Get user's result
		$query = sprintf("SELECT * FROM #__ariquizstatisticsinfo WHERE UserId = '". $userId. "' AND passed = '1'");
		$database->setQuery($query);
		$database->query();

		// If the table is not completely empty
		if(count($rows) != 0)
		{
			$count = 0;
			foreach($database->loadObjectList() as $stat)
			{
				if(in_array($stat->QuizId, $orderedList))
				{
					$keys[] = array_search($stat->QuizId, $orderedList);
				}
				else
				{
					$count++;
				}
			}
			if($count == count($database->loadObjectList())){
				return $orderedList[0];
			}
			$keys = array_unique($keys);
			rsort($keys);
			$keys = array_flip($keys);

			foreach($keys as $key => $trash)
			{
				$keys[$key] = $orderedList[$key];
			}
			foreach($keys as $key => $value)
			{
				if(in_array($orderedList[$key-1],$keys))
					return $orderedList[$key+1];
			}
		}// No result from ariquizstatisticsinfo
		else {
			return $orderedList[0];
		}
	}
	// added by Mike

	function getQuizOrder($categoryId)
	{
		$database =& JFactory::getDBO();
		$query = sprintf("SELECT QuizId FROM #__ariquizquizcategory WHERE CategoryId = '". $categoryId. "'");
		$database->setQuery($query);
		$database->query();
		$rows = $database->loadAssocList("QuizId");
		if ($database->getErrorNum()) 
		{
			trigger_error('ARI: Couldn\'t get next quiz for user.', E_USER_ERROR);
			return null; 
		}
		foreach($rows as $key => $quizId)
		{
			$rows[$key] = $key;
		}
		foreach($rows as $key => $quizId)
		{
			$count = 0;
			while($quizId)
			{
				$count++;
				$query = sprintf("SELECT Next_quiz_id FROM #__ariquiz WHERE QuizId = '". $quizId. "'");
				$database->setQuery($query);
				$quizId = $database->loadResult();
				$var[$key][] = $quizId;
				//If this loop continues for 5000 times then most likely it's an infinite loop.
				if($count > 5000) $quizId = FALSE;
			}
		}

		foreach($var as $key => $list)
		{
			if(count($list) > $longest){
				$longest = count($list);
				$quizId = $key;
			}
		}

		array_pop($var[$quizId]);
		array_unshift($var[$quizId], $quizId);
		return $var[$quizId];
	}

	// added by Mike
	function sortQuizList($quizList, $quizOrder)
	{
		foreach($quizOrder as $quizId)
		{
			foreach($quizList as $quiz)
			{
				if($quiz->QuizId == $quizId)
				{
					$newQuizList[] = $quiz;
				}
			}
		}
		foreach($quizList as $quiz)
		{
			if(!in_array($quiz, $newQuizList)) array_push($newQuizList, $quiz);
		}
		return $newQuizList;
	}
	
	*/
}
?>