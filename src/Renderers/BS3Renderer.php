<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace bs4menu\Renderers;

use bs4menu\Collection;
use bs4menu\Nodes\SubmenuNode;
use bs4menu\Nodes\NodeInterface;

class BS3Renderer extends ListRenderer
{
	public function getMenuAttributes(Collection $menu)
	{
		return $this->mergeAttributes(parent::getMenuAttributes($menu),
			['class' => 'nav navbar-nav']);
	}

	public function getSubmenuAttributes(Collection $menu)
	{
		return $this->mergeAttributes(parent::getSubmenuAttributes($menu),
			['class' => 'dropdown-menu']);
	}

	public function getSubmenuAnchorAttributes(SubmenuNode $item)
	{
		return $this->mergeAttributes(parent::getSubmenuAnchorAttributes($item),
			['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
	}

	public function getDividerAttributes()
	{
		return ['class' => 'divider'];
	}

	public function getSubmenuAffix()
	{
		return ' <b class="caret"></b>';
	}

	public function getSubmenuItemAttributes(SubmenuNode $item)
	{
		return ['class' => 'dropdown'];
	}
}
