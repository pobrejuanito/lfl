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
<?php if ($type == 'logout') : ?>
	<form class="short style" action="/index.php" method="post"  style="margin:0px; padding:0px">
		<?php if ($params->get('greeting')) : ?>
		<div class="greeting" style="margin:0px; padding: 5px 5px 5px 5px">
			<?php if ($params->get('name') == 0) : {
				echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
			} else : {
				echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('username'));
			} endif; ?>
			| <a href="<?php echo JURI::base() ?>component/users/profile.html?layout=edit">내정보</a>
			<button value="<?php echo JText::_('JLOGOUT'); ?>" name="Submit" type="submit"><?php echo JText::_('JLOGOUT'); ?></button>
		</div>
		<?php endif; ?>
		<ul class="logged">
			<li><a href="/sermon-and-seminar/sermon42/pastor-seminar.html" class="link1">&nbsp;</a></li>
			<li><a href="/bible-study.html" class="link2">&nbsp;</a></li>
			<li><a href="/askbible.html" class="link3">&nbsp;</a></li>
			<li><a href="/media_mobile_background.html" class="link4">&nbsp;</a></li>
		</ul>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>	
	</form>
	<div style="margin-bottom:46px"></div>
<?php else : ?>
	<div style="text-align: center;">
		<form name="mlogin" action="/index.php" method="post">
			<div class="username">
				<input class="textfield" type="text" name="username" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
			</div>
			<div class="password">
				<input class="textfield" type="password" name="password" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
			</div>
			<div class="button">
				<a href="javascript:void(0)" onclick="document.mlogin.submit()"><img src="<?php echo JURI::base() ?>templates/yoo_nano/styles/newsostv/images/button-login.png"></a>
			</div>
			
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="remember">
				<?php $number = rand(); ?>
				<input id="modlgn-remember-<?php echo $number; ?>" type="checkbox" name="remember" value="yes" checked />
				<label for="modlgn-remember-<?php echo $number; ?>"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
			</div>
			<?php endif; ?>
			
			<div class="logintools">
				<ul>
					<li class="regist_form">
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
 | 
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
					<?php
					$usersConfig = JComponentHelper::getParams('com_users');
					if ($usersConfig->get('allowUserRegistration')) : ?>
 | 
 						<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<?php if($params->get('posttext')) : ?>
			<div class="posttext">
				<?php echo $params->get('posttext'); ?>
			</div>
			<?php endif; ?>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
	<script>
		jQuery(function($){
			$('form.login input[placeholder]').placeholder();
		});
	</script>
	
<?php endif; ?>
