<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Controllers.ControllerBase');
AriKernel::import('Data.DDLManager');
AriKernel::import('Xml.SimpleXml');
AriKernel::import('Data.Export._Templates.ExportTemplates');

class AriExportDataController extends AriControllerBase 
{
	var $_xmlDoc;
	var $_recordsNode;
	var $_ddlManager;
	var $_outputEncoding;
	
	function __construct($configFile, $outputEncoding = 'UTF-8')
	{
		$this->_outputEncoding = strtoupper($outputEncoding);
		$this->_ddlManager = new AriDDLManager($configFile);
		$this->_xmlDoc = $this->_createXmlDoc();
	}
	
	function _createXmlDoc()
	{
		$xmlHandler = new AriSimpleXML();
		$xmlHandler->loadString(sprintf(ARI_DATA_EXPORT_TEMPLATE, 
			$this->_ddlManager->getVersion(),
			$this->_outputEncoding));
		$xmlDoc = $xmlHandler->document;
		
		return $xmlDoc;
	}
	
	function _getDBStructure($configFile)
	{
		return AriDDLConfigParser::parse($configFile);
	}
	
	function &_getRecordsNode()
	{
		if (!is_null($this->_recordsNode)) $this->_recordsNode;
		
		$tagName = 'records';
		$recordsNode =& $this->_xmlDoc->$tagName;
		$recordsNode =& $recordsNode[0];
		$this->_recordsNode =& $recordsNode;

		return $this->_recordsNode;
	}
	
	function addRecordsGroup($query, $entityName, $overrideValues = array())
	{
		$database =& JFactory::getDBO();

		$database->setQuery($query);
		$records = $database->loadAssocList();
		if ($database->getErrorNum())
		{
			trigger_error('ARI: Couldnt get records for export.', E_USER_ERROR);
			return false;
		}

		if (!$records) return true;
		
		$xmlNode =& $this->_getRecordsNode();
		
		foreach ($records as $record)
		{
			$recordNode =& $xmlNode->addChild($entityName);
			foreach ($record as $field => $value)
			{
				if (isset($overrideValues[$field])) $value = $overrideValues[$field];
				$fieldNode =& $recordNode->addChild($field);
				if (is_null($value))
				{
					$fieldNode->addAttribute('isNull', 'true');
				}
				else
				{
					if ($value && $this->_ddlManager->getFieldProperty($entityName, $field, 'systemType', 'string') == 'string') $value = '0x' . AriString::strToHex($value);
					$fieldNode->setData($value);
				}
			}
		}

		return true;
	}
	
	function getExportXml()
	{
		return $this->_xmlDoc->toString();
	}
}
?>