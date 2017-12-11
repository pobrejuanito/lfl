<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
/*
	Class: WarpMenuDropdown
		Menu base class
*/
class WarpMenuDropdown extends WarpMenu {

	public function process($module, $element) {
/*
		foreach ($element->find('ul.dropdown-menu') as $ul) {
			$li = $ul->parent();
            $li->append('<div class="yamm-content"><div class="row"><div class="col-lg-3 col-md-3"></div></div></div>');
			$div = $li->first('div.yamm-content div.row div.col-lg-3');
			foreach ($li->children('ul') as $i => $u) {
				//$div->append(sprintf('<div class="width%d column"></div>', floor(100 / $columns)))->children('div')->item($i)->append($u);
                $div->append($u);
			}
		}
*/
		return $element;
	}
}