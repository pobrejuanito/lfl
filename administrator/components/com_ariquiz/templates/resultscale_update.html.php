<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/resultScale.base.html.php';

$scaleId = $processPage->getVar('scaleId');
?>
<input type="hidden" name="scaleId" id="scaleId" value="<?php echo $scaleId; ?>" />