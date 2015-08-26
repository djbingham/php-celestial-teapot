<?php
namespace SlothMySql\Abstractory;

abstract class AFactory
{
	/**
	 * @var IConnection
	 */
	protected $connection;

	/**
	 * @var array
	 */
	private $cache = array();

	public function __construct(IConnection $connection)
	{
		$this->connection = $connection;
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
