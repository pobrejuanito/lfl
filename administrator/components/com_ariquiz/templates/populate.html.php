<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

$totalTime = $processPage->getVar('TotalTime');
?>

<div>
Total Time: <?php echo $totalTime; ?> sec
</div>

<input type="button" value="Populate" onclick="<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('populate$populate')" />
<input type="button" value="Clear" onclick="<?php echo J1_6 ? 'Joomla.submitbutton' : 'submitbutton'; ?>('populate$clear')" />