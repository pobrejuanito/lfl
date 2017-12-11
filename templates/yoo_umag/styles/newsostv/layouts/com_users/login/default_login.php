<style>
  #page-background
  {
    background:url(/images/register/banner-login-top.jpg) no-repeat;
    background-position:center top;
  }
  
  .mod-line p
  {
  	line-height:12px !important;
  }
  
  .fl_login input
  {
  		width: 90px !important;
		height: 21px;
		border-style: none;
		background: url(/templates/yoo_nano/styles/newsostv/images/userpass-form.png) no-repeat; 
  }
  
  .fl_login input
  {
  		margin-top:5px;
  }
  
  .fl_login div
  {
  	margin: 5px 0 !important;
  }
  
  .fl_login
  {
  	float:left;
	margin:5px 0 !important;
  }
  
  .submit_button
  {
  	
  }
  
  form.submission
  {
  	margin: 124px 0 0 57px;
  }
  
  #system-message-container
  {
  	float:left;
  }
</style>

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
	
?>

<div id="system" style="padding:10px 0;">
	
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	<div class="description">
		<?php if ($this->params->get('login_image')) : ?>
			<img src="<?php $this->escape($this->params->get('login_image')); ?>" alt="<?php echo JText::_('COM_USER_LOGIN_IMAGE_ALT')?>" class="size-auto" />
		<?php endif; ?>
		<?php if ($this->params->get('logindescription_show')) echo $this->params->get('login_description'); ?>
	</div>
	<?php endif; ?>

	<form class="submission small style" action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
		
		<fieldset class="fl_login">
        <table cellpadding="0" cellspacing="0" border="0">
                <tr>
			<?php foreach ($this->form->getFieldset('credentials') as $field): ?>
				<?php if (!$field->hidden): ?>
                
					<td><?php echo $field->label; ?><br /><?php echo $field->input; ?></td>
                
				<?php endif; ?>
			<?php endforeach; ?>
             </tr>
             </table>
		</fieldset>
		
		<div style="float: left; margin-top: 23px;">
			<!--<button type="button" class="submit_button"><?php echo JText::_('JLOGIN'); ?></button>-->
            <input type="image" src="/templates/yoo_nano/styles/newsostv/images/button-login.png"></input>
		</div>	

		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>

	<ul style="margin-left: 59px; margin-top: 188px; line-height: 20px; list-style:none;">
		<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a></li>
		<?php $usersConfig = JComponentHelper::getParams('com_users'); ?>
		<?php if ($usersConfig->get('allowUserRegistration')) : ?>
		<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a></li>
		<?php endif; ?>
	</ul>

 <!-- login end -->
  
  
  <section id="bottom-b" style="margin-top:155px;">
    <div class="grid-block">
      <div class="grid-box width24 grid-h" style="width: 225px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="http://www.kingsm.net/" target="_blank">
              <strong>
                <img style="margin-right: 10px; float: left;" alt="icon-naver-cafe" src="/images/main/icon-naver-cafe.png" width="87" height="83">
                  <span style="color: #000000;">네이버 카페</span>
              </strong>
            </a>
          </p>
          <p style="text-align: justify;">
            <a href="http://www.kingsm.net/" target="_blank">성경질문과 신앙상담 그리고 따뜻한 나눔이 있는 온라인 커뮤니티</a>
          </p>

        </div>
      </div>
      <div class="grid-box width24 grid-h" style="width: 225px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="/bible-cafe-info.html">
              <img style="margin-right: 10px; float: left;" src="/images/main/icon-bible-cafe.png" alt="icon-bible-cafe" width="87" height="85">
                <span style="color: #000000;">
                  <strong>바이블 카페</strong>
                </span>
            </a>
          </p>
          <p style="text-align: left;">
            <a href="/bible-cafe-info.html">언제든지 자유롭게 방문하여 편안한 교제와 성경공부를 할 수 있는 오프라인 공간!</a>
          </p>

        </div>
      </div>
      <div class="grid-box width24 grid-h" style="width: 225px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="/bible-study.html" target="_self">
               <img style="margin-right: 10px; float: left;" alt="icon-biblestudy" src="/images/main/icon-biblestudy.png" width="87" height="83">
              <span style="font-size: 8pt;">
                <strong>
                  <span style="color: #000000;" color="#000000">성경 연구 자료</span>
                </strong>
              </span>
            </a>
          </p>
          <p style="text-align: left;">
            <span style="font-size: 8pt;">
              <a href="/bible-study.html" target="_self">
                성경을 연구하거나 강의할 때 필요한 다양한 강의 PPT를 제공합니다.
              </a>
              </span>
          </p>

        </div>
      </div>
      <div class="grid-box width27 grid-h" style="width: 265px; ">
        <div class="module mod-line  deepest" style="min-height: 90px; ">


          <p>
            <a href="/mobile-info.html" target="_self">
              &nbsp;<img style="margin-right: 10px; float: left;" alt="icon-mobile-app" src="/images/main/icon-mobile-app.png" width="128" height="88">
                <span style="color: #000000;">
                  <strong>모바일 앱 다운로드</strong>
                </span>
            </a>
          </p>
          <p style="text-align: left;">
            <a href="/mobile-info.html" target="_self">이제 생애의 빛 SOS
            TV 방송을 스마트폰
            에서도 시청하실 수
            있습니다.</a>
          </p>

        </div>
      </div>
    </div>
  </section>


</div>