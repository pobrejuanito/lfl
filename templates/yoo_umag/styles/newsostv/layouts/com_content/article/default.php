<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

// get view
$menu = JSite::getMenu()->getActive();
$view = is_object($menu) && isset($menu->query['view']) ? $menu->query['view'] : null;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params		= $this->item->params;
$images		= json_decode($this->item->images);
$urls		= json_decode($this->item->urls);
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();
$tplImgDir  = JURI::base() . "templates/yoo_nano/styles/newsostv/images/";
?>
<?php if ( isset($_GET['catid']) && $_GET['catid'] != 394 ) : ?>
	<script>
	jQuery(document).ready(function($) {

		$('a[id^="vodbutton"]').click( function() {
			//console.info($(this).attr('file') + ' ' + $(this).attr('streamer'));
			if ( $(this).attr('file') !== "javascript:void(0)" ) {
				if ( $(this).attr('type') === "video" ) {
					jwplayer().load({file: $(this).attr('file') + '?' + Math.round(1000 * Math.random()), streamer: $(this).attr('streamer')});
					jwplayer().pause();
					jwplayer().seek(parseInt($("#timer").html()));
					jwplayer().play();
				}
			}
		});

		if(typeof jwplayer === 'function') {
			jwplayer().onTime(function(e) {
				$("#timer").html(e.position);
			});
		}
	});
	</script>
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4fcfcc0c7b57665d"></script>
	<div id="system" style="position: relative; top: -15px">
		<div class="social_button">
		<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style " style="float:right;">
	<a class="addthis_button_preferred_1"></a>
	<a class="addthis_button_preferred_2"></a>
	<a class="addthis_button_preferred_3"></a>
	<a class="addthis_button_preferred_4"></a>
	<a class="addthis_button_compact"></a>
	<a class="addthis_counter addthis_bubble_style"></a>
	</div>
	<!-- AddThis Button END -->
		</div>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1 class="title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>

		<article class="item"<?php if ($view != 'article') printf(' data-permalink="%s"', JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catslug), true, -1)); ?>>

			<?php if ($params->get('show_title')) : ?>
			<header>

				<?php if (!$this->print) : ?>
					<?php if ($params->get('show_email_icon')) : ?>
					<div class="icon email"><?php echo JHtml::_('icon.email',  $this->item, $params); ?></div>
					<?php endif; ?>

					<?php if ($params->get('show_print_icon')) : ?>
					<div class="icon print"><?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?></div>
					<?php endif; ?>
				<?php else : ?>
					<div class="icon printscreen"><?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?></div>
				<?php endif; ?>

				<h1 class="title"><?php echo $this->escape($this->item->title); ?></h1>

				<?php if ($params->get('show_create_date') || ($params->get('show_author') && !empty($this->item->author)) || $params->get('show_category')) : ?>
				<p class="meta">

					<?php

						if ($params->get('show_author') && !empty($this->item->author )) {

							$author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author;

							if (!empty($this->item->contactid) && $params->get('link_author') == true) {

								$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
								$item = JSite::getMenu()->getItems('link', $needle, true);
								$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;

								echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author));
							} else {
								echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author);
							}

						}

						if ($params->get('show_create_date')) {
							echo ' '.JText::_('TPL_WARP_ON').' <time datetime="'.substr($this->item->created, 0,10).'" pubdate>'.JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC3')).'</time>';
						}

						if (($params->get('show_author') && !empty($this->item->author )) || $params->get('show_create_date')) {
							echo '. ';
						}

							echo JText::_('TPL_WARP_POSTED_IN').' ';
							$title = $this->escape($this->item->category_title);
							$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';
							if ($params->get('link_category') AND $this->item->catslug) {
								echo $url;
							} else {
								echo $title;
							}


					?>

				</p>
				<?php endif; ?>

			</header>
			<?php endif; ?>

			<?php

				if (!$params->get('show_intro')) {
					echo $this->item->event->afterDisplayTitle;
				}

				echo $this->item->event->beforeDisplayContent;

				if (isset ($this->item->toc)) {
					echo $this->item->toc;
				}

			?>

			<div class="content clearfix">
			<?php

				if ($params->get('access-view')) {

					if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position=='0')) OR ($params->get('urls_position')=='0' AND empty($urls->urls_position) ))
						OR (empty($urls->urls_position) AND (!$params->get('urls_position')))) {
							echo $this->loadTemplate('links');
					}

					if (isset($images->image_fulltext) and !empty($images->image_fulltext)) {
						$imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext;
						$class = (htmlspecialchars($imgfloat) != 'none') ? ' class="size-auto align-'.htmlspecialchars($imgfloat).'"' : ' class="size-auto"';
						$title = ($images->image_fulltext_caption) ? ' title="'.htmlspecialchars($images->image_fulltext_caption).'"' : '';
						echo '<img'.$class.$title.' src="'.htmlspecialchars($images->image_fulltext).'" alt="'.htmlspecialchars($images->image_fulltext_alt).'" />';
					}

					echo $this->item->text;


					if (isset($urls) AND ((!empty($urls->urls_position)  AND ($urls->urls_position=='1')) OR ( $params->get('urls_position')=='1') ) AND ($urls->urla != '' AND $urls->urlb != '' AND $urls->urlc != '')) {
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
						?>
							<div style="position: relative; top: -260px; left: -82px; z-index: 999; width:75px;">
								<div>
									<a id="vodbutton_high" href="javascript:void(0)" type="video" file="<?php echo $urla ?>" streamer="<?php echo $urls->rtmp_streamer ?>">
									<img id="down_high_img" src="<?php echo $tplImgDir; ?>button-vod-high<?php echo $imga; ?>.png"></a>
								</div>
								<div>
									<a id="vodbutton_low" href="javascript:void(0)" type="video" file="<?php echo $urlb ?>" streamer="<?php echo $urls->rtmp_streamer ?>">
									<img id="down_low_img" src="<?php echo $tplImgDir; ?>button-vod-low<?php echo $imgb; ?>.png"></a>
								</div>
							</div>

						<?php
					}


				// optional teaser intro text for guests
				} elseif ($params->get('show_noauth') == true AND $user->get('guest')) {

					echo $this->item->introtext;

					// optional link to let them register to see the whole article.
					if ($params->get('show_readmore') && $this->item->fulltext != null) {
						$link1 = JRoute::_('index.php?option=com_users&view=login');
						$link = new JURI($link1);
						echo '<p class="links">';
						echo '<a href="'.$link.'">';
						$attribs = json_decode($this->item->attribs);

						if ($attribs->alternative_readmore == null) {
							echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
						} elseif ($readmore = $this->item->alternative_readmore) {
							echo $readmore;
							if ($params->get('show_readmore_title', 0) != 0) {
								echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
							}
						} elseif ($params->get('show_readmore_title', 0) == 0) {
							echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
						} else {
							echo JText::_('COM_CONTENT_READ_MORE');
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						}

						echo '</a></p>';
					}
				}

			?>
			</div>

			<?php if ($canEdit) : ?>
			<p class="edit"><?php echo JHtml::_('icon.edit', $this->item, $params); ?> <?php echo JText::_('TPL_WARP_EDIT_ARTICLE'); ?></p>
			<?php endif; ?>

			<?php echo $this->item->event->afterDisplayContent; ?>
		</article>
	</div>
	<div id="timer" style="display:none"></div>
<?php else : ?>
	<!-- START NEWS VIEW -->
	<?php
	echo $this->item->text;
	?>
<?php endif ?>