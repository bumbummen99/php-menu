<?php
namespace bs4menu\Tests;

use PHPUnit_Framework_TestCase;

class MenuSubmenuItemTest extends PHPUnit_Framework_TestCase
{
	public function makeItem($title, $submenu = null, array $attributes = array())
	{
		return new \bs4menu\Nodes\SubmenuNode($title, $submenu ?: $this->makeCollection(), $attributes);
	}

	public function makeCollection()
	{
		return new \bs4menu\Collection(new \bs4menu\Builder());
	}

	public function testItemStoresCollection()
	{
		$coll = $this->makeCollection();
		$coll->addItem('Test Item 1', '/url-1');
		$coll->addItem('Test Item 2', '/url-2');
		$item = $this->makeItem('Submenu', $coll);
		$this->assertSame($coll, $item->getSubmenu());
	}
}
