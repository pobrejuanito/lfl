<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.JSON.JSONHelper');

class AriPaginatorControl extends AriObject
{
	var $id;
	var $_options = array(
		'alwaysVisible' => true,
		'containers' => null,
		'containerClass' => 'yui-pg-container',
		'initialPage' => 1,
		'pageLinksStart' => 1,
		'recordOffset' => 0,
		'firstPageLinkLabel' => null, // << first
		'lastPageLinkLabel' => null, // last >>
		'nextPageLinkLabel' => null, // next >
		'previousPageLinkLabel' => null, // < prev
		'pageReportTemplate' => null, //'({currentPage} of {totalPages})'
		'rowsPerPageDropdownClass' => 'text_area',
		'rowsPerPage' => 10,
		'template' => 'Display#: {RowsPerPageDropdown} {FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink} {CurrentPageReport}',
		'totalRecords' => 0,
		'updateOnChange' => false,
		'rowsPerPageOptions' => array(5, 10, 15, 20, 25, 30, 50, 100)
	);

	function __construct($options = null)
	{
		$this->id = uniqid('pag');
		$this->_bindResources();
		$this->bindPropertiesToProperty($options, $this->_options);
	}
	
	function _bindResources()
	{
		$this->bindPropertiesToProperty(
			array(
				'firstPageLinkLabel' => AriWebHelper::translateResValue('Controls.DTFirstPage'),
				'lastPageLinkLabel' => AriWebHelper::translateResValue('Controls.DTLastPage'),
				'nextPageLinkLabel' => AriWebHelper::translateResValue('Controls.DTNextPage'),
				'previousPageLinkLabel' => AriWebHelper::translateResValue('Controls.DTPrevPage'),
				'pageReportTemplate' => AriWebHelper::translateResValue('Controls.DTPageReportTemplate'),
				'template' => AriWebHelper::translateResValue('Controls.DTTemplate')),
			$this->_options);
	}
	
	function getDef()
	{
		return 'new YAHOO.widget.Paginator(' . AriJSONHelper::encode($this->_options) . ')';
	}
}
?>