<?php
namespace PHPMySql\Connection;

use PHPMySql\Abstractory;
use PHPMySql\Connection\MySqli as MySqliConnection;

class Manager
{
	private $connections = array();

	public function set($name, MySqliConnection $connection)
	{
		$this->connections[$name] = $connection;
		return $this;
	}

	public function get($name)
	{
		if (!array_key_exists($name, $this->connections)) {
			throw new \Exception(sprintf('No database connection found with name: %s', $name));
		}
		return $this->connections[$name];
	}
}
