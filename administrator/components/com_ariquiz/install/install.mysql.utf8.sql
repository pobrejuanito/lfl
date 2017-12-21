CREATE TABLE IF NOT EXISTS `#__arigenerictemplate` (
	`TemplateId` int(10) unsigned NOT NULL auto_increment,
	`BaseTemplateId` int(11) NOT NULL,
	`TemplateName` varchar(255) NOT NULL,
	`Value` text,
	`Created` datetime NOT NULL,
	`CreatedBy` int(10) unsigned NOT NULL default '0',
	`Modified` datetime default NULL,
	`ModifiedBy` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`TemplateId`),
	KEY `BaseTemplateId` (`BaseTemplateId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__arigenerictemplatebase` (
	`BaseTemplateId` int(10) unsigned NOT NULL auto_increment,
	`DefaultValue` text,
	`TemplateDescription` text,
	`Group` varchar(255) NOT NULL,
	PRIMARY KEY  (`BaseTemplateId`),
	KEY `Group` (`Group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__arigenerictemplateentitymap` (
	`TemplateId` int(11) NOT NULL,
	`EntityName` varchar(255) NOT NULL,
	`TemplateType` varchar(255) NOT NULL,
	`EntityId` int(11) NOT NULL,
	UNIQUE KEY `TemplateEntityMap` (`EntityName`(50),`EntityId`,`TemplateType`(50)),
	KEY `TemplateId` (`TemplateId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__arigenerictemplateparam` (
	`ParamId` int(10) unsigned NOT NULL auto_increment,
	`BaseTemplateId` int(11) NOT NULL,
	`ParamName` varchar(255) NOT NULL,
	`ParamDescription` text,
	`ParamType` varchar(255) default NULL,
	PRIMARY KEY  (`ParamId`),
	KEY `BaseTemplateId` (`BaseTemplateId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizmailtemplate` (
    `MailTemplateId` int(10) unsigned NOT NULL auto_increment,
    `TextTemplateId` int(10) unsigned NOT NULL,
    `Subject` varchar(255) default NULL,
    `From` varchar(255) default NULL,
    `FromName` varchar(255) default NULL,
	`AllowHtml` tinyint(1) unsigned NOT NULL default '1',
    PRIMARY KEY  (`MailTemplateId`),
    KEY `TextTemplateId` (`TextTemplateId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz` (
  `QuizId` int(10) unsigned NOT NULL auto_increment,
  `QuizName` varchar(255) NOT NULL,
  `CreatedBy` int(10) unsigned NOT NULL,
  `Created` datetime NOT NULL,
  `ModifiedBy` int(10) unsigned NOT NULL default '0',
  `Modified` datetime default NULL,
  `AccessType` int(10) unsigned default NULL,
  `Status` int(10) unsigned NOT NULL,
  `TotalTime` int(10) unsigned default NULL,
  `PassedScore` int(10) unsigned NOT NULL default '0',				  
  `QuestionCount` int(10) unsigned NOT NULL default '0',
  `QuestionTime` int(10) unsigned NOT NULL default '0',
  `Description` longtext,
  `CanSkip` tinyint(1) unsigned NOT NULL default '0',
  `CanStop` tinyint(1) unsigned NOT NULL default '0',
  `RandomQuestion` tinyint(1) unsigned NOT NULL default '0',
  `UseCalculator` tinyint(1) unsigned NOT NULL default '0',
  `LagTime` int(11) unsigned NOT NULL default '0',
  `AttemptCount` int(11) unsigned NOT NULL default '0',
  `CssTemplateId` int(11) unsigned NOT NULL default '0',
  `AdminEmail` text,
  `ResultScaleId` int(11) unsigned NOT NULL default '0',
  `ParsePluginTag` tinyint(1) unsigned NOT NULL default '1',
  `ShowCorrectAnswer` tinyint(1) unsigned NOT NULL default '0',
  `ShowExplanation` tinyint(1) unsigned NOT NULL default '0',
  `QuestionOrderType` set('Numeric','AlphaLower','AlphaUpper') NOT NULL default 'Numeric',
  `Anonymous` SET('Yes','No','ByUser') NOT NULL default 'Yes',
  `FullStatistics` SET('Never','Always','OnLastAttempt','OnSuccess','OnFail') NOT NULL default 'Never',
  `MailGroupList` VARCHAR(255) default NULL,
  `AutoMailToUser` tinyint(1) unsigned NOT NULL default '0',
  `StartDate` datetime default NULL,
  `EndDate` datetime default NULL,
  PRIMARY KEY  (`QuizId`),
  KEY `CssTemplateId` (`CssTemplateId`),
  KEY `Status` (`Status`),
  KEY `ResultScaleId` (`ResultScaleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizaccess` (
	`QuizId` int(10) unsigned NOT NULL,
	`GroupId` int(10) unsigned NOT NULL,
	PRIMARY KEY  (`QuizId`,`GroupId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizcategory` (
	`CategoryId` int(10) unsigned NOT NULL auto_increment,
	`CategoryName` varchar(255) NOT NULL,
	`Description` text NOT NULL,
	`Created` datetime NOT NULL,
	`CreatedBy` int(10) unsigned NOT NULL,
	`Modified` datetime default NULL,
	`ModifiedBy` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`CategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizconfig` (
	`ParamName` varchar(100) NOT NULL,
	`ParamValue` varchar(255) NOT NULL,
	PRIMARY KEY  (`ParamName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizquestion` (
	`QuestionId` int(10) unsigned NOT NULL auto_increment,
	`QuizId` int(10) unsigned NOT NULL,
	`QuestionVersionId` bigint(20) default NULL,
	`Created` datetime NOT NULL,
	`CreatedBy` int(10) unsigned NOT NULL,
	`Modified` datetime default NULL,
	`ModifiedBy` int(10) unsigned NOT NULL default '0',
	`Status` int(11) unsigned NOT NULL,
	`QuestionIndex` int(11) unsigned NOT NULL default '0',
    `BankQuestionId` int(10) unsigned NOT NULL default '0',
	`QuestionTypeId` int(11) unsigned NOT NULL,
	`QuestionCategoryId` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`QuestionId`),
	UNIQUE KEY `QuestionVersionId` (`QuestionVersionId`),
	KEY `Sorting_QuestionIndex` (`QuizId`,`Status`,`QuestionIndex`),
	KEY `Status` (`Status`),
	KEY `BankQuestionId` (`BankQuestionId`),
	KEY `QuestionTypeId` (`QuestionTypeId`),
	KEY `QuestionCategoryId` (`QuestionCategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizquestioncategory` (
	`QuestionCategoryId` int(10) unsigned NOT NULL auto_increment,
	`QuizId` int(10) unsigned NOT NULL,
	`CategoryName` varchar(255) NOT NULL,
	`Description` text,
	`Created` datetime NOT NULL,
	`CreatedBy` int(10) unsigned NOT NULL,
	`Modified` datetime default NULL,
	`ModifiedBy` int(10) unsigned NOT NULL default '0',
	`QuestionCount` int(10) unsigned NOT NULL default '0',
	`QuestionTime` int(10) unsigned NOT NULL default '0',
	`RandomQuestion` tinyint(1) unsigned NOT NULL default '0',
	`Status` int(11) unsigned NOT NULL default '1',
	PRIMARY KEY  (`QuestionCategoryId`),
	KEY `QuizId` (`QuizId`),
  	KEY `Status` (`Status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizbankcategory` (
	`CategoryId` int(10) unsigned NOT NULL auto_increment,
	`CategoryName` varchar(255) NOT NULL,
	`Description` text NOT NULL,
	`Created` datetime NOT NULL,
	`CreatedBy` int(10) unsigned NOT NULL,
	`Modified` datetime default NULL,
	`ModifiedBy` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`CategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizquestiontemplate` (
  `TemplateId` int(10) unsigned NOT NULL auto_increment,
  `TemplateName` varchar(255) NOT NULL,
  `QuestionTypeId` int(11) NOT NULL,
  `Data` longtext,
  `Created` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL,
  `Modified` datetime default NULL,
  `ModifiedBy` int(10) unsigned NOT NULL default '0',
  `DisableValidation` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`TemplateId`),
  KEY `QuestionTypeId` (`QuestionTypeId`),
  KEY `TemplateName` (`TemplateName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizquestiontype` (
	`QuestionTypeId` int(10) unsigned NOT NULL auto_increment,
	`QuestionType` varchar(255) NOT NULL,
	`ClassName` varchar(255) NOT NULL,
	`Default` tinyint(1) unsigned NOT NULL,
	`CanHaveTemplate` tinyint(1) unsigned NOT NULL default '1',
	`TypeOrder` int(11) unsigned NOT NULL default '0',
	PRIMARY KEY  (`QuestionTypeId`),
	UNIQUE KEY `QuestionType` (`QuestionType`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;	

CREATE TABLE IF NOT EXISTS `#__ariquizquestionversion` (
  `QuestionVersionId` bigint(20) unsigned NOT NULL auto_increment,
  `QuestionId` int(10) unsigned NOT NULL,
  `QuestionCategoryId` int(10) unsigned NOT NULL default '0',
  `QuestionTime` int(10) unsigned NOT NULL default '0',
  `QuestionTypeId` int(11) unsigned NOT NULL,
  `Question` text NOT NULL,
  `HashCode` char(32) NOT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` int(10) unsigned NOT NULL,
  `Data` longtext NOT NULL,
  `Score` int(11) unsigned NOT NULL,
  `BankQuestionId` int(10) unsigned NOT NULL default '0',
  `Note` text default NULL,
  `OnlyCorrectAnswer` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`QuestionVersionId`),
  KEY `QuestionId` (`QuestionId`),
  KEY `QuestionCategoryId` (`QuestionCategoryId`),
  KEY `QuestionTypeId` (`QuestionTypeId`),
  KEY `BankQuestionId` (`BankQuestionId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizquizcategory` (
	`QuizId` int(10) unsigned NOT NULL,
	`CategoryId` int(10) unsigned NOT NULL,
	PRIMARY KEY  (`QuizId`,`CategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizstatistics` (
	`StatisticsId` bigint(20) unsigned NOT NULL auto_increment,
	`QuestionId` int(10) unsigned NOT NULL,
	`QuestionVersionId` bigint(20) unsigned NOT NULL,
	`StatisticsInfoId` bigint(20) NOT NULL,
	`Data` longtext,
	`StartDate` datetime default NULL,
	`EndDate` datetime default NULL,
	`SkipDate` datetime default NULL,
	`SkipCount` int(11) unsigned NOT NULL default '0',
	`UsedTime` int(11) unsigned NOT NULL default '0',
	`QuestionIndex` int(10) unsigned NOT NULL,
	`Score` int(10) unsigned default NULL,
	`QuestionTime` int(10) unsigned NOT NULL default '0',
	`QuestionCategoryId` int(10) unsigned NOT NULL,
	`IpAddress` int(10) unsigned default NULL,
	`BankQuestionId` int(10) unsigned NOT NULL default '0',
	`BankVersionId` bigint(20) unsigned NOT NULL default '0',
	`InitData` longtext,
	`AttemptCount` int(11) unsigned NOT NULL default '0',
	PRIMARY KEY  (`StatisticsId`),
	KEY `QuestionVersionId` (`QuestionVersionId`),
	KEY `StatisticsInfoId` (`StatisticsInfoId`),
	KEY `QuestionCategoryId` (`QuestionCategoryId`),
	KEY `BankVersionId` (`BankVersionId`)					
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizstatistics_attempt` (
	`StatisticsId` bigint(20) unsigned NOT NULL,
	`Data` longtext,
	`CreatedDate` datetime NOT NULL,
	KEY `StatisticsId` (`StatisticsId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizstatisticsinfo` (
	`StatisticsInfoId` bigint(20) unsigned NOT NULL auto_increment,
	`QuizId` int(10) unsigned NOT NULL,
	`UserId` int(10) unsigned NOT NULL default '0',
	`Status` set('Prepare','Process','Finished','Pause') NOT NULL default 'Process',
	`TicketId` char(32) NOT NULL,
	`StartDate` datetime default NULL,
	`EndDate` datetime default NULL,
	`PassedScore` int(11) unsigned NOT NULL default '0',
	`UserScore` int(11) unsigned NOT NULL default '0',
	`MaxScore` int(11) unsigned NOT NULL default '0',
	`Passed` tinyint(1) unsigned NOT NULL default '0',
	`CreatedDate` datetime NOT NULL,
	`QuestionCount` int(11) unsigned NOT NULL default '0',
	`TotalTime` int(10) unsigned NOT NULL default '0',
	`ResultEmailed` tinyint(1) unsigned NOT NULL default '0',
	`ExtraData` text,
	`CurrentStatisticsId` bigint(20) unsigned default NULL,
	`UsedTime` int(11) unsigned NOT NULL default '0',
	`ResumeDate` datetime default NULL,
	`ModifiedDate` datetime default NULL,
	PRIMARY KEY  (`StatisticsInfoId`),
	KEY `QuizId` (`QuizId`),
	KEY `UserId` (`UserId`),
	KEY `Status` (`Status`),
    UNIQUE KEY `TicketId` (`TicketId`),
	UNIQUE KEY `CurrentStatisticsId` (`CurrentStatisticsId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquizfile` (
  `FileId` int(11) unsigned NOT NULL auto_increment,
  `Content` longblob NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `Group` varchar(255) NOT NULL,
  `Size` int(11) unsigned NOT NULL,
  `Description` varchar(255) default NULL,
  `ShortDescription` varchar(255) default NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` int(11) unsigned NOT NULL default '0',
  `Modified` datetime default NULL,
  `ModifiedBy` int(11) unsigned NOT NULL default '0',
  `Extension` varchar(255) NOT NULL,
  `Height` int(11) unsigned NOT NULL default '0',
  `Width` int(11) unsigned NOT NULL default '0',
  `Flags` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`FileId`),
  KEY `Group` (`Group`),
  KEY `Sorting_ShortDescription` (`Group`(20),`ShortDescription`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_persistance` (
  `OwnerKey` varchar(80) NOT NULL,
  `UserId` int(11) default NULL,
  `Key` varchar(80) NOT NULL,
  `Name` varchar(80) NOT NULL,
  `Value` text NOT NULL,
  UNIQUE KEY `OwnerKey` (`OwnerKey`,`Key`,`UserId`,`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_property` (
  `PropertyId` int(10) unsigned NOT NULL auto_increment,
  `PropertyName` varchar(255) NOT NULL default '',
  `DefaultValue` text,
  `Entity` varchar(255) NOT NULL default '',
  `PropertyType` int(10) unsigned NOT NULL default '0',
  `ResourceKey` varchar(255) NOT NULL default '',
  `ControlType` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`PropertyId`),
  KEY `Entity` (`Entity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_result_scale` (
  `ScaleId` int(10) unsigned NOT NULL auto_increment,
  `ScaleName` varchar(255) NOT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` int(10) unsigned NOT NULL,
  `Modified` datetime default NULL,
  `ModifiedBy` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ScaleId`),
  KEY `ScaleName` (`ScaleName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_result_scale_item` (
  `ScaleItemId` int(10) unsigned NOT NULL auto_increment,
  `ScaleId` int(10) unsigned NOT NULL,
  `BeginPoint` int(10) unsigned NOT NULL,
  `EndPoint` int(10) unsigned NOT NULL,
  `TextTemplateId` int(11) unsigned default NULL,
  `MailTemplateId` int(11) unsigned default NULL,
  `PrintTemplateId` int(11) unsigned default NULL,
  PRIMARY KEY  (`ScaleItemId`),
  KEY `ScaleId` (`ScaleId`),
  KEY `TextTemplateId` (`TextTemplateId`),
  KEY `MailTemplateId` (`MailTemplateId`),
  KEY `PrintTemplateId` (`PrintTemplateId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_property_value` (
  `PropertyId` int(10) unsigned NOT NULL default '0',
  `PropertyValue` text,
  `EntityKey` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `EntityKey` (`EntityKey`,`PropertyId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_export_quiz` (
  `QuizId` int(11) unsigned NOT NULL,
  `ExportResults` tinyint(1) unsigned NOT NULL default '0',
  `ProfileId` int(11) unsigned NOT NULL,
  UNIQUE KEY `QuizId` (`QuizId`,`ProfileId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_export_bankquestion` (
  `QuestionId` int(11) unsigned NOT NULL,
  `ProfileId` int(11) unsigned NOT NULL,
  UNIQUE KEY `QuestionId` (`QuestionId`,`ProfileId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_export` (
  `ProfileId` int(11) NOT NULL auto_increment,
  `ProfileName` varchar(255) NOT NULL default '',
  `ProfileAlias` varchar(30) default NULL,
  `ExportAllQuizzes` tinyint(1) unsigned NOT NULL default '1',
  `ExportAllBankQuestions` tinyint(1) unsigned NOT NULL default '1',
  `ExportQuizzes` tinyint(1) unsigned NOT NULL default '1',
  `ExportBankQuestions` tinyint(1) unsigned NOT NULL default '1',
  `ExportQuizResults` tinyint(1) unsigned NOT NULL default '1',
  `Created` datetime NOT NULL default '0000-00-00 00:00:00',
  `CreatedBy` int(11) unsigned NOT NULL default '0',
  `Modified` datetime default NULL,
  `ModifiedBy` int(11) unsigned default NULL,
  PRIMARY KEY  (`ProfileId`),
  UNIQUE KEY `ProfileAlias` (`ProfileAlias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__ariquiz_question_version_files` (
  `FileId` int(11) unsigned NOT NULL,
  `QuestionVersionId` int(11) unsigned NOT NULL,
  `Alias` varchar(85) NOT NULL default '',
  `QuestionId` int(11) unsigned NOT NULL,
  UNIQUE KEY `Alias` (`Alias`,`QuestionVersionId`),
  KEY `QuestionId` (`QuestionId`),
  KEY `FileId` (`FileId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__ariquiz_export` (`ProfileId`,`ProfileName`,`ProfileAlias`,`ExportAllQuizzes`,`ExportAllBankQuestions`,`ExportQuizzes`,`ExportBankQuestions`,`ExportQuizResults`,`Created`, `CreatedBy`, `Modified`, `ModifiedBy`) VALUES(NULL,'Default','default',1,1,1,1,1,NOW(),0,NULL,NULL)
	ON DUPLICATE KEY UPDATE `ProfileAlias`=`ProfileAlias`;

INSERT INTO `#__arigenerictemplate` (`TemplateId`, `BaseTemplateId`, `TemplateName`, `Value`, `Created`, `CreatedBy`, `Modified`, `ModifiedBy`) VALUES  (1,1,'Base Template','<div align=\"center\"><p>Dear, {$UserName}! You have <span style=\"text-transform: lowercase;\">{$Passed}</span> quiz \'{$QuizName}\'. </p></div> <table border=\"0\" style=\"border: 1px solid #cccccc; width: 100%\"> \t<tbody><tr> \t\t<th class=\"sectiontableheader\" colspan=\"2\" style=\"text-align: center\">Quiz Result</th> \t</tr> \t<tr> \t\t<td style=\"text-align: left; width: 50%; white-space: nowrap\">Result :</td> \t\t<td style=\"text-align: left\">{$UserScore} / {$MaxScore}</td> \t</tr> \t<tr> \t\t<td style=\"text-align: left; white-space: nowrap\">Percentage :</td> \t\t<td style=\"text-align: left\">{$PercentScore} %</td> \t</tr> \t<tr> \t\t<td style=\"text-align: left; white-space: nowrap\">Passed :</td> \t\t<td style=\"text-align: left\">{$Passed}</td> \t</tr> \t<tr> \t\t<td style=\"text-align: left; white-space: nowrap\">Start Date :</td> \t\t<td style=\"text-align: left\">{$StartDate}</td> \t</tr> \t<tr> \t\t<td style=\"text-align: left; white-space: nowrap\">End Date :</td> \t\t<td style=\"text-align: left\">{$EndDate}</td> \t</tr> \t<tr> \t\t<td style=\"text-align: left; white-space: nowrap\">Spent Time :</td> \t\t<td style=\"text-align: left\">{$SpentTime}</td> \t</tr> <tr><td>Passed Percentage :<br /></td><td>{$PassedScore} %<br /></td></tr></tbody></table>','2008-02-10 10:52:47',62,'2008-02-12 09:58:18',62)
	ON DUPLICATE KEY UPDATE BaseTemplateId=BaseTemplateId;

INSERT INTO `#__arigenerictemplatebase` (`BaseTemplateId`, `DefaultValue`, `TemplateDescription`, `Group`) VALUES 
	(1,NULL,'Using for','QuizResult'),
	(2,NULL,'Using for','QuizMailResult')
	ON DUPLICATE KEY UPDATE BaseTemplateId=BaseTemplateId;

INSERT INTO `#__arigenerictemplateparam` (`ParamId`, `BaseTemplateId`, `ParamName`, `ParamDescription`, `ParamType`) VALUES 
	(1,1,'UserName','Display user name',NULL),
	(2,1,'SpentTime','Display spent time',NULL),
	(3,1,'StartDate','Display start date',NULL),
	(5,1,'QuizName','Display quiz name',NULL),
	(6,1,'MaxScore','Display max score',NULL),
	(7,1,'UserScore','Display user score',NULL),
	(8,1,'PercentScore','Display percent score',NULL),
	(9,1,'PassedScore','Display passed score',NULL),
	(10,1,'Passed','Display passed',NULL),
	(11,1,'EndDate','Display end date',NULL),
	(12,2,'UserName','Display user name',NULL),
	(13,2,'SpentTime','Display spent time',NULL),
	(14,2,'StartDate','Display start date',NULL),
	(15,2,'QuizName','Display quiz name',NULL),
	(16,2,'MaxScore','Display max score',NULL),
	(17,2,'UserScore','Display user score',NULL),
	(18,2,'PercentScore','Display percent score',NULL),
	(19,2,'PassedScore','Display passed score',NULL),
	(20,2,'Passed','Display passed',NULL),
	(21,2,'EndDate','Display end date',NULL),
	(22,1,'Email','Display user email',NULL),
	(23,2,'Email','Display user email',NULL),
	(24,1,'ResultsLink','Display link to results page',NULL),
	(25,2,'ResultsLink','Display link to results page',NULL)
	ON DUPLICATE KEY UPDATE BaseTemplateId=BaseTemplateId;

INSERT INTO `#__ariquizquestiontemplate` (`TemplateId`, `TemplateName`, `QuestionTypeId`, `Data`, `Created`, `CreatedBy`, `Modified`, `ModifiedBy`, `DisableValidation`) VALUES 
	(1,'Yes / No',1,'\n<answers>\n\t<answer id=\"4772579e93e2e8.32874767\">Yes</answer>\n\t<answer id=\"4772579e93e5f1.02150736\" correct=\"true\">No</answer>\n</answers>','2007-12-26 13:14:25',62,'2008-02-02 10:39:13',62,1)
	ON DUPLICATE KEY UPDATE TemplateId=TemplateId;

INSERT INTO `#__ariquizquestiontype` (`QuestionTypeId`, `QuestionType`, `ClassName`, `Default`, `CanHaveTemplate`, `TypeOrder`) VALUES 
	  (1,'Single Question','SingleQuestion',1,1,0),
	  (2,'Multiple Question','MultipleQuestion',0,1,0),
	  (3,'Correlation Question','CorrelationQuestion',0,1,0),
	  (4,'Free Text Question','FreeTextQuestion',0,1,0),
	  (5,'HotSpot Question','HotSpotQuestion',0,0,0),
	  (6,'D&D Correlation Question','CorrelationDDQuestion',0,1,0),
	  (7,'Multiple Summing Question','MultipleSummingQuestion',0,0,0)
	ON DUPLICATE KEY UPDATE QuestionType=QuestionType;