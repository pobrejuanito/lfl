<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
// no direct access
defined('_JEXEC') or die;
//Load the class
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

?>
<div class="aboutus">
	<div style="overflow: auto; width: 100%; padding-bottom: 30px;"><img src="/templates/yoo_nano/styles/newsostv/images/aboutus/aboutus_title.gif" />
	</div>
	<div style="margin-left: 60px; overflow: auto;"><a href="/about-us.html">
<div class="aboutus_aboutus">
<div class="whois">&nbsp;</div>
</div>
</a><a href="/about-us-must-watch.html">
<div class="aboutus_mustsee">
<div class="mustsee">&nbsp;</div>
</div>
</a><a href="/about-us-must-read.html">
<div class="aboutus_mustread">
<div class="mustread">&nbsp;</div>
</div>
</a><a href="/about-us-faq.html">
<div class="aboutus_faq">
<div class="faq">&nbsp;</div>
</div>
</a>
	</div>
</div>
<div style="padding: 65px 0px 10px 0px;"><img src="/templates/yoo_nano/styles/newsostv/images/aboutus/aboutus_mustlisten_title.gif" ></div>
<div style="height: 4px; background-color: #75d1b5; width:100%"></div>
<p>&nbsp;</p>
<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
// no direct access
defined('_JEXEC') or die;
//Load the class
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::core();
$user =& JFactory::getUser();
// Create some shortcuts
$params		= &$this->item->params;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$tplImgDir  = JURI::base() . "templates/yoo_nano/styles/newsostv/images/";

$app = JFactory::getApplication('site');
?>
<! -- My Path: newsostv/com_content/category/default_articles.php --!>
<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>

<script>
jQuery(document).ready(function($) {

	<?php
		$urls = json_decode($this->items[0]->urls); 
		$seek_time = (isset($urls->start_time) && ($urls->start_time != '')) ? $urls->start_time : 0;
		echo 'var seek_time = ' . $seek_time . ';';
	?>
	var jwplayerid = $("#jwplayerid").attr("playerid");
	jwplayer(jwplayerid).onReady(function(e) {
		jwplayer(jwplayerid).pause();
		jwplayer(jwplayerid).seek(seek_time);
		jwplayer(jwplayerid).play();
	});
	$('a[linktype^="video_links"]').click(function(event) {
		event.preventDefault();
		var seek_time = parseInt($("#"+$(this).attr("parentlink")).attr("seek_time"));
		var jwplayerid = $("#jwplayerid").attr("playerid");
		/* make bold what was clicked */
		$('a[id^="atitle"]').each(function(index) {
		 	$(this).removeClass('jw_category_active_link');
		});
		$("#video_title").html($(this).html());
		$("#"+$(this).attr("parentlink")).addClass('jw_category_active_link');
		/* transfer attribute information to vod buttons*/
		$("#vodbutton_high").attr("file", $("#"+$(this).attr("parentlink")).attr("vod_high_file"));
		$("#vodbutton_high").attr("streamer", $("#"+$(this).attr("parentlink")).attr("vod_high_streamer"));
		$("#vodbutton_high").attr("aid", $("#"+$(this).attr("parentlink")).attr("updateval"));
		$("#vodbutton_low").attr("file", $("#"+$(this).attr("parentlink")).attr("vod_low_file"));
		$("#vodbutton_low").attr("streamer", $("#"+$(this).attr("parentlink")).attr("vod_low_streamer"));
		//$("#vodbutton_audio").attr("file", $("#"+$(this).attr("parentlink")).attr("vod_audio"));
		/* transfer img information to vod buttons */
		$("#down_high_img").attr("src", $("#dhi_"+$("#"+$(this).attr("parentlink")).attr("updateval")).attr("vimg"));
		$("#down_low_img").attr("src", $("#dli_"+$("#"+$(this).attr("parentlink")).attr("updateval")).attr("vimg"));
		//$("#down_audio_img").attr("src", $("#dai_"+$("#"+$(this).attr("parentlink")).attr("updateval")).attr("vimg"));
		/* scroll to the top */
		$("html, body").animate({ scrollTop: 0 }, "slow");
		var idval = $("#"+$(this).attr("parentlink")).attr("updateval");
		//$.post("<?php echo JURI::base(); ?>templates/yoo_nano/styles/newsostv/scripts/sostv.php", { articleid: idval });
		$("#hit_"+idval).html(parseInt($("#hit_"+idval).html()) + 1);
		jwplayer(jwplayerid).load({
			file: $("#"+$(this).attr("parentlink")).attr("vod_low_file"), 
			streamer: $("#"+$(this).attr("parentlink")).attr("vod_low_streamer")
		});

		jwplayer(jwplayerid).pause();
		jwplayer(jwplayerid).seek(seek_time);
		jwplayer(jwplayerid).play();		
	});
	
	$('a[id^="vodbutton"]').click( function() {
		
		if ( $(this).attr('file') !== "javascript:void(0)" ) {
			if ( $(this).attr('type') === "video" ) {
				jwplayer().load({file: $(this).attr('file') + '?' + Math.round(1000 * Math.random()), streamer: $(this).attr('streamer')});
				jwplayer().pause();
				jwplayer().seek(parseInt($("#timer").html()));
				jwplayer().play();
				
			}
		}
	});
	jwplayer().onTime(function(e) {
		$("#timer").html(e.position);
	});
	
	$("#button_share").click(function(e) {
	
		<?php
			
			$current_url = rtrim(JURI::base(),'/').preg_replace('/\?'.$_SERVER['QUERY_STRING'].'/', '', $_SERVER['REQUEST_URI']);
			//$current_url = rtrim(JURI::base(),'/').$_SERVER['REQUEST_URI'];
		?>
		var limit_start = <?php echo (isset($_GET['limitstart']) && ($_GET['limitstart'] != '')) ? $_GET['limitstart'] : 0; ?>;
		var current_url = '<?php echo $current_url; ?>';
		var file = $("#vodbutton_low").attr('file');
		var file_hd = $("#vodbutton_high").attr('file');
		var streamer = $("#vodbutton_high").attr('streamer');
		var aid = $("#vodbutton_high").attr('aid');
		var flashvars = 'file='+file+'&amp;hd.file='+file_hd+'&amp;streamer='+streamer+'&amp;provider=rtmp&amp;height=407&amp;width=712&amp;skin=http://www.sostv.net/plugins/content/plg_jwadvanced/plg_jwadvanced/skin/xml/xero.zip&amp;aboutlink=http://www.sostv.net/about-us.html&amp;abouttext=생애의 빛은 초교파 선교센터로서 미국에서 기독교 정통으로 분류된 독립선교센터 중의 하나이며, 종교개혁을 완성하자는 운동으로 20여 년 전에 시작되었습니다...&amp;'
		var embedcode = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="712" height="407" id="sostvplayer" name="sostvplayer"><param name="movie" value="http://www.sostv.net/plugins/content/plg_jwadvanced/plg_jwadvanced/player-licensed5.swf"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="flashvars" value="'+flashvars+'"><embed id="sostvplayer" name="sostvplayer" src="http://www.sostv.net/plugins/content/plg_jwadvanced/plg_jwadvanced/player-licensed5.swf" width="712" height="407" allowscriptaccess="always" allowfullscreen="true" flashvars="'+flashvars+'" /></object>';
		
		$("#share_embed").val(embedcode);
		$("#share_url").val(current_url+"?limitstart="+limit_start+"&vid="+aid);
		$("#dialog:ui-dialog").dialog("destroy");
		$("#dialog-message").dialog({
			modal: true,
			resizable: false,
			height: 220,
			width: 280,
			buttons: {
				OK: function() {
					$( this ).dialog("close");
				}
			}
		});
	});
	
	$('input[type=text]').click(function(e) {
		$(this).select();
	});
});


</script>

	<?php 
	// share url code
	$displayIndex = 0;
	if ( isset($_GET['vid']) && ($_GET['vid'] != '') ) {
		foreach ( $this->items as $i=>$article ) {
			if ( $article->id === $_GET['vid'] ) {
				$displayIndex = $i;
				break;
			}
		}
	}
	?>
	<?php 
		$urls = json_decode($this->items[$displayIndex]->urls); 
		if ( $urls->urla != '') {
			$urla = str_replace("http://tvdown.sostvnetwork.com/","",str_replace("http://netdown.sostvnetwork.com/", "", $urls->urla));
			$imga = '';
		} else {
			$urla = "javascript:void(0)";
			$imga = '_dim';
		}
		if ( $urls->urlb != '') {
			$urlb = str_replace("http://tvdown.sostvnetwork.com/","",str_replace("http://netdown.sostvnetwork.com/", "", $urls->urlb));
			$imgb = '';
		} else {
			$urlb = "javascript:void(0)";
			$imgb = '_dim';
		}
		if ( $urls->urlc != '') {
			$urlc = $urls->urlc;
			$imgc = '';
		} else {
			$urlc = "javascript:void(0)";
			$imgc = '_dim';
		}
	?>

	
	<!-- SHOW VOD DOWNLOAD BUTTONS -->
	<div style="position: relative; top: 390px; left: -82px; z-index: 999; width:75px; display:none">
		<div>
			<a id="vodbutton_high" href="javascript:void(0)" type="video" aid="<?php echo $this->items[$displayIndex]->id ?>" file="<?php echo $urla ?>" streamer="<?php echo $urls->rtmp_streamer ?>">
			<img id="down_high_img" src="<?php echo $tplImgDir; ?>button-vod-high<?php echo $imga; ?>.png"></a>
		</div>
		<div>
			<a id="vodbutton_low" href="javascript:void(0)" type="video" file="<?php echo $urlb ?>" streamer="<?php echo $urls->rtmp_streamer ?>">
			<img id="down_low_img" src="<?php echo $tplImgDir; ?>button-vod-low<?php echo $imgb; ?>.png"></a>
		</div>
		<div>
			<a id="button_share" href="javascript:void(0)">
				<img id="button_share_img" src="<?php echo $tplImgDir; ?>button-share.png">
			</a>
		</div>
	</div>
	<div style="position: relative; left: 80px">
	<?php echo $this->items[$displayIndex]->introtext; ?>
	<div class="sermon-crucial"></div>
	<div style="width: 100%; text-align:center; position: relative; top: -190px; left: -80px">
		<div>
			<!-- SHOW CATEGORY & DESCRIPTION -->
			<?php if ($this->params->get('show_category_title', 1)) : ?>
				<div id="video_title" class="jw_category_title">
				<?php echo $this->items[$displayIndex]->title;?>
				<?php //echo $app->getUserState('countryCode'); ?>
				</div>
			<?php endif; ?>
			<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) :?>
				<div class="jw_category_description">
					<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
						<img src="<?php echo $this->category->getParams()->get('image'); ?>" 
							alt="<?php echo $this->category->getParams()->get('image'); ?>" class="size-auto align-right" />
					<?php endif; ?>
					<?php if ($this->params->get('show_description') && $this->category->description) 
							echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- SHOW ARTICLE LIST RELATED TO THIS CATEGORY -->
	<form style="width: 960px; position: relative; top: -170px; left: -60px; clear:left;" action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">	
		<table class="zebra" border="0" cellspacing="0" cellpadding="0"	>
	
			<?php if ($this->params->get('show_headings')) : ?>
			<thead>
				<tr>
					<th align="left"><?php  echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder) ; ?></th>
					<?php if ($date = $this->params->get('list_show_date')) : ?>
					<th align="left" width="25%">
						<?php if ($date == "created") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.created', $listDirn, $listOrder); ?>
						<?php elseif ($date == "modified") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.modified', $listDirn, $listOrder); ?>
						<?php elseif ($date == "published") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
						<?php endif; ?>
					</th>
					<?php endif; ?>
					<th>열람</th>
					<th>다운로드</th>
					<!--
					<?php //if ($this->params->get('list_show_hits', 1)) : ?>
					<th align="center" width="5%"><?php  //echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
					</th>
					<?php// endif; ?>
					-->
				</tr>
			</thead>
			<?php endif; ?>
			<tbody>
				<?php $isfirst=0;?>
				<?php foreach ($this->items as $i => $article) : ?>
	
				<?php 
				$urls = json_decode($article->urls);

				if ( $urls->urla != '') {
					$urla = str_replace("http://tvdown.sostvnetwork.com/","",str_replace("http://netdown.sostvnetwork.com/", "", $urls->urla));
					$imga = '';
				} else {
					$urla = "javascript:void(0)";
					$urls->urla = "javascript:void(0)";
					$imga = '_dim';
				}
				if ( $urls->urlb != '') {
					
					$urlb = str_replace("http://tvdown.sostvnetwork.com/","",str_replace("http://netdown.sostvnetwork.com/", "", $urls->urlb));
					$imgb = '';
				} else {
					$urlb = "javascript:void(0)";
					$urls->urlb = "javascript:void(0)";
					$imgb = '_dim';
				}
				if ( $urls->urlc != '') {
					$urlc = $urls->urlc;
					$imgc = '';
				} else {
					$urlc = "javascript:void(0)";
					$urls->urlc = "javascript:void(0)";
					$imgc = '_dim';
				}
				if ( isset($urls->start_time) ) {
					$seek_time = $urls->start_time;
				} else {
					$seek_time = 0;
				}
				?>
				<tr class="<?php if ($i % 2 == '0') { echo 'odd'; } else { echo 'even'; } ?>">
					<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
						<td>
							<img style="padding: 0px 10px 0px 10px;" src="<?php echo $tplImgDir; ?>list-style-bulet.png">
							<a linktype="video_links"
								vod_high_file="<?php echo $urla ?>"
								vod_high_streamer="<?php echo $urls->rtmp_streamer; ?>"
								vod_low_file="<?php echo $urlb; ?>"
								vod_low_streamer="<?php echo $urls->rtmp_streamer; ?>" 
								vod_audio="<?php echo $urlc; ?>" 
								updateval="<?php echo $article->id; ?>"
								parentlink="atitle_<?php echo $article->id; ?>" 
								seek_time="<?php echo $seek_time ?>"
								id="atitle_<?php echo $article->id; ?>"
								href="javascript:void(0)"
								<?php 
								// bold the first video in the list
								if ( $isfirst==0 && $displayIndex==0) {
									echo 'class="jw_category_active_link"';
								// bold the share url video in the list
								} elseif ( $displayIndex == $i ) {
									echo 'class="jw_category_active_link"';
								} else {
									echo '';
								}
								?>
								onClick="jwplayer().load({file: '<?php echo $urlb ?>', streamer: '<?php echo $urls->rtmp_streamer ?>'})"
							>
								<?php echo $this->escape($article->title); ?>
							</a>
							<?php if ($article->params->get('access-edit')) echo JHtml::_('icon.edit', $article, $params); ?>
						</td>
						<td align="center">
						<a linktype="video_links" parentlink="atitle_<?php echo $article->id; ?>" href="javascript:void(0)"
							onClick="jwplayer().load({file: '<?php echo $urlb ?>', streamer: '<?php echo $urls->rtmp_streamer ?>'})" >
							<img src="<?php echo $tplImgDir; ?>button-list-replay.png"></a>
						</td>
						<td align="center">
						<a href="<?php echo $urls->urla ?>"><img id="dhi_<?php echo $article->id; ?>" vimg="<?php echo $tplImgDir; ?>button-vod-high<?php echo $imga; ?>.png" src="<?php echo $tplImgDir; ?>button-list-hd<?php echo $imga; ?>.png"></a>&nbsp; 
						<a href="<?php echo $urls->urlb ?>"><img id="dli_<?php echo $article->id; ?>" vimg="<?php echo $tplImgDir; ?>button-vod-low<?php  echo $imgb; ?>.png" src="<?php echo $tplImgDir; ?>button-list-sd<?php echo $imgb; ?>.png"></a>&nbsp; 
						<a href="<?php echo $urls->urlc ?>"><img id="dai_<?php echo $article->id; ?>" vimg="<?php echo $tplImgDir; ?>button-vod-mp3<?php  echo $imgc; ?>.png" src="<?php echo $tplImgDir; ?>button-list-mp3<?php echo $imgc; ?>.png"></a>&nbsp;
						</td>		
						<!--
						<?php //if ($this->params->get('list_show_hits', 1)) : ?>
						<td id="hit_<?php //echo $article->id; ?>" align="center"><?php //echo $article->hits; ?></td>
						<?php //endif; ?>
						-->
					<?php else : // Show unauth links ?>
					
						<td colspan="4">
							<?php
								echo $this->escape($article->title).' : ';
								$menu		= JFactory::getApplication()->getMenu();
								$active		= $menu->getActive();
								$itemId		= $active->id;
								$link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$itemId);
								$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug));
								$fullURL = new JURI($link);
								$fullURL->setVar('return', base64_encode($returnURL));
							?>
							<a href="<?php echo $fullURL; ?>"><?php echo JText::_( 'COM_CONTENT_REGISTER_TO_READ_MORE' ); ?></a>
						</td>
						
					<?php endif; ?>
				</tr>
				<?php $isfirst++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
	</form>
	</div>
	<div id="dialog-message" title="공유하기" style="display: none">
	<p>
		<label for="name">Embed Code</label><br/>
		<input type="text" name="embed" id="share_embed" style="width:250px" class="text ui-widget-content ui-corner-all" />
	</p>
	<p>
		<label for="url">Video URL</label><br/>
		<input type="text" name="url" id="share_url" style="width:250px" class="text ui-widget-content ui-corner-all" />
	</p>
	</div>
	<div id="timer" style="display: none"></div>
	<?php endif; ?>
