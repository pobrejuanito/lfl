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
        var server =  $("#"+$(this).attr("parentlink")).attr("vod_low_streamer");
        if ( server.indexOf('tvstream') !== -1 ) {
            server_location = 'http://tvdown.sostvnetwork.com/';
        } else {
            server_location = 'http://netdown.sostvnetwork.com/';
        }

        jwplayer(jwplayerid).load({
            file: server_location+ $("#"+$(this).attr("parentlink")).attr("vod_low_file"),
            //streamer: $("#"+$(this).attr("parentlink")).attr("vod_low_streamer")
        });

		jwplayer(jwplayerid).pause();
		jwplayer(jwplayerid).seek(seek_time);
		jwplayer(jwplayerid).play();
	});

	$('a[id^="vodbutton"]').click( function() {

		if ( $(this).attr('file') !== "javascript:void(0)" ) {
			if ( $(this).attr('type') === "video" ) {
				jwplayer().load({
                    file: $(this).attr('file') + '?' + Math.round(1000 * Math.random()),
                })
			}
		}
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
    <section class="category">
        <div class="row">
            <div class="col-lg-12">
                <?php echo $this->items[$displayIndex]->introtext; ?>
                <div style="text-align:center;">
                    <div>
                        <!-- SHOW CATEGORY & DESCRIPTION -->
                        <?php if ($this->params->get('show_category_title', 1)) : ?>
                        <div class="detail">
                            <div class="caption">
                                <?php echo $this->items[$displayIndex]->title;?>
                            </div>
                            <h3></h3>
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
                <form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm">
                    <table class="table table-hover">
                        <?php if ($this->params->get('show_headings')) : ?>
                            <thead>
                            <tr>
                                <th><?php  echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder) ; ?></th>
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
                                <th>다운로드</th>
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
                            <tr>
                                <td>
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
                                <td>
                                    <a href="<?php echo $urls->urla ?>"><button type="button" class="btn btn-default btn-sm"  id="dhi_<?php echo $article->id; ?>" vimg="<?php echo $tplImgDir; ?>button-vod-high<?php echo $imga; ?>.png" src="<?php echo $tplImgDir; ?>button-list-hd<?php echo $imga; ?>.png">HD고화질</button></a>
                                    <a href="<?php echo $urls->urlb ?>"><button type="button" class="btn btn-default btn-sm" id="dli_<?php echo $article->id; ?>" vimg="<?php echo $tplImgDir; ?>button-vod-low<?php  echo $imgb; ?>.png" src="<?php echo $tplImgDir; ?>button-list-sd<?php echo $imgb; ?>.png">일반화질</button></a>
                                    <a href="<?php echo $urls->urlc ?>"><button type="button" class="btn btn-default btn-sm"  id="dai_<?php echo $article->id; ?>" vimg="<?php echo $tplImgDir; ?>button-vod-mp3<?php  echo $imgc; ?>.png" src="<?php echo $tplImgDir; ?>button-list-mp3<?php echo $imgc; ?>.png">MP3</button></a>
                                </td>
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
        </div>
    </section>
	<?php endif; ?>
