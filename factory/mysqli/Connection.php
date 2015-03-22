<?php

namespace PHPMySql\Factory\MySqli;

use PHPMySql\Factory\SubFactory;
use PHPMySql\Connector;

class Connection extends SubFactory
{
	/**
	 * @param $name
	 * @param Connector\ConnectionOptions $options
	 * @return $this
	 */
	public function set($name, Connector\ConnectionOptions $options)
	{
		$connection = new Connector\Connection\MySqli();
		$connection
			->setEngine(new \MySqli())
			->setOptions($options);
		return $this->setCache($name, $connection);
	}

	/**
	 * @param $name
	 * @return Connector\Connection\MySqli
	 * @throws \Exception
	 */
	public function get($name)
	{
		$connection = $this->getCache($name);
		if (!($connection instanceof Connector\Connection\MySqli)) {
			throw new \Exception(sprintf('MySqli connector does not exist: %s', $name));
		}
		return $connection;
	}

	public function buildOptions(array $options)
	{
		$connectionOptions = new Connector\ConnectionOptions();
		foreach ($options as $key => $value) {
			$setter = 'set' . ucfirst($key);
			$connectionOptions->$setter($value);
		}
		return $connectionOptions;
	}
}
