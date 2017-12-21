<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.mootools');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<div id="system" style="padding: 20px 0;">

  <img src="/images/register/title_register.png" />
  <img src="/images/register/banner-top.jpg" class="hr" />



  <ul class="reg_items">
    <li>목회자 세미나</li>
    <li>목회 자료실(각종 강의 PPT/찬송가 PPT 등)</li>
    <li>일반 자료실(컴퓨터 바탕화면/스마트폰 배경화면/낭독 및 음악 MP3 등)</li>
    <li>성경 연구 (주제별 성경연구/안식일 연구/문답식 성경 연구)</li>
    <li>가정의 회복과 참신앙의 길을 안내하는 월간지를 무료로 받아보실 수 있습니다.</li>
  </ul>
  
  <img src="/images/register/hr.png" class="hr" />
  
  
  



  <ul class="reg_items_notice">
    <li>
      <span class="font_orange">아래 항목은 필수사항이오니 빠짐없이 입력해주셔야 회원가입이 가능합니다.</span>
    </li>
  </ul>
  

	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
  
	<form id="form_reg_form" class="submission small style" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post">
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name); ?>
			<?php if (count($fields)): ?>
				<fieldset>
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
                <?php if (!$field->required && $field->type != 'Spacer'): ?>
                <span class="optional">
                  <?php echo JText::_('COM_USERS_OPTIONAL');?>
                </span>
                <?php endif; ?>
              </td>
            </tr>
          </table>

          
          
          
					<?php endif; ?>
					<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>
		<?php endforeach; ?>

		<div>
			<!--<button class="validate submit_button" type="submit"><?php echo JText::_('JREGISTER'); ?></button>-->
      <input class="center" type="image" src="/templates/yoo_nano/styles/newsostv/images/button-register.png" border="0" />
    </div>
		
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="registration.register" />
		<?php echo JHtml::_('form.token');?>
		
	</form>

</div>