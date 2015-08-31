<?php
namespace SlothMySql\Base;

trait InternalCache
{
	/**
	 * @var array
	 */
	private $cache = array();

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