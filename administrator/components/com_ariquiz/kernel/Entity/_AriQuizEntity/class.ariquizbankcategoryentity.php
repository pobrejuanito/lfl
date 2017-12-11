<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Entity._AriQuizEntity.Base.AriQuizCategoryEntityBase');

class AriQuizBankCategoryEntity extends AriQuizCategoryEntityBase
{
	function AriQuizBankCategoryEntity(&$_db)
	{
		$this->AriQuizCategoryEntityBase($_db, '#__ariquizbankcategory');
	}
}
?>