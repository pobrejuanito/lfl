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
$tplImgDir  = JURI::base() . "templates/yoo_nano/styles/newsostv/images/";
$tplJsDir = JURI::base(). "templates/yoo_nano/styles/newsostv/js/";
?>
<! -- My Path: newsostv/com_content/category/default_articles.php --!>


<! -- jplayer javascripts --!>

 <script type="text/javascript" src="<?php echo $tplJsDir;?>jquery.jplayer.min.js"></script>
<link type="text/css" href="<?php echo $tplJsDir;?>skin/jplayer.blue.monday.css" rel="stylesheet" />



<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>

	<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	
		<?php if (($this->params->get('filter_field') != 'hide') || $this->params->get('show_pagination_limit')) :?>
		<div class="filter" style="margin:7px;">
		
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
	
		<table class="zebra" border="0" cellspacing="0" cellpadding="0" style="width:670px; margin:7px;">
	
			<?php if ($this->params->get('show_headings')) : ?>
			<thead>
				<tr>
					<!-- Added By Ki -->
					<th align="left" style="width:10%;">번호</th>
					<th align="left"><?php  echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder) ; ?></th>
					<!-- End changes -->
					
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
					
					<?php if ($this->params->get('list_show_author', 1)) : ?>
					<th align="left" width="20%"><?php echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?></th>
					<?php endif; ?>
					<th align="center" width="10%"><?php echo JHtml::_('grid.sort', '아티스트', 'author', $listDirn, $listOrder); ?></th>
					<th align="center" width="30%">듣기</th>
					<th align="center" width="10%">다운로드</th>
					<?php if ($this->params->get('list_show_hits', 1)) : ?>
					<th align="center" width="10%"><?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?></th>
					<?php endif; ?>
					
				</tr>
			</thead>
			<?php endif; ?>
	
			<tbody>
				<?php
					if ( isset($_GET['limitstart']) && $_GET['limitstart'] != 0 )
						$index_num = $_GET['limitstart'] + 1;
					else
						$index_num = 1;
				?>
				<?php foreach ($this->items as $i => $article) : ?>
	
				<tr class="<?php if ($i % 2 == '0') { echo 'odd'; } else { echo 'even'; } ?>">
				
						<td style="padding: 0 25px 0 0; text-align: right;"><?php echo $index_num; $index_num++; ?></td>
					<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
						
						<td>
							<?php echo $this->escape($article->title); ?>
						</td>
						
						<?php if ($this->params->get('list_show_date')) : ?>
						<td><?php echo JHtml::_('date', $article->displayDate, $this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))); ?></td>
						<?php endif; ?>
						
						<?php if ($this->params->get('list_show_author', 1) && !empty($article->author )) : ?>
						<td>
						
							<?php
								$author =  $article->author;
								$author = ($article->created_by_alias ? $article->created_by_alias : $author);
		
								if (!empty($article->contactid ) &&  $this->params->get('link_author') == true) {
									echo JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$article->contactid), $author);
								} else {
									echo $author;
								}
							?>
	
						</td>
						<?php endif; ?>
						
						
						<td align="center">
						
						

							<?php
								$urls = json_decode($article->urls); 
								echo $urls->urlatext;
							?>
							
						</td>
						
						
						<td>
						  <script type="text/javascript">
								   jQuery(document).ready(function($){
								      $("#jquery_jplayer_<?php echo $article->id;?>").jPlayer({
								ready: function () {
								$(this).jPlayer("setMedia", {
								mp3: "<?php echo $urls->urla;?>",
								});
								},
									play: function() { // To avoid both jPlayers playing together.
									$(this).jPlayer("pauseOthers");
								},
									repeat: function(event) { // Override the default jPlayer repeat event handler
								if(event.jPlayer.options.loop) {
									$(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
									$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
									$(this).jPlayer("play");
								});
								} else {
									$(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
									$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {
														next_audio_id = '<?php echo $this->items[$i+1]->id;?>';

														//console.info(next_audio_id);
																$("#jquery_jplayer_"+next_audio_id).jPlayer("play", 0);
								});
								}
								},
								swfPath: "/js",
								cssSelectorAncestor: "#jp_container_<?php echo $article->id;?>",
								wmode: "window"
								});
								    });	
								  </script>
																				  <div id="jquery_jplayer_<?php echo $article->id;?>" class="jp-jplayer"></div>
								  <div id="jp_container_<?php echo $article->id;?>" class="jp-audio">
								    <div class="jp-type-single">
								      <div class="jp-gui jp-interface">
								        <ul class="jp-controls">
								          <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								          <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								          <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								          <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								          <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								          <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
								        </ul>
								        <div class="jp-progress">
								          <div class="jp-seek-bar">
								            <div class="jp-play-bar"></div>
								          </div>
								        </div>
								        <div class="jp-volume-bar">
								          <div class="jp-volume-bar-value"></div>
								        </div>
								        <div class="jp-time-holder">
								          <div class="jp-current-time"></div>
								          <div class="jp-duration"></div>
								          <ul class="jp-toggles">
								            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
								          </ul>
								        </div>
								      </div>
								      <div class="jp-no-solution">
								        <span>Update Required</span>
								        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
								      </div>
								    </div>
								  </div>
  						</td>
						<td align="center">
						<a class="music_download" href="<?php echo $urls->urla;?>" title="<?php $this->escape($article->title); ?>" target="_blank">다운로드</a>
						</td>
						<?php if ($this->params->get('list_show_hits', 1)) : ?>
						<td align="center"><?php echo $article->hits; ?></td>
						<?php endif; ?>
					
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
				<?php endforeach; ?>
				
			</tbody>
			
		</table>
	
		<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
		<?php endif; ?>
	
		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
	
	</form>
<?php endif; ?>
