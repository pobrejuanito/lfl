<?php
	defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
?>

<script src="<?php echo $mosConfig_live_site;?>/components/<?php echo $option; ?>/js/ari.multiplierControls.js" type="text/javascript"></script>
<table id="tblQueContainer" class="questionContainer" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<?php
				if ($uiMode != $uiModeList['Read'])
				{
			?>
			<th class="colMin"><div class="addItemIcon" title="+" onclick="aris.widgets.multiplierControls.addItem('tblQueContainer'); return false;">&nbsp;</div></th>
			<?php
				}
			?>
			<th><?php AriWebHelper::displayResValue('Label.CorrectAnswers'); ?></th>
			<th class="colMin"><?php AriWebHelper::displayResValue('Label.PercentScore'); ?></th>
			<th class="colMin"><?php if (empty($baseOnBank)) { ?><a href="javascript:void(0);" onclick="YAHOO.ARISoft.page.freetextQuestion.switchCI(); return false;"><?php } ?><?php AriWebHelper::displayResValue('Label.TextCI'); ?><?php if (empty($baseOnBank)) { ?><input type="checkbox" id="chkCISwitcher" class="hidSwitcher" /></a><?php } ?></th>
			<?php
				if ($uiMode != $uiModeList['Read'])
				{
			?>
			<th class="colMin"><?php AriWebHelper::displayResValue('Label.Actions'); ?></th>
			<?php
				}
			?>
		</tr>
	</thead>
	<tbody>
		<tr id="trQueTemplate">
			<?php
				if ($uiMode != $uiModeList['Read'])
				{
			?>
			<td>&nbsp;</td>
			<?php
				}
			?>
			<td><input type="text" id="tbxAnswer" name="tbxAnswer" class="text_area" style="width: 99%;" <?php if ($uiMode == $uiModeList['Read']) echo 'disabled="true"'; ?> /></td>
			<td><input type="text" size="5" name="tbxScore" id="tbxScore" class="ftqScoreControl text_area" <?php if ($uiMode == $uiModeList['Read']) echo 'disabled="true"'; ?> /><?php AriWebHelper::displayResValue('Label.Percent'); ?>&nbsp;<?php if (!empty($baseOnBank)) { ?><input type="checkbox" id="chkOverride" name="chkOverride" value="1" alt="Override" title="Override" onclick="YAHOO.ARISoft.page.freetextQuestion.overrideScore(this);" /><input type="hidden" id="hidScore" name="hidScore" /><?php } ?></td>
			<td><input type="checkbox" class="ftqChkCI" id="cbCI" name="cbCI" <?php if ($uiMode == $uiModeList['Read']) echo 'disabled="true"'; ?> />
				<input type="hidden" id="hidQueId" name="hidQueId" />
			</td>
			<?php
				if ($uiMode != $uiModeList['Read'])
				{
			?>
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<div class="deleteItemIcon" onclick="if (confirm('<?php AriWebHelper::displayResValue('Warning.QuestionAnswerRemove'); ?>')) aris.widgets.multiplierControls.removeItem(aris.widgets.multiplierControls.getCurrentTemplateItemId(this, 'trQueTemplate')); return false;" title="Remove">&nbsp;</div>
						</td>
						<td>
							<div class="upItemIcon" onclick="aris.widgets.multiplierControls.moveUpItem(this, 'trQueTemplate'); return false;" title="Up">&nbsp;</div>
						</td>
						<td>
							<div class="downItemIcon" onclick="aris.widgets.multiplierControls.moveDownItem(this, 'trQueTemplate', 'tblQueContainer'); return false;" title="Down">&nbsp;</div>
						</td>
					</tr>
				</table>
			</td>
			<?php
				}
			?>
		</tr>
	</tbody>
</table>
<table class="questionNote" cellpadding="0" cellspacing="0">
	<tr>
		<td class="colMin noWrap"><b><?php AriWebHelper::displayResValue('Label.Note'); ?> :</b></td>
		<td><?php AriWebHelper::displayResValue('Text.FTQNote'); ?></td>
	</tr>
</table>
<script type="text/javascript" language="javascript">
	YAHOO.ARISoft.page.freetextQuestion =
	{
		CONTAINER_ID: 'tblQueContainer',

		CI_CLASS: 'ftqChkCI',

		CI_SWITCHER_ID: 'chkCISwitcher',
		
		SCORE_CONTROL_CLASS: 'ftqScoreControl',

		switchCI: function()
		{
			var chkSwitcher = YAHOO.util.Dom.get(this.CI_SWITCHER_ID);
			chkSwitcher.checked = !chkSwitcher.checked;

			this.switchAll(chkSwitcher.checked, this.CONTAINER_ID, this.CI_CLASS, 'input');
		},

		switchAll: function(status, cont, className, tagName)
		{
			YAHOO.util.Dom.getElementsByClassName(className, tagName, cont, function(chk)
			{
				chk.checked = status;
			});
		},
		
		overrideScore: function(chkOverride)
		{
			var tbxScore = YAHOO.ARISoft.widgets.multiplierControls.getTemplateElement(chkOverride, 'trQueTemplate', 'tbxScore');
			var hidScore = YAHOO.ARISoft.widgets.multiplierControls.getTemplateElement(chkOverride, 'trQueTemplate', 'hidScore');

			tbxScore.disabled = !chkOverride.checked;
			tbxScore.value = hidScore.value;
		}
	};

	aris.widgets.multiplierControls.init('trQueTemplate', 'tblQueContainer', 3, <?php echo WebControls_MultiplierControls::dataToJson($specificQuestion->getDataFromXml($questionData, false, isset($questionOverrideData) ? $questionOverrideData : null)); ?>, function()
	{
		var chkOverrideList = aris.widgets.multiplierControls.getContainerElements('tblQueContainer', 'chkOverride');
		for (var i = 0; i < chkOverrideList.length; i++)
		{
			if (chkOverrideList[i].checked)
			{
				var tbxScore = aris.widgets.multiplierControls.getTemplateElement(chkOverrideList[i], 'trQueTemplate', 'tbxScore');
				tbxScore.disabled = false;
			}
		};
	});
	
	aris.validators.validatorManager.addValidator(
		new aris.validators.customValidator(null,
			function(val)
			{
				var isValid = true;
				var tbxScore = YAHOO.util.Dom.getElementsByClassName(YAHOO.ARISoft.page.freetextQuestion.SCORE_CONTROL_CLASS, 'input', 'tblQueContainer', function(tbxScore)
				{
					if (isValid)
					{
						var sScore = YAHOO.lang.trim(tbxScore.value);
						if (sScore.length > 0)
						{
							var score = parseInt(sScore, 10);
							if (sScore != score || score < 0 || score > 100)
							{
								isValid = false;
							}
						}
					}
				}); 

				return isValid;
			},
			{emptyValidate : true, errorMessage : '<?php AriWebHelper::displayResValue('Validator.QuestionNoSetPercentScore'); ?>'}));
<?php 
if ($uiMode != $uiModeList['Read'])
{
?>
	aris.validators.validatorManager.addValidator(
		new aris.validators.customValidator(null,
			function(val)
			{
				var isValid = false;
				
				var tbxAnswerList = aris.DOM.getChildElementsByAttribute('tblQueContainer', aris.widgets.multiplierControls.originalIdAttr, 'tbxAnswer');
				if (tbxAnswerList && tbxAnswerList.length)
				{
					for (var i = 0; i < tbxAnswerList.length; i++)
					{
						var value = tbxAnswerList[i].value;
						if (value && value.replace(/^\s+|\s+$/g, '').length > 0)
						{
							isValid = true;
							break;
						}
					}
				}
				
				return isValid;
			},
			{emptyValidate : true, errorMessage : '<?php AriWebHelper::displayResValue('Validator.QuestionNotAnswer'); ?>'}));
<?php
}
?>
</script>