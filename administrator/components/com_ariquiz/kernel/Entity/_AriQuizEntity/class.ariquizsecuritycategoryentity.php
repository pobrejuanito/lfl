<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Entity._AriQuizEntity.Base.AriQuizCategoryEntityBase');

class AriQuizSecurityCategoryEntity extends AriQuizCategoryEntityBase
{
	function AriQuizSecurityCategoryEntity(&$_db)
	{
		$this->AriQuizCategoryEntityBase($_db, '#__ariquiz_security_category');
	}
}
?>