<?php
/**
 * PHP Menu Builder
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  php-menu
 */

namespace bs4menu\Nodes;

use bs4menu\Util\StringUtils;
use bs4menu\Icons\IconInterface;

/**
 * A menu item.
 */
abstract class AbstractNode
{
	/**
	 * The title of the item.
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * The item's attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * The icon associated with the item.
	 *
	 * @var IconInterface
	 */
	protected $icon;

	/**
	 * Optional HTML prefix for the node.
	 *
	 * @var string
	 */
	protected $prefix = '';

	/**
	 * Optional HTML suffix for the node.
	 *
	 * @var string
	 */
	protected $suffix = '';

	/**
	 * Array of icon resolvers.
	 *
	 * @var array
	 */
	protected static $iconResolvers = [
		'glyph' => 'bs4menu\Icons\Glyphicon',
		'glyphicon' => 'bs4menu\Icons\Glyphicon',
		'fa-icon' => 'bs4menu\Icons\FontAwesomeIcon',
		'fa-stack' => 'bs4menu\Icons\FontAwesomeStack',
	];

	/**
	 * Array keys of attributes that are not HTML attributes.
	 *
	 * @var array
	 */
	protected static $notHtmlAttributes = [
		'icon', 'href', 'suffix', 'prefix', 'glyph',
		'glyphicon', 'fa-icon', 'fa-stack'
	];

	/**
	 * Add an array of icon resolvers.
	 *
	 * @param array $resolvers
	 */
	public static function addIconResolvers(array $resolvers)
	{
		static::$iconResolvers = $resolvers + static::$iconResolvers;
		static::$notHtmlAttributes = array_merge(['icon', 'href', 'suffix', 'prefix'],
			array_keys(static::$iconResolvers));
	}

	/**
	 * @param  array $attributes
	 *
	 * @return array
	 */
	protected function parseAttributes(array $attributes)
	{
		if (isset($attributes['icon']) && $attributes['icon'] instanceof IconInterface) {
			$this->icon = $attributes['icon'];
		} else {
			/** @var IconInterface $resolver */
			foreach (static::$iconResolvers as $key => $resolver) {
				if (array_key_exists($key, $attributes)) {
					$this->icon = $resolver::createFromAttribute($attributes[$key]);
					break;
				}
			}
		}

		if (isset($attributes['class'])) {
			if (is_string($attributes['class'])) {
				$attributes['class'] = explode(' ', $attributes['class']);
			}
		} else {
			$attributes['class'] = [];
		}

		if (isset($attributes['suffix'])) {
			$this->suffix = $attributes['suffix'];
		}
		if (isset($attributes['prefix'])) {
			$this->prefix = $attributes['prefix'];
		}

		$attributes['id'] = isset($attributes['id']) ? $attributes['id'] : StringUtils::slug($this->title);

		return array_diff_key($attributes, array_flip(static::$notHtmlAttributes));
	}

	/**
	 * Get the identifier of the item.
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getTitle()
	{
		return $this->prefix.htmlentities($this->title, ENT_QUOTES, 'UTF-8', false).$this->suffix;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function getIcon()
	{
		return $this->icon;
	}
}
