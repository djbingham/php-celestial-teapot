<?php
namespace PHPMySql\Abstractory;

use PHPMySql\Injector;

abstract class Factory
{
	/**
	 * @var array
	 */
	private $cache = array();

	/**
	 * @var Injector
	 */
	protected $injector;

	public function __construct(Injector $injector)
	{
		$this->injector = $injector;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return $this
	 */
	public function setCache($name, $value)
	{
		$this->cache[$name] = $value;
		return $this;
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getCache($name = null)
	{
		if (!array_key_exists($name, $this->cache)) {
			return null;
		}
		return $this->cache[$name];
	}
}
