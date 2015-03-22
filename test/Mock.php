<?php

namespace PHPMySql\Test;

use PHPMySql\Injector;

class Mock
{
	private $databaseFactory;

	public function injector()
	{
		return new Injector();
	}

	public function databaseFactory($injector = null)
	{
		if (is_null($this->databaseFactory)) {
			if (is_null($injector)) {
				$injector = $this->injector();
			}
			$this->databaseFactory = new Mock\DatabaseFactory($injector);
		}
		return $this->databaseFactory;
	}

	public function databaseWrapper()
	{
		return new Mock\DatabaseWrapper($this->databaseFactory());
	}

	public function databaseConnection()
	{
		return new Mock\DatabaseConnection();
	}

	public function databaseConnectionOptions($index = 0)
	{
		// Make the first response be actual connector details
		if ($index === 0) {
			return array(
				'host' => 'localhost',
				'username' => 'u64651275',
				'password' => '7PGTGKQv4Ww6vSt9',
				'databaseName' => 'integrand',
				'port' => null,
				'socket' => null
			);
		}
		else {
			return array(
				'host' => 'host' . $index,
				'username' => 'user' . $index,
				'password' => 'pass' . $index,
				'databaseName' => 'database' . $index,
				'port' => null,
				'socket' => null
			);
		}
	}

	public function databaseQueryBuilder()
	{
		return new Mock\DatabaseQueryBuilder();
	}

	public function databaseQuery()
	{
		return new Mock\DatabaseQuery();
	}

	public function databaseValue()
	{
		return new Mock\DatabaseValue();
	}
}
