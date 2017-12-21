<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Entity._AriQuizEntity.Base.AriQuizCategoryEntityBase');

class AriQuizCategoryEntity extends AriQuizCategoryEntityBase
{
	function AriQuizCategoryEntity(&$_db)
	{
		$this->AriQuizCategoryEntityBase($_db, '#__ariquizcategory');
	}
}
?>