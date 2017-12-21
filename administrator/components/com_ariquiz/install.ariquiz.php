<?php
define('_ARI_INSTALL_DEF_VERSION', '1.0.0');
define('_ARI_INSTALL_VERSION', '2.10.3');
define('_ARI_INSTALL_VERSION_KEY', 'Version');
define('_ARI_INSTALL_ERROR_UTF8', 'Database not supported UTF-8 encoding.');

$adminPath = dirname(__FILE__) . '/';
require_once ($adminPath . 'kernel/class.AriKernel.php');

AriKernel::import('PHPCompat.CompatPHP50x');
AriKernel::import('Joomla.JoomlaBridge');
AriKernel::import('Constants.ConstantsManager');
AriKernel::import('Constants.ClassConstants');
AriKernel::import('Controllers.ControllerBase');
AriKernel::import('GlobalPrefs.GlobalPrefs');
AriKernel::import('Components.AriQuiz.AriQuiz');
AriKernel::import('Web.Utils.WebHelper');
AriKernel::import('I18N.I18N');
AriKernel::import('Install.Installer');
AriKernel::import('Xml.SimpleXml');
AriKernel::import('Web.Request');
AriKernel::import('Config.ConfigWrapper');

$quizComp =& AriQuizComponent::instance();
$quizComp->init(false);

function com_install() 
{	
	$option = AriQuizComponent::getCodeName();	
	$installer = new AriQuizInstall(array('option' => $option));

	$res = $installer->install();
	$isSuccess = $installer->isSuccess();

	if (!$isSuccess)
		echo nl2br(trim($res));

	return $isSuccess;
}

class AriQuizInstall extends AriInstallerBase
{
	function installSteps()
	{
		if (!$this->isDbSupportUtf8())
		{
			$error = null;
			if ($this->_isError(false, false))
			{
				$error = $installer->getLastErrorMsg();
			}
			else
			{
				$error = _ARI_INSTALL_ERROR_UTF8;
			}
			
			trigger_error($error, E_USER_ERROR);
			return false;
		}

		$currentVersion = AriConfigWrapper::getConfigKey(AriConstantsManager::getVar('Config.Version', AriQuizComponent::getCodeName()), _ARI_INSTALL_VERSION);
		if (!J1_6)
			$this->updateMenuIcons(
				array(
					array('link' => 'option=' . $this->option, 'image' => '../administrator/components/' . $this->option . '/images/arisoft_icon.png'),
					array('link' => 'option=' . $this->option . '&task=quiz_list', 'image' => '../includes/js/ThemeOffice/categories.png'),
					array('link' => 'option=' . $this->option . '&task=category_list', 'image' => '../includes/js/ThemeOffice/categories.png'),
					array('link' => 'option=' . $this->option . '&task=bankcategory_list', 'image' => '../includes/js/ThemeOffice/categories.png'),
					array('link' => 'option=' . $this->option . '&task=questioncategory_list', 'image' => '../includes/js/ThemeOffice/categories.png'),
					array('link' => 'option=' . $this->option . '&task=bank', 'image' => '../includes/js/ThemeOffice/template.png'),
					array('link' => 'option=' . $this->option . '&task=resultscale_list', 'image' => '../includes/js/ThemeOffice/template.png'),
					array('link' => 'option=' . $this->option . '&task=qtemplate_list', 'image' => '../includes/js/ThemeOffice/template.png'),
					array('link' => 'option=' . $this->option . '&task=texttemplate_list', 'image' => '../includes/js/ThemeOffice/template.png'),
					array('link' => 'option=' . $this->option . '&task=mail_templates', 'image' => '../includes/js/ThemeOffice/template.png'),
					array('link' => 'option=' . $this->option . '&task=templates', 'image' => '../includes/js/ThemeOffice/template.png'),
					array('link' => 'option=' . $this->option . '&task=results', 'image' => '../includes/js/ThemeOffice/search_text.png'),				
					array('link' => 'option=' . $this->option . '&task=lang_backend', 'image' => '../includes/js/ThemeOffice/language.png'),
					array('link' => 'option=' . $this->option . '&task=lang_frontend', 'image' => '../includes/js/ThemeOffice/language.png'),
					array('link' => 'option=' . $this->option . '&task=help', 'image' => '../includes/js/ThemeOffice/help.png'),
					array('link' => 'option=' . $this->option . '&task=faq', 'image' => '../includes/js/ThemeOffice/help.png'),
					array('link' => 'option=' . $this->option . '&task=export', 'image' => '../includes/js/ThemeOffice/backup.png'),
					array('link' => 'option=' . $this->option . '&task=import', 'image' => '../includes/js/ThemeOffice/restore.png'),
					array('link' => 'option=' . $this->option . '&task=securitycategory_list', 'image' => '../includes/js/ThemeOffice/categories.png'),
					array('link' => 'option=' . $this->option . '&task=security_rules', 'image' => '../includes/js/ThemeOffice/template.png'),
				)
			);

		$modPath = dirname(__FILE__) . '/modules/';

		$this->installModule($modPath . 'result');
		$this->installModule($modPath . 'topresult');
		$this->installModule($modPath . 'userresult');
		$this->installModule($modPath . 'usertopresult');

		$isSafeMode = ini_get('safe_mode');
		if (!$isSafeMode)
			$this->setPermissions(
				array(
					$this->adminPath . 'cache/files' => 0777,
					$this->basePath . 'cache/files/css' => 0777, 
					$this->adminPath . 'cache/files/hotspot' => 0777,
					$this->adminPath . 'cache/files/lbackend' => 0777,
					$this->adminPath . 'cache/files/lfrontend' => 0777, 
					$this->adminPath . 'cache/files/i18n/lbackend' => 0777,
					$this->adminPath . 'cache/files/i18n/lfrontend' => 0777,
				));
				
		if (!J1_6)
		{
			$this->_createMenuLinks();
		}
		else
		{
			$this->_installSystemPlugin();
		}

		$this->_upgradeAriQuizLite();
		$this->_applyUpdates($currentVersion);
		$this->doInstallFile($this->adminPath . 'install/description.xml');
		$this->_updateVersion();
		
		return true;
	}

	function _installSystemPlugin()
	{
		jimport( 'joomla.installer.installer' );

		$plgPath = dirname(__FILE__) . DS . 'plugins' . DS;
		$installer = new JInstaller();

		$installer->setOverwrite(true);
		$installer->install($plgPath . 'system');
		
		$database =& JFactory::getDBO();
		$database->setQuery('UPDATE #__extensions SET enabled = 1 WHERE `type` = "plugin" AND `element` = "ariextensions"');
		$database->query();
	}
	
	function _updateVersion()
	{
		$database =& JFactory::getDBO();
		
		$query = sprintf('INSERT INTO #__ariquizconfig (ParamName,ParamValue) VALUES("%s","%s") ON DUPLICATE KEY UPDATE ParamValue="%s"',
			_ARI_INSTALL_VERSION_KEY,
			_ARI_INSTALL_VERSION,
			_ARI_INSTALL_VERSION);
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}
	}
	
	function _createMenuLinks()
	{
		$database =& JFactory::getDBO();

		$option = $this->option;
		
		$query = sprintf('SELECT id FROM #__menu WHERE link="index.php?option=%s" AND type="components" LIMIT 0,1',
			$option);
		$database->setQuery($query);
		$id = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			return false;
		}
		
		$query = !J1_6
			? sprintf('SELECT id FROM #__components WHERE `option`="%s" AND parent=0 LIMIT 0,1',
				$option)
			: sprintf('SELECT extension_id FROM #__extensions WHERE `name`="%s" AND `type`="component" LIMIT 0,1',
				$option);
		$database->setQuery($query);
		$comId = $database->loadResult();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			return false;
		}
		
		if (empty($id))
		{	
			$query = !J1_6
				? sprintf('INSERT INTO #__menu SET menutype="mainmenu",name="Quiz",ordering="99",link="index.php?option=%s",type="components",published="1",parent="0",componentid="%d",params=""',
					$option,
					$comId)
				: sprintf('INSERT INTO #__menu SET menutype="mainmenu",title="Quiz",ordering="99",link="index.php?option=%s",type="component",published="1",parent_id="0",component_id="%d",params=""',
					$option,
					$comId);
					    
		    		$database->setQuery($query);
		    		$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
				return false;
			}
			$id = $database->insertid();
			$query = sprintf('UPDATE #__menu SET alias="ARIQuiz" WHERE id=%d', $id);
			$database->setQuery($query);
    			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		else
		{
			$query = !J1_6
				? sprintf('UPDATE #__menu SET componentid = %d WHERE link="index.php?option=%s" AND type="components"', 
					$comId,
					$option)
				: sprintf('UPDATE #__menu SET component_id = %d WHERE link="index.php?option=%s" AND type="component"', 
					$comId,
					$option);
			$database->setQuery($query);
    		$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
				return false;
			}
		}

		$query = sprintf('SELECT id FROM #__menu WHERE link LIKE "index.php?option=%s&task=quiz_stat%%" AND type="url" LIMIT 0,1',
			$option);
		$database->setQuery($query);
		$statId = $database->loadResult();
		if (empty($statId))
		{
			$query = !J1_6
				? sprintf('INSERT INTO #__menu SET menutype="mainmenu",name="Quiz Statistics",ordering="0",link="index.php?option=%s&task=quiz_stat",type="url",published="1",access="1",parent="%d",componentid="%d",params=""',
						$option,
						$id,
						$comId)
				: sprintf('INSERT INTO #__menu SET menutype="mainmenu",title="Quiz Statistics",ordering="0",link="index.php?option=%s&task=quiz_stat",type="url",published="1",access="1",parent_id="%d",component_id="%d",params=""',
						$option,
						$id,
						$comId);
    		$database->setQuery($query);
    		$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
    		
    		if (!$database->getErrorNum())
			{
				$statId = $database->insertid();
				$query = sprintf('UPDATE #__menu SET link="index.php?option=%s&task=quiz_stat&Itemid=%d" WHERE id=%d',
					$option,
					$statId,
					$statId);

    			$database->setQuery($query);
    			$database->query();
				if ($database->getErrorNum())
				{
					trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
				}
			}
		}
		
		return true;
	}
	
	function _upgradeAriQuizLite()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquiz', 'UseCalculator'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `UseCalculator` tinyint(1) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_1_2_0()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquizquestionversion', 'BankQuestionId'))
		{
			$query = 'ALTER TABLE #__ariquizquestionversion ADD COLUMN `BankQuestionId` int(10) unsigned default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatistics', 'BankVersionId'))
		{
			$query = 'ALTER TABLE #__ariquizstatistics ADD COLUMN `BankVersionId` bigint(20) unsigned NOT NULL default "0"';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizquestion', 'BankQuestionId'))
		{
			$query = 'ALTER TABLE #__ariquizquestion ADD COLUMN `BankQuestionId` int(10) unsigned default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizquestion', 'QuestionTypeId'))
		{
			$query = 'ALTER TABLE #__ariquizquestion ADD COLUMN `QuestionTypeId` int(11) unsigned NOT NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
			
			$query = sprintf('UPDATE #__ariquizquestion QQ INNER JOIN #__ariquizquestionversion QQV' .
				'	ON QQ.QuestionVersionId = QQV.QuestionVersionId' .
				' SET QQ.QuestionTypeId = QQV.QuestionTypeId');
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizquestion', 'QuestionCategoryId'))
		{
			$query = 'ALTER TABLE #__ariquizquestion ADD COLUMN `QuestionCategoryId` int(10) unsigned default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
			
			$query = sprintf('UPDATE #__ariquizquestion QQ INNER JOIN #__ariquizquestionversion QQV' .
				'	ON QQ.QuestionVersionId = QQV.QuestionVersionId' .
				' SET QQ.QuestionCategoryId = QQV.QuestionCategoryId');
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_0_2()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquizstatisticsinfo', 'ExtraData'))
		{
			$query = 'ALTER TABLE #__ariquizstatisticsinfo ADD COLUMN `ExtraData` text';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_1_1()
	{
		$database =& JFactory::getDBO();

		if (!$this->_isColumnExists('#__ariquizquestionversion', 'Note'))
		{
			$query = 'ALTER TABLE #__ariquizquestionversion ADD COLUMN `Note` text';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
			
		$codeName = AriQuizComponent::getCodeName();
		$textTemplateTable = AriConstantsManager::getVar('TextTemplateTable', $codeName);
		$mailTemplateTable = AriConstantsManager::getVar('MailTemplateTable', $codeName);
		$textTemplates = AriConstantsManager::getVar('TextTemplates', $codeName);
		$mailTextTemplate = array(
			$database->Quote($textTemplates['AdminEmail']), 
			$database->Quote($textTemplates['FailedEmail']),
			$database->Quote($textTemplates['SuccessfulEmail']));
		$sMailTextTemplate = join(',', $mailTextTemplate);
		
		// migrate assining text template for mail to mail templates
		$query = sprintf('SELECT GT.TemplateId,GT.TemplateName,GT.Value,GT.CreatedBy' .
			' FROM %1$s GT INNER JOIN %1$sentitymap GTEM' .
			'	ON GT.TemplateId = GTEM.TemplateId' .
			' LEFT JOIN %2$s MT' .
			'	ON GT.TemplateId = MT.TextTemplateId' .
			' WHERE MT.MailTemplateId IS NULL AND GTEM.TemplateType IN (%3$s) AND GT.BaseTemplateId = 1' .
			' GROUP BY GT.TemplateId',
			$textTemplateTable,
			$mailTemplateTable,
			$sMailTextTemplate);
		$database->setQuery($query);
		$result = $database->loadAssocList();
		if ($database->getErrorNum())
		{ 
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			return false;
		}
		
		if (!empty($result))
		{
			$query = sprintf('INSERT INTO %1$s (TemplateId,BaseTemplateId,TemplateName,Value,Created,CreatedBy,Modified,ModifiedBy) VALUES(NULL,2,%%s,%%s,NOW(),%%d,NULL,NULL)',
					$textTemplateTable);
			$mapTable = array();
			foreach ($result as $item)
			{		
				$itemQuery = sprintf($query,
					$database->Quote($item['TemplateName']),
					$database->Quote($item['Value']),
					$item['CreateBy']);
				$database->setQuery($itemQuery);
				$database->query();
				if ($database->getErrorNum())
				{ 
					trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
					return false;
				}
				
				$id = $database->insertid();
				$itemQuery = sprintf('UPDATE %sentitymap SET TemplateId=%d WHERE TemplateId=%d AND TemplateType IN(%s)',
					$textTemplateTable,
					$id,
					$item['TemplateId'],
					$sMailTextTemplate);
				$database->setQuery($itemQuery);
				$database->query();
				if ($database->getErrorNum())
				{ 
					trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
					return false;
				}
				
				$itemQuery = sprintf('INSERT INTO %1$s (`MailTemplateId`,`Subject`,`TextTemplateId`,`FromName`,`AllowHtml`,`From`) VALUES(NULL,NULL,%2$d,NULL,1,NULL)',
					$mailTemplateTable,
					$id);
				$database->setQuery($itemQuery);
				$database->query();
				if ($database->getErrorNum())
				{ 
					trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
					return false;
				}
			}
		}
	}
	
	function _updateTo_2_1_2()
	{
		$database =& JFactory::getDBO();

		if (!$this->_isColumnExists('#__ariquiz', 'ResultScaleId'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `ResultScaleId` int(11) unsigned default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}

	function _updateTo_2_1_9()
	{
		$database =& JFactory::getDBO();

		if (!$this->_isColumnExists('#__ariquiz', 'ParsePluginTag'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `ParsePluginTag` tinyint(1) unsigned NOT NULL default \'1\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_4_0()
	{
		$database =& JFactory::getDBO();

		if (!$this->_isColumnExists('#__ariquiz', 'CanStop'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `CanStop` tinyint(1) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatisticsinfo', 'CurrentStatisticsId'))
		{
			$query = 'ALTER TABLE #__ariquizstatisticsinfo ADD COLUMN `CurrentStatisticsId` bigint(20) unsigned default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatisticsinfo', 'ModifiedDate'))
		{
			$query = 'ALTER TABLE #__ariquizstatisticsinfo ADD COLUMN `ModifiedDate` datetime default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatisticsinfo', 'ResumeDate'))
		{
			$query = 'ALTER TABLE #__ariquizstatisticsinfo ADD COLUMN `ResumeDate` datetime default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatisticsinfo', 'UsedTime'))
		{
			$query = 'ALTER TABLE #__ariquizstatisticsinfo ADD COLUMN `UsedTime` int(11) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatistics', 'InitData'))
		{
			$query = 'ALTER TABLE #__ariquizstatistics ADD COLUMN `InitData` longtext';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatistics', 'AttemptCount'))
		{
			$query = 'ALTER TABLE #__ariquizstatistics ADD COLUMN `AttemptCount` int(11) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		$query = 'ALTER TABLE #__ariquizstatisticsinfo CHANGE `Status` `Status` SET ("Prepare", "Process", "Finished", "Pause") NOT NULL DEFAULT "Process"';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}
		
		if ($this->_isIndexExists('#__ariquizquizcategory', 'SSCUniquePair'))
		{
			$database->setQuery('ALTER TABLE #__ariquizquizcategory DROP INDEX `SSCUniquePair`');
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_5_0()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquiz', 'QuestionOrderType'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `QuestionOrderType` set(\'Numeric\',\'AlphaLower\',\'AlphaUpper\') NOT NULL default \'Numeric\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		$query = 'ALTER TABLE #__ariquizstatistics_attempt CHANGE `StatisticsId` `StatisticsId` bigint(20) unsigned NOT NULL';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}
		
		// Fix hotspot questions
		$query = 'SELECT QV.QuestionVersionId,QV.Data,QV.QuestionId' .
			' FROM #__ariquizquestionversion QV LEFT JOIN #__ariquizquestiontype QT' .
			'	ON QV.QuestionTypeId = QT.QuestionTypeId' .
			' WHERE QT.ClassName="HotSpotQuestion"';
		$database->setQuery($query);
		$data = $database->loadAssocList();
		if (is_array($data))
		{
			$insertData = array();
			foreach ($data as $dataItem)
			{
				$questionData = $dataItem['Data'];
				if (empty($questionData)) continue;

				$fileId = 0;
				
				$matches = array();
				preg_match('/imgid="(\d+)"/i', $questionData, $matches);
				if (count($matches) > 1) $fileId = @intval($matches[1], 10);

				if ($fileId < 1) continue;

				$insertData[] = sprintf('(%d,%d,"hotspot_image",%d)',
					$fileId,
					$dataItem['QuestionVersionId'],
					$dataItem['QuestionId']);
			}
			
			if (count($insertData) > 0)
			{
				$query = 'INSERT INTO #__ariquiz_question_version_files (FileId,QuestionVersionId,`Alias`,QuestionId) VALUES ' . join(',', $insertData) . ' ON DUPLICATE KEY UPDATE FileId=FileId';
				$database->setQuery($query);
				$database->query();
				if ($database->getErrorNum())
				{
					trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
				}
			}
		}
	}

	function _updateTo_2_7_0()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquizstatistics', 'QuestionId'))
		{
			$query = 'ALTER TABLE #__ariquizstatistics ADD COLUMN `QuestionId` int(10) unsigned NOT NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquizstatistics', 'BankQuestionId'))
		{
			$query = 'ALTER TABLE #__ariquizstatistics ADD COLUMN `BankQuestionId` int(10) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		$query = 'UPDATE #__ariquizstatistics QS INNER JOIN #__ariquizquestionversion QQV' .
			'	ON QS.QuestionVersionId = QQV.QuestionVersionId' .
			' LEFT JOIN #__ariquizquestionversion QQV2' .
			'	ON QS.BankVersionId = QQV2.QuestionVersionId' .
			' SET' .
 			' QS.QuestionId = QQV.QuestionId,QS.BankQuestionId = QQV2.QuestionId';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}

		if ($this->_isColumnExists('#__ariquizquestionversion', 'ShowAsImage'))
		{
			$query = 'ALTER TABLE #__ariquizquestionversion DROP COLUMN `ShowAsImage`';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		$modifyQueries = array(
			'ALTER TABLE #__arigenerictemplate CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestion CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestion CHANGE `QuestionCategoryId` `QuestionCategoryId` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestion CHANGE `BankQuestionId` `BankQuestionId` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestion CHANGE `QuestionIndex` `QuestionIndex` int(11) unsigned NOT NULL default "0"',
			//'ALTER TABLE #__ariquizquestion CHANGE `QuestionVersionId` `QuestionVersionId` bigint(20) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizcategory CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestioncategory CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestioncategory CHANGE `QuestionCount` `QuestionCount` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestioncategory CHANGE `QuestionTime` `QuestionTime` int(10) unsigned NOT NULL default "0"',		
			'ALTER TABLE #__ariquiz CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquiz CHANGE `QuestionCount` `QuestionCount` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquiz CHANGE `QuestionTime` `QuestionTime` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquiz CHANGE `ResultScaleId` `ResultScaleId` int(11) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizbankcategory CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestiontemplate CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',			
			'ALTER TABLE #__ariquizquestionversion CHANGE `QuestionCategoryId` `QuestionCategoryId` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestionversion CHANGE `QuestionTime` `QuestionTime` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizquestionversion CHANGE `BankQuestionId` `BankQuestionId` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizstatistics CHANGE `QuestionId` `QuestionId` int(10) unsigned NOT NULL',
			'ALTER TABLE #__ariquizstatistics CHANGE `BankQuestionId` `BankQuestionId` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizstatistics CHANGE `QuestionTime` `QuestionTime` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizstatisticsinfo CHANGE `TotalTime` `TotalTime` int(10) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquizfile CHANGE `ModifiedBy` `ModifiedBy` int(11) unsigned NOT NULL default "0"',
			'ALTER TABLE #__ariquiz_result_scale CHANGE `ModifiedBy` `ModifiedBy` int(10) unsigned NOT NULL default "0"',
		);
		
		foreach ($modifyQueries as $modifyQuery)
		{
			$database->setQuery($modifyQuery);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if ($this->_isIndexExists('#__ariquiz_question_version_files', 'Alias'))
		{
			$database->setQuery('ALTER TABLE #__ariquiz_question_version_files DROP INDEX `Alias`');
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		$indexesInfo = array(
			array(
				'Table' => '#__arigenerictemplate',
				'Index' => 'BaseTemplateId',
				'Query' => 'ALTER TABLE #__arigenerictemplate ADD INDEX `BaseTemplateId` (`BaseTemplateId`)'
			),
			array(
				'Table' => '#__arigenerictemplatebase',
				'Index' => 'Group',
				'Query' => 'ALTER TABLE #__arigenerictemplatebase ADD INDEX `Group` (`Group`)'
			),
			array(
				'Table' => '#__arigenerictemplateentitymap',
				'Index' => 'TemplateEntityMap',
				'Query' => 'ALTER TABLE #__arigenerictemplateentitymap ADD UNIQUE INDEX `TemplateEntityMap` (`EntityName`(50),`EntityId`,`TemplateType`(50))'
			),
			array(
				'Table' => '#__arigenerictemplateentitymap',
				'Index' => 'TemplateId',
				'Query' => 'ALTER TABLE #__arigenerictemplateentitymap ADD INDEX `TemplateId` (`TemplateId`)'
			),
			array(
				'Table' => '#__arigenerictemplateparam',
				'Index' => 'BaseTemplateId',
				'Query' => 'ALTER TABLE #__arigenerictemplateparam ADD INDEX `BaseTemplateId` (`BaseTemplateId`)'
			),
			array(
				'Table' => '#__ariquizmailtemplate',
				'Index' => 'TextTemplateId',
				'Query' => 'ALTER TABLE #__ariquizmailtemplate ADD INDEX `TextTemplateId` (`TextTemplateId`)'
			),
			array(
				'Table' => '#__ariquizquestion',
				'Index' => 'QuestionVersionId',
				'Query' => 'ALTER TABLE #__ariquizquestion ADD UNIQUE INDEX `QuestionVersionId` (`QuestionVersionId`)'
			),
			array(
				'Table' => '#__ariquizquestion',
				'Index' => 'Sorting_QuestionIndex',
				'Query' => 'ALTER TABLE #__ariquizquestion ADD INDEX `Sorting_QuestionIndex` (`QuizId`,`Status`,`QuestionIndex`)'
			),
			array(
				'Table' => '#__ariquizquestion',
				'Index' => 'Status',
				'Query' => 'ALTER TABLE #__ariquizquestion ADD INDEX `Status` (`Status`)'
			),
			array(
				'Table' => '#__ariquizquestion',
				'Index' => 'BankQuestionId',
				'Query' => 'ALTER TABLE #__ariquizquestion ADD INDEX `BankQuestionId` (`BankQuestionId`)'
			),
			array(
				'Table' => '#__ariquizquestion',
				'Index' => 'QuestionTypeId',
				'Query' => 'ALTER TABLE #__ariquizquestion ADD INDEX `QuestionTypeId` (`QuestionTypeId`)'
			),
			array(
				'Table' => '#__ariquizquestion',
				'Index' => 'QuestionCategoryId',
				'Query' => 'ALTER TABLE #__ariquizquestion ADD INDEX `QuestionCategoryId` (`QuestionCategoryId`)'
			),
			array(
				'Table' => '#__ariquizquestioncategory',
				'Index' => 'QuizId',
				'Query' => 'ALTER TABLE #__ariquizquestioncategory ADD INDEX `QuizId` (`QuizId`)'
			),
			array(
				'Table' => '#__ariquizquestioncategory',
				'Index' => 'Status',
				'Query' => 'ALTER TABLE #__ariquizquestioncategory ADD INDEX `Status` (`Status`)'
			),
			array(
				'Table' => '#__ariquiz',
				'Index' => 'CssTemplateId',
				'Query' => 'ALTER TABLE #__ariquiz ADD INDEX `CssTemplateId` (`CssTemplateId`)'
			),
			array(
				'Table' => '#__ariquizquestiontemplate',
				'Index' => 'QuestionTypeId',
				'Query' => 'ALTER TABLE #__ariquizquestiontemplate ADD INDEX `QuestionTypeId` (`QuestionTypeId`)'
			),
			array(
				'Table' => '#__ariquizquestiontemplate',
				'Index' => 'TemplateName',
				'Query' => 'ALTER TABLE #__ariquizquestiontemplate ADD INDEX `TemplateName` (`TemplateName`)'
			),
			array(
				'Table' => '#__ariquizquestionversion',
				'Index' => 'QuestionId',
				'Query' => 'ALTER TABLE #__ariquizquestionversion ADD INDEX `QuestionId` (`QuestionId`)'
			),
			array(
				'Table' => '#__ariquizquestionversion',
				'Index' => 'QuestionCategoryId',
				'Query' => 'ALTER TABLE #__ariquizquestionversion ADD INDEX `QuestionCategoryId` (`QuestionCategoryId`)'
			),
			array(
				'Table' => '#__ariquizquestionversion',
				'Index' => 'QuestionTypeId',
				'Query' => 'ALTER TABLE #__ariquizquestionversion ADD INDEX `QuestionTypeId` (`QuestionTypeId`)'
			),
			array(
				'Table' => '#__ariquizquestionversion',
				'Index' => 'BankQuestionId',
				'Query' => 'ALTER TABLE #__ariquizquestionversion ADD INDEX `BankQuestionId` (`BankQuestionId`)'
			),
			array(
				'Table' => '#__ariquizstatistics',
				'Index' => 'QuestionVersionId',
				'Query' => 'ALTER TABLE #__ariquizstatistics ADD INDEX `QuestionVersionId` (`QuestionVersionId`)'
			),
			array(
				'Table' => '#__ariquizstatistics',
				'Index' => 'StatisticsInfoId',
				'Query' => 'ALTER TABLE #__ariquizstatistics ADD INDEX `StatisticsInfoId` (`StatisticsInfoId`)'
			),
			array(
				'Table' => '#__ariquizstatistics',
				'Index' => 'QuestionCategoryId',
				'Query' => 'ALTER TABLE #__ariquizstatistics ADD INDEX `QuestionCategoryId` (`QuestionCategoryId`)'
			),
			array(
				'Table' => '#__ariquizstatistics',
				'Index' => 'BankVersionId',
				'Query' => 'ALTER TABLE #__ariquizstatistics ADD INDEX `BankVersionId` (`BankVersionId`)'
			),
			array(
				'Table' => '#__ariquizstatisticsinfo',
				'Index' => 'TicketId',
				'Query' => 'ALTER TABLE #__ariquizstatisticsinfo ADD UNIQUE INDEX `TicketId` (`TicketId`)'
			),
			array(
				'Table' => '#__ariquizstatisticsinfo',
				'Index' => 'CurrentStatisticsId',
				'Query' => 'ALTER TABLE #__ariquizstatisticsinfo ADD UNIQUE INDEX `CurrentStatisticsId` (`CurrentStatisticsId`)'
			),
			array(
				'Table' => '#__ariquizstatisticsinfo',
				'Index' => 'QuizId',
				'Query' => 'ALTER TABLE #__ariquizstatisticsinfo ADD INDEX `QuizId` (`QuizId`)'
			),
			array(
				'Table' => '#__ariquizstatisticsinfo',
				'Index' => 'UserId',
				'Query' => 'ALTER TABLE #__ariquizstatisticsinfo ADD INDEX `UserId` (`UserId`)'
			),
			array(
				'Table' => '#__ariquizstatisticsinfo',
				'Index' => 'Status',
				'Query' => 'ALTER TABLE #__ariquizstatisticsinfo ADD INDEX `Status` (`Status`)'
			),
			array(
				'Table' => '#__ariquizfile',
				'Index' => 'Group',
				'Query' => 'ALTER TABLE #__ariquizfile ADD INDEX `Group` (`Group`)'
			),
			array(
				'Table' => '#__ariquizfile',
				'Index' => 'Sorting_ShortDescription',
				'Query' => 'ALTER TABLE #__ariquizfile ADD INDEX `Sorting_ShortDescription` (`Group`(20),`ShortDescription`)'
			),
			
			array(
				'Table' => '#__ariquiz_persistance',
				'Index' => 'OwnerKey',
				'Query' => 'ALTER TABLE #__ariquiz_persistance ADD UNIQUE INDEX `OwnerKey` (`OwnerKey`,`Key`,`UserId`,`Name`)'
			),
			array(
				'Table' => '#__ariquiz_property',
				'Index' => 'Entity',
				'Query' => 'ALTER TABLE #__ariquiz_property ADD INDEX `Entity` (`Entity`)'
			),
			array(
				'Table' => '#__ariquiz_result_scale',
				'Index' => 'ScaleName',
				'Query' => 'ALTER TABLE #__ariquiz_result_scale ADD INDEX `ScaleName` (`ScaleName`)'
			),
			array(
				'Table' => '#__ariquiz_result_scale_item',
				'Index' => 'ScaleId',
				'Query' => 'ALTER TABLE #__ariquiz_result_scale_item ADD INDEX `ScaleId` (`ScaleId`)'
			),
			array(
				'Table' => '#__ariquiz_result_scale_item',
				'Index' => 'TextTemplateId',
				'Query' => 'ALTER TABLE #__ariquiz_result_scale_item ADD INDEX `TextTemplateId` (`TextTemplateId`)'
			),
			array(
				'Table' => '#__ariquiz_result_scale_item',
				'Index' => 'MailTemplateId',
				'Query' => 'ALTER TABLE #__ariquiz_result_scale_item ADD INDEX `MailTemplateId` (`MailTemplateId`)'
			),
			array(
				'Table' => '#__ariquiz_result_scale_item',
				'Index' => 'PrintTemplateId',
				'Query' => 'ALTER TABLE #__ariquiz_result_scale_item ADD INDEX `PrintTemplateId` (`PrintTemplateId`)'
			),
			array(
				'Table' => '#__ariquiz_property_value',
				'Index' => 'EntityKey',
				'Query' => 'ALTER TABLE #__ariquiz_property_value ADD UNIQUE INDEX `EntityKey` (`EntityKey`,`PropertyId`)'
			),
			array(
				'Table' => '#__ariquizquestiontype',
				'Index' => 'QuestionType',
				'Query' => 'ALTER TABLE #__ariquizquestiontype ADD UNIQUE INDEX `QuestionType` (`QuestionType`)'
			),
			
			array(
				'Table' => '#__ariquiz_question_version_files',
				'Index' => 'QuestionVersionId',
				'Query' => 'ALTER TABLE #__ariquiz_question_version_files ADD UNIQUE INDEX `QuestionVersionId` (`QuestionVersionId`, `Alias`)'
			),
			array(
				'Table' => '#__ariquiz_question_version_files',
				'Index' => 'QuestionId',
				'Query' => 'ALTER TABLE #__ariquiz_question_version_files ADD INDEX `QuestionId` (`QuestionId`)'
			),
			array(
				'Table' => '#__ariquiz_question_version_files',
				'Index' => 'FileId',
				'Query' => 'ALTER TABLE #__ariquiz_question_version_files ADD INDEX `FileId` (`FileId`)'
			),
		);
		
		foreach ($indexesInfo as $indexInfo)
		{
			if (!$this->_isIndexExists($indexInfo['Table'], $indexInfo['Index']))
			{
				$database->setQuery($indexInfo['Query']);
				$database->query();
				if ($database->getErrorNum())
				{
					trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
				}
			}
		}
	}
	
	function _updateTo_2_8_0()
	{
		$database =& JFactory::getDBO();

		if (!$this->_isColumnExists('#__ariquiz', 'ShowCorrectAnswer'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `ShowCorrectAnswer` tinyint(1) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}

		if (!$this->_isColumnExists('#__ariquiz', 'ShowExplanation'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `ShowExplanation` tinyint(1) unsigned NOT NULL default \'0\'';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquiz', 'Anonymous'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `Anonymous` SET("Yes","No","ByUser") NOT NULL default "Yes"';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquiz', 'FullStatistics'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `FullStatistics` SET("Never","Always","OnLastAttempt") NOT NULL default "Never"';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}

		$query = sprintf('UPDATE #__ariquiz Q INNER JOIN #__ariquiz_property_value PV' .
			'	ON Q.QuizId = PV.EntityKey' .
			' INNER JOIN #__ariquiz_property P' .
			'	ON PV.PropertyId = P.PropertyId' .
			' SET Q.FullStatistics = "Always"' .
			' WHERE P.Entity = "AriQuiz" AND P.PropertyName = "ShowFullStatistics" AND PV.PropertyValue <> "0"');
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}
		
		$query = 'DELETE FROM P,PV USING #__ariquiz_property P,#__ariquiz_property_value PV WHERE P.PropertyId = PV.PropertyId AND P.Entity = "AriQuiz" AND P.PropertyName = "ShowFullStatistics"';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}
	}
	
	function _updateTo_2_9_4()
	{
		$database =& JFactory::getDBO();
		
		$query = 'ALTER TABLE #__ariquiz CHANGE `FullStatistics` `FullStatistics` SET("Never","Always","OnLastAttempt","OnSuccess","OnFail") NOT NULL default "Never"';
		$database->setQuery($query);
		$database->query();
		if ($database->getErrorNum())
		{
			trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
		}
	}
	
	function _updateTo_2_9_6()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquiz', 'MailGroupList'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `MailGroupList` VARCHAR(255) default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_9_7()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquiz', 'AutoMailToUser'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `AutoMailToUser` tinyint(1) unsigned NOT NULL default "0"';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_9_9()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquizquestionversion', 'OnlyCorrectAnswer'))
		{
			$query = 'ALTER TABLE #__ariquizquestionversion ADD COLUMN `OnlyCorrectAnswer` tinyint(1) unsigned NOT NULL default "0"';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
	}
	
	function _updateTo_2_9_10()
	{
		$database =& JFactory::getDBO();
		
		if (!$this->_isColumnExists('#__ariquiz', 'StartDate'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `StartDate` datetime default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}
		
		if (!$this->_isColumnExists('#__ariquiz', 'EndDate'))
		{
			$query = 'ALTER TABLE #__ariquiz ADD COLUMN `EndDate` datetime default NULL';
			$database->setQuery($query);
			$database->query();
			if ($database->getErrorNum())
			{
				trigger_error(sprintf(_ARI_INSTALL_ERROR_EXECUTEQUERY, $database->getErrorMsg()), E_USER_ERROR);
			}
		}	
	}	
}
?>