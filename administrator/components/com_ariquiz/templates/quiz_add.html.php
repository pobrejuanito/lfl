<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
	
	$option = $processPage->getVar('option');
	$jsPath = JURI::root(true) . '/components/' . $option . '/js/';
	$jsYuiPath = $jsPath . 'yui/';
	$quizId = $processPage->getVar('quizId');
	$quiz = $processPage->getVar('quiz');
	$props = $processPage->getVar('props');
	$lbScale = $processPage->getControl('lbScale');
	$scaleId = $lbScale->getSelectedValue();
	$startDate = AriJoomlaBridge::getDate($quiz->StartDate);
	$endDate = AriJoomlaBridge::getDate($quiz->EndDate);

	$tz = ArisDate::getTimeZone() * 60 * 60;
	$startDateInfo = $startDate ? getdate(strtotime($startDate . ' UTC') + $tz) : null;
	$endDateInfo = $endDate ? getdate(strtotime($endDate . ' UTC') + $tz) : null;
?>
<?php
	JHTML::_('behavior.mootools');
?>

<script type="text/javascript" src="<?php echo $jsPath; ?>date.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath;?>build/container/assets/container.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $jsYuiPath; ?>build/calendar/assets/skins/sam/calendar.css" />

<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/container/container-min.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo $jsYuiPath; ?>build/calendar/calendar-min.js"></script>
<script type="text/javascript" src="<?php echo $jsPath; ?>widgets/ari.calendar.js"></script>

<?php AriJoomlaBridge::loadOverlib(); ?>
<table class="adminform" style="width: 100%;">
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.MainSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbQuizSettings">
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Name'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxQuizName', array('class' => 'text_area', 'size' => '70')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Category'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbCategories', array('class' => 'text_area')); ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.Access'); ?> :</td>
			<td align="left"><?php if (J1_6) { echo JHtml::_('access.usergroup', 'AccessGroup[]', is_array($quiz->AccessList) && count($quiz->AccessList) > 0 ? $quiz->AccessList[0]->value : 0, ' size="10"', false); } else { $processPage->renderControl('lbAccess', array('class' => 'text_area', 'size' => '5')); }; ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.AccessDate'); ?> :</td>
			<td align="left">
				<div style="position: relative;" id="cntDateAccess">
					<div class="leftPos">
						<fieldset style="width: 320px;" class="ari-date-cnt<?php if (empty($startDate)): ?> disabled<?php endif; ?>">
							<legend><?php AriWebHelper::displayResValue('Label.StartDate'); ?> <input type="checkbox" class="ari-date-switch" name="chkStartDate" id="chkStartDate"<?php if ($startDate): ?> checked="checked"<?php endif; ?> value="1" /></legend>
							<div style="position: relative;">
								<div class="leftPos" style="width: 120px;">
									<div>
										<input type="text" id="tbxStartDate" name="tbxStartDate" class="text_area ari-date-ctrl ari-tbx-cal" size="10" readonly="readonly"<?php if (empty($startDate)): ?> disabled="disabled"<?php endif; ?> />
										<input type="hidden" id="hidStartDate" name="hidStartDate" class="ari-date-ctrl" />
									</div>
									<div id="calStartDateContainer" style="visibility: hidden;" class="ari-calendar">
										<div class="hd"><?php AriWebHelper::displayResValue('Label.StartDate'); ?> :</div>
									</div>
								</div>
								<div>
									<b><?php AriWebHelper::displayResValue('Label.Time'); ?></b>
									<?php echo JHTML::_('select.integerlist', 0, 23, 1, 'ddlStartHour', ' class="ari-date-ctrl"' . (empty($startDate) ? ' disabled="disabled"' : ''), $startDateInfo['hours']); ?>
									:
									<?php echo JHTML::_('select.integerlist', 0, 59, 1, 'ddlStartMinute', ' class="ari-date-ctrl"' . (empty($startDate) ? ' disabled="disabled"' : ''), $startDateInfo['minutes']); ?>
								</div>
							</div>
						</fieldset>
					</div>
					<div>
						<fieldset style="width: 320px;" class="ari-date-cnt<?php if (empty($endDate)): ?> disabled<?php endif; ?>">
							<legend><?php AriWebHelper::displayResValue('Label.EndDate'); ?> <input type="checkbox" class="ari-date-switch" name="chkEndDate" id="chkEndDate"<?php if ($endDate): ?> checked="checked"<?php endif; ?> value="1" /></legend>
							<div style="position: relative;">
								<div class="leftPos" style="width: 120px;">
									<div>
										<input type="text" id="tbxEndDate" name="tbxEndDate" class="text_area ari-date-ctrl ari-tbx-cal" size="10" readonly="readonly"<?php if (empty($endDate)): ?> disabled="disabled"<?php endif; ?> />
										<input type="hidden" id="hidEndDate" name="hidEndDate" class="ari-date-ctrl" />
									</div>
									<div id="calEndDateContainer" style="visibility: hidden;" class="ari-calendar">
										<div class="hd"><?php AriWebHelper::displayResValue('Label.EndDate'); ?> :</div>
									</div>
								</div>
								<div>
									<b><?php AriWebHelper::displayResValue('Label.Time'); ?></b>
									<?php echo JHTML::_('select.integerlist', 0, 23, 1, 'ddlEndHour', ' class="ari-date-ctrl"' . (empty($endDate) ? ' disabled="disabled"' : ''), $endDateInfo['hours']); ?>
									:
									<?php echo JHTML::_('select.integerlist', 0, 59, 1, 'ddlEndMinute', ' class="ari-date-ctrl"' .  (empty($endDate) ? ' disabled="disabled"' : ''), $endDateInfo['minutes']); ?>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Active'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkStatus', array('value' => '1')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.TotalTime'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxTotalTime', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.PassedScore'); ?> <?php AriWebHelper::displayResValue('Label.Percent'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxPassedScore', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QuestionCount'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxQuestionCount', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QuestionTime'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxQuestionTime', array('class' => 'text_area')); ?></td>
		</tr>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.Description'); ?> :</td>
			<td align="left">
				<?php
					$processPage->renderControl('edDescription', array('width' => '100%;', 'height' => 250, 'cols' => 60, 'rows' => 20)); 
				?>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.TextTemplates'); ?>&nbsp;&nbsp;<?php $processPage->renderControl('lbScale', array('class' => 'text_area', 'onchange' => 'YAHOO.util.Dom.setStyle(\'tbQuizTemplate\', \'display\', this.value != \'0\' ? \'none\' : \'\')')); ?></th>
		</tr>
	</tbody>
	<tbody id="tbQuizTemplate"<?php echo $scaleId ? ' style="display: none;"' : ''; ?>>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.SucEmailTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbSucEmail', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.FailedEmailTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbFailEmail', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.SucPrintTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbSucPrint', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.FailedPrintTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbFailPrint', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.SucTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbSuc', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.FailedTemplate'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('lbFail', array('class' => 'text_area')); ?></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.AdditionalSettings'); ?></th>
		</tr>
	</tbody>
	<tbody id="tbExtraQuizSettings">
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue('Label.SendResultTo'); ?> :</td>
			<td>
				<table width="100%" cellpadding="1" cellspacing="1">
					<tr valign="top">
						<td style="width: 1%; white-space: nowrap;">
							<?php AriWebHelper::displayResValue('Label.Email'); ?> :
						</td>
						<td>
							<?php $processPage->renderControl('tbxAdminEmail', array('class' => 'text_area', 'size' => '100')); ?>
							<br />
							<?php if (J1_6) { echo JHtml::_('access.usergroup', 'AccessGroup[]', $quiz->MailGroupList ? explode(',', $quiz->MailGroupList) : null, ' multiple="multiple" size="15"', false); } else {$processPage->renderControl('lbMailGroup', array('class' => 'text_area', 'size' => '15')); }; ?>
						</td>
					</tr>
					<tr>
						<td style="width: 1%; white-space: nowrap;">
							<?php AriWebHelper::displayResValue('Label.Template'); ?> :
						</td>
						<td><?php $processPage->renderControl('lbAdminEmail', array('class' => 'text_area')); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Template'); ?> :</td>
			<td><?php $processPage->renderControl('lbCss', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QOT'); ?> :</td>
			<td><?php $processPage->renderControl('lbQueOrderType', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.AnonStatus'); ?> :</td>
			<td><?php $processPage->renderControl('lbAnonymous', array('class' => 'text_area')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.Anomymous'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Quiz.ShowFullStatistics'); ?> :</td>
			<td><?php $processPage->renderControl('lbFullStatisticsType', array('class' => 'text_area')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.FullStatistics'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.AutoSendToUser'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkAutoSend', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.AutoSendToUser'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.ParsePluginTag'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkParsePluginTag', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.ParsePluginTag'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.Skip'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkCanSkip', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.QuizCanSkip'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.QuizCanStop'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkCanStop', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.QuizCanStop'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.RandomQuestion'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkRandom', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.QuizRandomQuestion'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.UseCalculator'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkUseCalc', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.QuizCalculator'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.ShowCorrectAnswer'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkShowCorrectAnswer', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.ShowCorrectAnswer'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.ShowExplanation'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('chkShowExplanation', array('value' => '1')); ?>
				<?php echo AriJoomlaBridge::toolTip(AriWebHelper::translateResValue('Tooltip.ShowExplanation'), AriWebHelper::translateResValue('Label.Tooltip')); ?>
			</td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.LagTime'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxLagTime', array('class' => 'text_area')); ?></td>
		</tr>
		<tr>
			<td align="left"><?php AriWebHelper::displayResValue('Label.AttemptCount'); ?> :</td>
			<td align="left"><?php $processPage->renderControl('tbxAttemptCount', array('class' => 'text_area')); ?></td>
		</tr>
	</tbody>
	<?php
	if (!empty($props))
	{
	?>
	<tbody>
		<tr>
			<th colspan="2"><?php AriWebHelper::displayResValue('Label.AdditionalProperties'); ?></th>
		</tr>
	</tbody>
	<tbody>
	<?php
		foreach ($props as $propItem)
		{
	?>
		<tr valign="top">
			<td align="left"><?php AriWebHelper::displayResValue($propItem->ResourceKey); ?> :</td>
			<td align="left"><?php $processPage->renderControl('QuizProp[' . $propItem->PropertyName . ']', array('class' => 'text_area')); ?></td>
		</tr>
	<?php
		}
	?>
	</tbody>
	<?php
	}
	?>
</table>
<input type="hidden" name="quizId" value="<?php echo $quizId; ?>" />
<script type="text/javascript" language="javascript">
YAHOO.util.Event.onDOMReady(function() {
	var page = YAHOO.ARISoft.page,
		pageManager = page.pageManager,
		Dom = YAHOO.util.Dom,
		Event = YAHOO.util.Event;
	Dom.addClass(document.body, "yui-skin-sam");
	page.calStartDate = new YAHOO.ARISoft.widgets.Calendar(
		"calStartDate", 
		"calStartDateContainer", 
		{
			close:false,
			iframe:false,
			dateElement: "tbxStartDate",
			hiddenDateElement: "hidStartDate",
			pagedate: "<?php echo $startDate ? $startDateInfo['mon'] . '/' . $startDateInfo['year'] : ''; ?>",
			selected: "<?php echo $startDate ? $startDateInfo['mon'] . '/' . $startDateInfo['mday'] . '/' . $startDateInfo['year'] : ''; ?>"
		},
		{
			context: ["tbxStartDate", "tr", "tl"]
		});
	page.calEndDate = new YAHOO.ARISoft.widgets.Calendar(
		"calEndDate", 
		"calEndDateContainer", 
		{
			close:false,
			iframe:false,
			dateElement: "tbxEndDate",
			hiddenDateElement: "hidEndDate",
			pagedate: "<?php echo $endDate ? $endDateInfo['mon'] . '/' . $endDateInfo['year'] : ''; ?>",
			selected: "<?php echo $endDate ? $endDateInfo['mon'] . '/' . $endDateInfo['mday'] . '/' . $endDateInfo['year'] : ''; ?>"
		},
		{
			context: ["tbxEndDate", "tr", "tl"]
		});

	Dom.getElementsByClassName("ari-date-switch", "input", "cntDateAccess", function(chk) {
		Event.on(chk, "click", function() {
			var parent = chk.parentNode,
				enabled = chk.checked;
			while (parent && !Dom.hasClass(parent, "ari-date-cnt"))
				parent = parent.parentNode;

			if (!parent) return ;

			if (enabled)
				Dom.removeClass(parent, "disabled");
			else
				Dom.addClass(parent, "disabled");

			Dom.getElementsByClassName("ari-date-ctrl", null, parent, function(ctrl) {
				ctrl.disabled = !enabled;
			});
		});
	});
});

	YAHOO.ARISoft.page.quizNameValidate = function(val)
	{
		var isValid = true;
		if (typeof(Ajax) != "undefined")
			new Ajax('index.php?option=<?php echo $option; ?>&task=<?php echo $processPage->executionTask; ?>$ajax|checkQuizName&quizId=<?php echo $quizId; ?>&name=' + encodeURIComponent(val.getValue()), 
				{
					async : false,
					onSuccess: function(response) 
					{
						isValid = Json.evaluate(response);
						if (!isValid) isValid = confirm('<?php AriWebHelper::displayResValue('Validator.ConfirmNameNotUnique'); ?>');
					}
				}).request();

		return isValid;	
	};

	YAHOO.ARISoft.page.startDateValidate = function(val) {
		var isValid = true,
			Dom = YAHOO.util.Dom,
			chkStartDate = Dom.get('chkStartDate'),
			hidStartDate = Dom.get('hidStartDate');

		if (!chkStartDate.checked || hidStartDate.value)
			return isValid;

		isValid = false;

		return isValid;
	};

	YAHOO.ARISoft.page.endDateValidate = function(val) {
		var isValid = true,
			Dom = YAHOO.util.Dom,
			chkEndDate = Dom.get('chkEndDate'),
			hidEndDate = Dom.get('hidEndDate');
		
		if (!chkEndDate.checked || hidEndDate.value)
			return isValid;
		
		isValid = false;
		
		return isValid;
	};

	YAHOO.ARISoft.page.compareDateValidate = function(val) {
		var isValid = true,
			Dom = YAHOO.util.Dom,
			chkStartDate = Dom.get('chkStartDate'),
			hidStartDate = Dom.get('hidStartDate'),
			chkEndDate = Dom.get('chkEndDate'),
			hidEndDate = Dom.get('hidEndDate');

		if (!chkEndDate.checked || !hidEndDate.value || !chkStartDate.checked || !hidStartDate.value)
			return isValid;

		var startDate = parseInt(hidStartDate.value, 10) + parseInt(Dom.get("ddlStartHour").value, 10) * 60 * 60 + parseInt(Dom.get("ddlStartMinute").value, 10) * 60,
			endDate = parseInt(hidEndDate.value, 10) + parseInt(Dom.get("ddlEndHour").value, 10) * 60 * 60 + parseInt(Dom.get("ddlEndMinute").value, 10) * 60;

		isValid = (endDate > startDate);
		
		return isValid;
	};
	
	<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?> = function(pressbutton)
	{
		if (pressbutton == 'quiz_add$save' || pressbutton == 'quiz_add$apply')
		{
			if (!aris.validators.alertSummaryValidators.validate())
			{
				return;
			}
		}

		<?php echo J1_6 ? 'Joomla.submitform' : 'submitform'; ?>(pressbutton);
	};
</script>