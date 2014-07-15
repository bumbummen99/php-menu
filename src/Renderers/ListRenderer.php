<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace anlutro\Menu\Renderers;

use anlutro\Menu\Collection;
use anlutro\Menu\Nodes\SubmenuNode;
use anlutro\Menu\Nodes\NodeInterface;

class ListRenderer implements RendererInterface
{
	public function render(Collection $menu)
	{
		return $this->renderUnorderedList($this->renderItems($menu->getSortedItems()), $this->getMenuAttributes($menu));
	}

	protected function renderItems(array $items)
	{
		$str = '';

		foreach ($items as $item) {
			$str .= $this->renderItem($item);
		}

		return $str;
	}

	protected function renderItem(NodeInterface $item)
	{
		if ($item == Collection::DIVIDER) {
			return $this->renderListItem('', $this->getDividerAttributes());
		}

		if ($item instanceof SubmenuNode) {
			$submenuLink = $this->renderAnchor($this->getSubmenuTitle($item), '#', $this->getSubmenuAnchorAttributes($item));
			return $this->renderListItem($submenuLink.$this->renderSubmenu($item->getSubmenu()), $this->getSubmenuItemAttributes($item));
		}

		return $this->renderListItem($this->renderAnchor($this->getMenuTitle($item), $item->getUrl(), $this->getItemAnchorAttributes($item)));
	}

	protected function renderSubmenu(Collection $menu)
	{
		return $this->renderUnorderedList($this->renderItems($menu->getSortedItems()), $this->getSubmenuAttributes($menu));
	}

	protected function renderUnorderedList($items, array $attributes = array())
	{
		return '<ul'.$this->attributes($attributes).'>'.$items.'</ul>';
	}

	protected function renderListItem($title, array $attributes = array())
	{
		return '<li'.$this->attributes($attributes).'>'.$title.'</li>';
	}

	protected function renderAnchor($title, $href, array $attributes)
	{
		return '<a'.$this->attributes(['href' => $href] + $attributes).'>'.$title.'</a>';
	}

	protected function getMenuTitle(NodeInterface $item)
	{
		return $this->renderItemIcon($item).e($item->getTitle());
	}

	protected function renderItemIcon(NodeInterface $item)
	{
		return ($icon = $item->getIcon()) ? $icon->render() : '';
	}

	protected function getSubmenuTitle($item)
	{
		return $this->getMenuTitle($item).$this->getSubmenuAffix();
	}

	protected function getMenuAttributes($menu)
	{
		$attributes = $menu->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu--'.$attributes['id'];
		}
		return $attributes;
	}

	protected function getSubmenuAttributes($menu)
	{
		$attributes = $menu->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu--'.$attributes['id'];
		}
		return $attributes;
	}

	protected function getDividerAttributes()
	{
		return [];
	}

	protected function getItemAnchorAttributes(NodeInterface $item)
	{
		$attributes = $item->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu-item--'.$attributes['id'];
		}
		return $attributes;
	}

	protected function getSubmenuAffix()
	{
		return '';
	}

	protected function getSubmenuAnchorAttributes(NodeInterface $item)
	{
		$attributes = $item->getAttributes();
		if (isset($attributes['id'])) {
			$attributes['id'] = 'menu-item--'.$attributes['id'];
		}
		return $attributes;
	}

	protected function getSubmenuItemAttributes(NodeInterface $item)
	{
		return [];
	}

	protected function mergeAttributes(array $attributes, array $defaults)
	{
		if (isset($attributes['class']) && isset($defaults['class'])) {
			if (is_string($attributes['class'])) {
				$attributes['class'] = explode(' ', $attributes['class']);
			}
			$attributes['class'] = array_filter($attributes['class']);

			if (is_string($defaults['class'])) {
				$defaults['class'] = explode(' ', $defaults['class']);
			}
			$defaults['class'] = array_filter($defaults['class']);

			$attributes['class'] = implode(' ', array_unique($attributes['class'] + $defaults['class']));
			unset($defaults['class']);
		}

		return $attributes + $defaults;
	}

	protected function attributes(array $attributes)
	{
		$str = '';

		foreach ($attributes as $key => $value) {
			if (is_array($value)) {
				$value = implode(' ', $value);
			}
			if ($key == 'class' && $value == '') {
				continue;
			}
			$str .= " $key=\"$value\"";
		}

		return $str;
	}
}
