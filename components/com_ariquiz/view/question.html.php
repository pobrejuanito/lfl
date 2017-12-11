<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
$option = 'com_ariquiz';
$mosConfig_live_site = JURI::root(true);
$ticketId = $processPage->getVar('ticketId');
$Itemid = $processPage->getVar('Itemid');
$quizInfo = $processPage->getVar('quizInfo');
$completedCount = $processPage->getVar('completedCount');
$questionCount = $processPage->getVar('questionCount');
$cssFile = $processPage->getVar('cssFile');
$totalTime = $processPage->getVar('totalTime');
$version = $processPage->getVar('version');
$quizId = $quizInfo->QuizId;
$jsClientPath = $mosConfig_live_site . '/components/' . $option . '/js/';
$jsAdminPath = $mosConfig_live_site . '/components/' . $option . '/js/';
$jsYuiPath = $jsAdminPath . 'yui/';
$imgPath = $mosConfig_live_site . '/components/' . $option . '/images/';
$messagesLink = AriJoomlaBridge::getLink('index.php?option=' . $option . '&task=script.messages&t=' . time() . '&quizId=' . $quizId);
$hotspotLink = AriJoomlaBridge::getLink('index.php?option=' . $option . '&task=script.showHotspot&ticketId=' . $ticketId . '&rupd=__time__');
$quizProps = $processPage->getVar('quizProps');
$quizStorage = $processPage->getVar('quizStorage');
$userId = $processPage->getVar('userId');
$isGuest = (empty($userId) || $userId < 1);
$isCanStop = (!$isGuest && $quizStorage->get('CanStop'));
$tmpl = AriRequest::getParam('tmpl');
$inactiveTimeout = $isCanStop
	? 1000 * AriUtils::parseValueBySample(AriUtils::getParam($quizProps, 'InactiveTimeout', 0), 1)
	: 0;
?>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/json/json-min.js"></script>
<script charset="utf-8" src="<?php echo $jsAdminPath; ?>ari.all.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo $jsAdminPath; ?>ari.quiz.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo $jsAdminPath; ?>widgets/ari.watermarktext.widget.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo $jsClientPath; ?>questions.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script type="text/javascript">
	YAHOO.ARISoft.page.option = '<?php echo $option; ?>';
	YAHOO.ARISoft.page.baseUrl = '<?php echo $mosConfig_live_site . '/'; ?>';
	YAHOO.ARISoft.page.adminBaseUrl = '<?php echo $mosConfig_live_site . '/administrator/'; ?>';
</script>
<script charset="utf-8" src="<?php echo $messagesLink; ?>" type="text/javascript"></script>

<script type="text/javascript" language="javascript">
YAHOO.util.Event.onDOMReady(function()
{
	ariQuizQueManager = new aris.ariQuiz.questionManager(
		{
			containerId: 'ariQueContainer',
			mainContainerId: 'ariQueMainAnsContainer',
			explanationId: 'ariQuizExplanation',
			correctAnswerId: 'ariQuizCorrectAnswer', 
			errorContainerId: 'ariQuizError', 
			formId: 'formQue_<?php echo $quizId; ?>',
			queContainerId: 'ariQueMainContainer',
			questionInfoId: 'tdQuestionInfo',
			timeContainerId: 'ariQuizTimeCnt',
			questionCount: <?php echo AriJSONHelper::encode($questionCount); ?>,
			completedCount: <?php echo AriJSONHelper::encode($completedCount); ?>,
			quizTime: <?php echo AriJSONHelper::encode($totalTime); ?>,
			extraParams: <?php echo AriJSONHelper::encode($quizProps); ?>
		},
		{
			baseUrl: '<?php echo $mosConfig_live_site; ?>/index.php',
			ticketId: '<?php echo $ticketId; ?>',
			parsePluginTag: <?php echo $quizStorage->get('ParsePluginTag') ? 'true' : 'false'; ?>,
			skipQuestionTask: '<?php echo $processPage->executionTask . '$ajax|skipQuestion'; ?>',
			getQuestionTask: '<?php echo $processPage->executionTask . '$ajax|getQuestion'; ?>',
			saveQuestionTask: '<?php echo $processPage->executionTask . '$ajax|saveQuestion'; ?>',
			getCorrectAnswerTask: '<?php echo $processPage->executionTask . '$ajax|getCorrectAnswer'; ?>',
			getExplanationTask: '<?php echo $processPage->executionTask . '$ajax|getExplanation'; ?>',
			stopQuizTask: '<?php echo $processPage->executionTask . '$ajax|stopQuiz'; ?>',
			resumeQuizTask: '<?php echo $processPage->executionTask . '$ajax|resumeQuiz'; ?>'
		},
		{
			'HotSpotQuestion': { imgLink: '<?php echo $hotspotLink; ?>', baseUrl: '<?php echo $mosConfig_live_site; ?>' }
		});
	
	ariQuizQueManager.showCurrentQuestion();
});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $cssFile; ?>" />
<?php $parts = getLessonNumber($quizInfo->QuizName); ?>
<div style="background: url('/images/bible-study/quiz_header.png') 0px 0px no-repeat; width:671px; height:161px; margin: 10px 0px 30px 0px;">
<div style="position:relative; top:161px;"><img src="/images/bible-study/lessons/divider.png"></div>
</div>
<div></div>
<div style="background: url('/images/bible-study/quiz_logo.png') 0px 0px no-repeat; width: 400px; height:25px; font-size: 14px; padding: 5px 30px 0px 65px;">
	<div style="font-weight: bold;"><?php echo $parts[0] . ' '. $parts[1]; ?></div>
</div>
<hr style="color: #9a9a9a; width: 671px" />
<form action="index.php" method="post" name="formQue_<?php echo $quizId; ?>" id="formQue_<?php echo $quizId; ?>" style="margin: 5px 5px 5px 5px;">
<?php
if (!empty($quizProps['HistoryText'])) :
?>
<div class="ariQuizHistory"><?php echo $quizProps['HistoryText']; ?></div>
<?php
endif;
?>
<div>
</div>
<div style="position: relative; width: 100%;" id="ariQueMainAnsContainer" class="ariQuizLoading">
	<div class="ariQuizLoadingMessage">
		<img src="<?php echo $imgPath; ?>loading.gif" width="16" height="16" border="0" align="absmiddle" />
		&nbsp;&nbsp;&nbsp;<?php AriWebHelper::displayResValue('Ajax.Loading'); ?>
	</div>
	<div style="position: relative; width: 100%;" class="ariQuizMainContainer">
		<div class="ariQuizError" id="ariQuizError">&nbsp;</div>
		<table class="ariQuizHeaderTable ariQuizHiddenOnLoading">
			<tr>
				<td>&nbsp;</td>
				<td rowspan="2" class="ariQuizTimeCnt" id="ariQuizTimeCnt">&nbsp;</td>
			</tr>
			<tr>
				<td>
				<table class="ariQuizHeaderInfo">
					<tr valign="middle">
						<td style="white-space: nowrap; width: 1%;">
							<?php AriWebHelper::displayResValue('Label.Completed'); ?>&nbsp;&nbsp;
						</td>
						<td>
							<div id="ariQuizProgressWrap" class="ariQuizProgressWrap" title="<?php echo $completedCount . ' / ' . $quizInfo->QuestionCount; ?>">
								<div id="ariQuizProgress" class="ariQuizProgress" style="width: 0%;"><img src="<?php echo $mosConfig_live_site . '/components/' . $option . '/images/x.gif' ?>" width="1" height="7" alt="" /></div>
							</div>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		<div style="background: url('/images/dotted-line.gif') 0px 0px no-repeat; position: relative; left: -3px; width:671px; height: 2px; margin: 20px 0px 0px 0px;"></div>
		<table class="ariQuizQuestionTable">
	
			<tr valign="top" class="ariQuizHiddenOnLoading">

				<td class="ariQuizQuestionTitleCnt ariQuizQuestionLeft"><!--<div class="ariQuizQuestionTitle"><?php //AriWebHelper::displayResValue('Label.Question'); ?></div>--></td>
				<td class="ariQuizQuestionRight" id="ariQueMainContainer"></td>
			</tr>
		
			<tbody class="ariQuizAnswerArea">
			<tr>
				<td colspan="2">
					<div class="ariQuizHiddenOnLoading">
						<div id="ariQueContainer">
						</div>
					</div>		
				</td>
			</tr>
			<tr>
				<td rowspan="2">&nbsp;</td>
				<!-- Question Count -->
				<td id="tdQuestionInfo" class="ariQuizHiddenOnLoading">&nbsp;</td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="button" disabledAfterSubmit="true" value="<?php AriWebHelper::displayResValue('Label.Save'); ?>" disabledAfterSubmit="true" onclick="if (ariQuizQueManager.validate()) ariQuizQueManager.saveQuestion(); return false;" />
					<?php
						if ($quizStorage->get('CanSkip')):
					?>	
					<input type="submit" class="button disabled" disabledAfterSubmit="true" value="<?php AriWebHelper::displayResValue('Label.Skip'); ?>" disabledAfterSubmit="true" onclick="ariQuizQueManager.skipQuestion(); return false;" />
					<?php
						endif;
					?>
					<?php
						if ($quizStorage->get('UseCalculator')):
					?>
					<input type="button" class="button" value="<?php AriWebHelper::displayResValue('Label.Calculator'); ?>" id="aCalc_<?php echo $quizId; ?>" />
					<script src="<?php echo $mosConfig_live_site;?>/components/<?php echo $option; ?>/js/ari.calculator.js" type="text/javascript"></script>
					<script type="text/javascript" language="javascript">
						YAHOO.util.Get.css('<?php echo $mosConfig_live_site;?>/components/<?php echo $option; ?>/css/calculator.css');
						new YAHOO.ARISoft.widgets.calculator.calc('queCalc', 'aCalc_<?php echo $quizId; ?>');
					</script>
					<?php
						endif;
					?>
					<?php
						if ($quizStorage->get('ShowCorrectAnswer')):
					?>
						<input type="submit" class="button disabled" disabledAfterSubmit="true" value="<?php AriWebHelper::displayResValue('Label.ShowCorrectAnswer'); ?>" disabledAfterSubmit="true" onclick="ariQuizQueManager.showCorrectAnswer(); return false;" />
					<?php
						endif;
					?>
					<?php
						if ($isCanStop):
					?>	
						<input type="button" class="button disabled" disabledAfterSubmit="true" value="<?php AriWebHelper::displayResValue('Label.QuizSaveExit'); ?>" disabledAfterSubmit="true" onclick="return ariQuizQueManager.raiseServerEvent('stopExit');" />
					<?php
						endif;
					?>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	
	<?php
		if ($quizStorage->get('ShowCorrectAnswer')):
	?>
	<div class="ariQuizCorrectAnswerContainer ariQuizHiddenOnLoading" style="display: none;">
		<div id="ariQuizCorrectAnswer" class="ariQuizCorrectAnswerArea">
		</div>
		<div><input type="button" class="button" value="<?php AriWebHelper::displayResValue('Label.Continue'); ?>" onclick="ariQuizQueManager.hideCorrectAnswer(); return false;" /></div>
	</div>
	<?php
		endif;
	?>
	<?php
		if ($quizStorage->get('ShowExplanation')):
	?>
	<div class="ariQuizExplanationContainer ariQuizHiddenOnLoading" style="display: none;">
		<div id="ariQuizExplanation" class="ariQuizExplanationArea">
		</div>
		<div><input type="button" class="button" value="<?php AriWebHelper::displayResValue('Label.Continue'); ?>" onclick="ariQuizQueManager.hideExplanationQuestion(); return false;" /></div>
	</div>
	<?php
		endif;
	?>
</div>
<?php
	if ($tmpl):
?>
	<input type="hidden" name="tmpl" value="<?php echo $tmpl; ?>" />
<?php
	endif;
?>
<input type="hidden" name="task" id="task" value="question" />
<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
<input type="hidden" name="ticketId" id="ticketId" value="<?php echo $ticketId; ?>" />
<input type="hidden" name="timeOver" id="timeOver" value="false" /> 
<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" /> 
</form>
<?php

function getLessonNumber($name) {

	$title = '';
	$pattern = '#\[(.*)\]#';
	$lesson_title = preg_replace($pattern, $replacement, $name);
	preg_match($pattern, $name, $matches);
	if ( is_numeric($matches[1])) {
		$lesson_number = "제". $matches[1] . "과";
	}
	
	if ( $matches[1] === 'i' ) {
		$info = true;
	} else {
		$info = false;
	}
	return array($lesson_number, $lesson_title, $info);
}
?>