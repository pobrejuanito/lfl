<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load( 'plg_user_profile', JPATH_ADMINISTRATOR);
?>

<style>
  #jform_sex
  {
  margin: 10px 0 0 0 !important;
  border: 0;
  }

  .font_orange {
  line-height: 20px;
  }

</style>

<div id="system">

  <img src="/images/register/title_register_correct.png" />
  <img src="/images/register/hr.png" class="hr" />

  <ul class="reg_items_notice">
    <li>
      <span class="font_orange">회원님의 정보 중 변경된 내용이 있는 경우, 아래에서 수정해 주세요.<br />
      </span>
    </li>
  </ul>
  
  <?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
	<form id="form_reg_form"  class="submission box style" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" enctype="multipart/form-data">
		
    
    <?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)): ?>
				<fieldset style="padding:0; border-left:0; border-right:0; border-bottom:0;">
          
          
					<?php if (isset($fieldset->label)): ?>
					<!--<legend><?php echo JText::_($fieldset->label); ?></legend>-->
					<?php endif;?>
					<?php foreach ($fields as $field): ?>
						<?php if ($field->hidden): ?>
							<?php echo $field->input; ?>
						<?php else: ?>


          <table cellpadding="0" cellspacing="0" border="0" class="table_reg_form">
            <tr>
              <td class="td_reg_label">
                <span style="font-weight:normal;">></span>&nbsp;&nbsp;
                <?php echo $field->label; ?>
              </td>
              <td class="td_reg_input">
                <?php echo $field->input; ?>
              </td>
              <td>
                
								<?php if (!$field->required && $field->type!='Spacer'): ?>
									<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
								<?php endif; ?>
              </td>
            </tr>
          </table>
					<?php endif; ?>
					<?php endforeach; ?>
          
          
          
				</fieldset>
			<?php endif; ?>
		<?php endforeach; ?>
    <br /><br />
		<div class="submit">
			<!--<button class="validate" type="submit"><?php echo JText::_('JSUBMIT'); ?></button>-->
      <input class="center" type="image" src="/templates/yoo_nano/styles/newsostv/images/button-register-correct.png" border="0" />
		</div>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="profile.save" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>