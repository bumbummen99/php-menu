<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace bs4menu;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->app->bindShared('bs4menu\Builder', function($app) {
			return new Builder();
		});
	}

	public function provides()
	{
		return array('bs4menu\Builder');
	}
}
