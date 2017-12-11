<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
	Class: WarpMenuDefault
		Menu base class
*/
class WarpMenuDefault extends WarpMenu {
	/*
		Function: process

		Returns:
			Object
	*/	
	public function process($module, $element) {

	    self::render_level1($element->first('ul:first'));
	    self::render_level2($element->first('ul.nav'));
	    //self::render_aboutus($element->first('ul.nav'));
		//self::_process($module, $element->first('ul:first'));
		return $element;
	}
    protected static function render_level1($element) {
        $element->attr('class', 'nav navbar-nav');
    }
    // ul.nav
    protected static function render_level2($element) {
        // ul.nav.li
        $max_columns = 12;

        foreach ($element->children('li') as $li) {
            // don't add dropdown to menu without levels
            if ( $li->children('ul')->length > 0 ) {
                $li->attr('class','dropdown yamm-fw');
                $children = $li->children('a,span');
                $children[0]->append('<a class="dropdown-caret dropdown-toggle"  style="display: none" data-hover="dropdown" ></a>');
                if ($children[0]->getAttribute('class') == 'about-us-class') {
                    $children[0]->append('<ul class="visible-xs">
                        <li><a href="about.html">SOSTV는 누구인가?</a></li>
                        <li><a href="about-us-must-watch.html">꼭들어야 하는설교</a></li>
                        <li><a href="about-us-must-read.html">꼭읽어야 하는 글</a></li>
                        <li><a href="about-us-faq.html">SOSTV FAQ</a></li>
                    </ul><ul class="dropdown-menu hidden-xs hidden-sm">
                        <li>
                            <div class="yamm-content">
                                <div class="row no-gutter-3">
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="/images/newsite/aboutus_first.jpg" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">SOSTV는 누구인가?</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="about.html">SOSTV는 여러분의 마음과 생애 속에 빛을 가져다 드리기 위해 일합니다. 더 읽기...</a></div>
                                        </div>
                                    </article>
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="/images/newsite/aboutus_second.jpg" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">꼭들어야 하는설교</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="/about-us-must-watch.html">꼭 들어야 하는 설교. 더 읽기...</a></div>
                                        </div>
                                    </article>
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="/images/newsite/aboutus_third.jpg" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">꼭읽어야 하는 글</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="/about-us-must-read.html">꼭읽어야 하는 글. 더 읽기...</a></div>
                                        </div>
                                    </article>
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="/images/newsite/aboutus_fourth.jpg" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">SOSTV FAQ</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="/about-us-faq.html">SOSTV에서 전하는 진리를 믿는 사람들과 함께 교제하거나 예배드릴 수 있나요?. 더 읽기...</a></div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </li>
                    </ul>');
                }
                $li->append('<ul class="dropdown-menu"><li><div class="yamm-content"><div class="row"></div></div></li></ul>');
                $ul_element = $li->children('ul');

                foreach ($ul_element as $u) {

                    if (!$u->hasAttribute('class')) {
                        $u->attr('class', 'submenu-items');
                        // we don't want this ul on this level, so remove it, and place it at another level
                        $li->removeChild($u);

                        $column_width = floor($max_columns / $u->children('li')->length);
                        // iterate over menu columns get number of columns needed
                        foreach ($u->children('li') as $sub_menu_li) {

                            $column_node_html = '<div class="col-lg-' . $column_width . ' col-md-' . $column_width . '">';
                            $column_node = $sub_menu_li->children('span,ul');

                            foreach ($column_node as $dom_node) {
                                if ($dom_node->tagName == 'ul') {
                                    $dom_node->attr('class', 'mega-links');
                                }
                                $column_node_html .= $u->ownerDocument->saveXML($dom_node);
                            }
                            $column_node_html .= '</div>';

                            $div = $li->first('ul.dropdown-menu li div.yamm-content div.row');
                            $div->append($column_node_html);
                        }
                    } // end if
                } // end for $u
            } // end if;
        } // endfor
    }

    protected static function render_aboutus($element) {
	    $html = '<li class="dropdown yamm-fw">
                    <a class="dropdown-link" href="category-fashion.html">FASHION</a>
                    <a class="dropdown-caret dropdown-toggle" data-hover="dropdown"><b class="caret hidden-xs"></b></a>
                    <ul class="visible-xs">
                        <li><a href="category-fashion.html">Clothing</a></li>
                        <li><a href="category-fashion.html">Shoes</a></li>
                        <li><a href="category-fashion.html">Catwalk 2014</a></li>
                    </ul>
                    <ul class="dropdown-menu hidden-xs hidden-sm">
                        <li>
                            <div class="yamm-content">
                                <div class="row no-gutter-3">
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">FASHION</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="category-fashion.html">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.</a></div>
                                        </div>
                                    </article>
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">FASHION</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="category-fashion.html">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.</a></div>
                                        </div>
                                    </article>
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">FASHION</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="category-fashion.html">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.</a></div>
                                        </div>
                                    </article>
                                    <article class="col-lg-3 col-md-3">
                                        <div class="picture">
                                            <div class="category-image">
                                                <img src="http://placehold.it/800x550" class="img-responsive" alt="" />
                                                <h2 class="overlay-category">FASHION</h2>
                                            </div>
                                        </div>
                                        <div class="detail">
                                            <div class="caption"><a href="category-fashion.html">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.</a></div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>';
    }
	/*
		Function: _process

		Returns:
			Void
	*/
	protected static function _process($module, $element, $level = 0) {
        /*
		if ($level == 0) {
			$element->attr('class', 'nav navbar-nav');
		} elseif ( $level == 1) {
			//$element->attr('class','dropdown-menu');
		} elseif ( $level == 2) {
		    //$element->attr('class','mega-links');
        } else {
            $element->attr('class','');
        }
        */
		foreach ($element->children('li') as $li) {
			// is active ?
			if ($active = $li->attr('data-menu-active')) {
				$active = $active == 2 ? ' active current' : ' active';
			}
			// is parent ?
			$ul = $li->children('ul');
			$parent = $ul->length ? ' parent' : null;

			// set class in li
			//$li->attr('class', sprintf('level%d item%s'.$parent.$active, $level + 1, $li->attr('data-id')));

            // set class in a/span
			foreach ($li->children('a,span') as $child) {
                /*
				// get title
				$title = $child->first('span:first');

				// set subtile
				$subtitle = $title ? explode('||', $title->text()) : array();
				
				if (count($subtitle) == 2) {
					$li->addClass('hassubtitle');
					$title->html(sprintf('<span class="title">%s</span><span class="subtitle">%s</span>', trim($subtitle[0]), trim($subtitle[1])));
				}

				// set image
				if ($image = $li->attr('data-menu-image')) {
					$title->prepend(sprintf('<span class="icon" style="background-image: url(\'%s\');"> </span>', $image));
				}

				//$child->addClass(sprintf('level%d'.$parent.$active, $level + 1));
                */
                if ($level == 0) {
                    $child->attr('class','dropdown-link');
                }
			}

            if ($level == 0 ) {
                $li->attr('class', 'dropdown yamm-fw');
                $temp_child = $li->children('a,span');
                $temp_child[0]->append('<a class="dropdown-caret dropdown-toggle" data-hover="dropdown" ></a>');
                $li->append('<ul class="dropdown-menu"><li></li></ul>');
            }
			// process submenu
			if ($ul->length) {
				self::_process($module, $ul->item(0), $level + 1);
			}
		}
	}
}