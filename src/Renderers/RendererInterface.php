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

interface RendererInterface
{
	public function render(Collection $menu);
}
