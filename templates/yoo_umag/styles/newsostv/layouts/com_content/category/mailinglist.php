<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::core();

// Create some shortcuts
$params		= &$this->item->params;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$newsletterid = (isset($_GET['newsletterid']))? $_GET['newsletterid'] : -1;
$img_path = JURI::base()."templates/yoo_nano/styles/newsostv/images/";

function Truncate($string, $length, $stopanywhere=false) {
    //truncates a string to a certain char length, stopping on a word if not specified otherwise.
    if (strlen($string) > $length) {
        //limit hit!
        $string = substr($string,0,($length -3));
        if ($stopanywhere) {
            //stop anywhere
            $string .= '...';
        } else{
            //stop on a word.
            $string = substr($string,0,strrpos($string,' ')).'...';
        }
    }
    return $string;
}

?>

<div style="float: left">
<div class="header_style"><img style="padding: 0px 3px 2px 0px;" src="<?php echo $img_path; ?>title-bulet.png"> 메일링서비스 이미지</div>
<?php
if ( !isset($_GET['limitstart']) || !isset($_GET['newsletterid']) ) {
	echo '<div id="newsletter_text">'.$this->items[0]->introtext.'</div>';
} else {
	foreach( $this->items as $aindex => $article ) {
		if ( $article->id == $_GET['newsletterid'] ) {
			echo '<div id="newsletter_text">'.$article->introtext.'</div>';
			break;
		}
	}
}
?>
</div>
<div style="float: right; padding-right: 15px;">
<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>
	<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">

		<?php if (($this->params->get('filter_field') != 'hide') || $this->params->get('show_pagination_limit')) :?>
		<div class="filter">

			<?php if ($this->params->get('filter_field') != 'hide') :?>
			<div>
				<label for="filter-search"><?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL'); ?></label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
			</div>
			<?php endif; ?>

			<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div>
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>

		<table border="0" cellspacing="0" cellpadding="0" class="mailing_list">
			<thead>
				<tr style="border-bottom: black solid 1px;">
					<th class="header_style"><img style="padding: 0px 3px 2px 0px;" src="<?php echo $img_path ?>title-bulet.png"> 메일링서비스 리스트</div></th>
				</tr>
			</thead>
			<tbody>
				<?php $isFirst = true; ?>
				<?php foreach ($this->items as $i => $article) : ?>
				<tr>
					<td>
					<img style="padding-right: 5px;" src="<?php echo $img_path; ?>list-style-red-bullet.png">
						<?php
							if ( ($newsletterid === $article->id) || (($newsletterid < 0) && $isFirst) ) {
								echo '<strong>'.Truncate($this->escape($article->title), 45).'</strong>';
								$isFirst = false;
						      	} else { ?>
						<a href="<?php echo JURI::current(); ?>?limitstart=<?php echo (isset($_GET['limitstart'])) ? $_GET['limitstart'] : "0"; ?>&newsletterid=<?php echo $article->id; ?>"><?php echo Truncate($this->escape($article->title), 45); ?></a>
						<?php } ?>
					</td>


				</tr>
				<?php endforeach; ?>

			</tbody>

		</table>
		<div class="custom_pager">
		<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
		<?php endif; ?>
		</div>
		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
	</form>
	<div class="header_style" style="padding-top: 50px; width: 100%;  line-height: 0px;">메일링서비스 신청 <img style="padding: 0px 0px 3px 4px;" src="<?php echo $img_path; ?>title-bulet.png"><hr style="padding-top: 0px;" /></div>
	<div style="text-align:center;">
	<div style="line-height: 18px;">"메일링 서비스를 신청하세요!<br/>매주 다채롭고 특별한 메시지를<br/>여러분의 이메일로 받으실 수 있습니다."</div>
	<p><input type="text" id="subscribe_email" name="subscribe_email" class="textfield_large" placeholder="메일 주소를 입력하세요"></p>
	<p><img id="send_email" src="<?php echo $img_path ?>button-letter-order.png" style="padding-left: 10px; position: relative; top: 10px;" ></p>
	</div>
<?php endif; ?>
</div>
<p><img src="<?php echo $img_path; ?>seperator.png"></p>
<!--
<p>
<div style="text-align: center; width: 700px">
열람한 메일링을 여러사람과 나누세요!
<div>
<input id="recipient_email" type="text" class="textfield_large" placeholder="메일 주소를 입력하세요">
<img id="send_newsletter" src="<?php echo $img_path ?>button-letter-share.png" style="padding-left: 10px; position: relative; top: 10px;" >
</div>
</div>
</p>
-->
<script>
jQuery(document).ready(function($) {

	$("#send_email").click(function() {

		var email_validated = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( !emailReg.test( $('#recipient_email').val() ) ) {
			email_validated = false;
		} else {
			email_validated = true;
		}
		if ( $('#subscribe_email').val() != '' && email_validated ) {
			var data = {
				email: $('#subscribe_email').val(),
			};
			$.post( '<?php echo JURI::base() ?>/templates/yoo_nano/styles/newsostv/scripts/sostv.php',
				data,
				function(data) {
					if ( data === "OK" ) {

						$( "#dialog:ui-dialog" ).dialog( "destroy" );

						$( "#dialog-message" ).dialog({
							modal: true,
							resizable: false,
							buttons: {
								OK: function() {
									$( this ).dialog( "close" );
								}
							}
						});

						$('#subscribe_email').val('');
					} else {

						$( "#dialog:ui-dialog" ).dialog( "destroy" );

						$( "#dialog-message-error" ).dialog({
							modal: true,
							resizable: false,
							buttons: {
								OK: function() {
									$( this ).dialog( "close" );
								}
							}
						});

						$('#subscribe_email').val('');
					}
				}
			);

		} else {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
				$( "#dialog-invalid-email" ).dialog({
					modal: true,
					resizable: false,
					buttons: {
						OK: function() {
							$( this ).dialog( "close" );
						}
					}
			});
		}
	});
	$("#send_newsletter").click(function() {

		var email_validated = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( !emailReg.test( $('#recipient_email').val() ) ) {
			email_validated = false;
		} else {
			email_validated = true;
		}

		if ( $('#recipient_email').val() != '' && email_validated ) {
			var parameters = {
				recipient_email: $('#recipient_email').val(),
				newsletter: $('#newsletter_text').html()
			};
			$.post( '<?php echo JURI::base() ?>/templates/yoo_nano/styles/newsostv/scripts/sostv.php',
				parameters,
				function(data) {
					if ( data === "OK" ) {

						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						$( "#dialog-subscription-sent" ).dialog({
							modal: true,
							resizable: false,
							buttons: {
								OK: function() {
									$( this ).dialog( "close" );
								}
							}
						});
					}
					$('#recipient_email').val('');
				}
			);
		} else {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
				$( "#dialog-invalid-email" ).dialog({
					modal: true,
					resizable: false,
					buttons: {
						OK: function() {
							$( this ).dialog( "close" );
						}
					}
			});
		}
	});
})
</script>
<div id="dialog-message" title="신청 성공" style="display: none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		신청해 주셔서 감사합니다!
	</p>
	<p>매주 새로운 말씀을 받아 보시기 바랍니다.</p>
</div>
<div id="dialog-message-error" title="신청 오류" style="display: none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Opps!
	</p>
	<p>There was something wrong with your request.  Please try again or contact us at sostvcall@hotmail.com</p>
</div>
<div id="dialog-subscription-sent" title="Subscription Sent" style="display: none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		메일이 정상적으로 보내 졌습니다.
	</p>
</div>
<div id="dialog-invalid-email" title="Opps! 이메일 주소가 잘못되었습니다" style="display: none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		올바른 이메일 주소를 제공해 주시기 바랍니다.
	</p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>