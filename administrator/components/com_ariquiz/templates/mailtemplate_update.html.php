<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

require_once dirname(__FILE__) . '/base/mailTemplate.base.html.php';

$mailTemplateId = $processPage->getVar('mailTemplateId');
?>

<input type="hidden" id="mailTemplateId" name="mailTemplateId" value="<?php echo $mailTemplateId; ?>" />