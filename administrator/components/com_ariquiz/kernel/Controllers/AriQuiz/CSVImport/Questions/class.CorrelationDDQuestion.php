<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/class.CorrelationQuestion.php';

class AriQuizCSVImportCorrelationDDQuestion extends AriQuizCSVImportCorrelationQuestion
{
	var $_type = 'CorrelationDDQuestion';
}
?>