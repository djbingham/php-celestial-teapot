<?php

namespace PHPMySql\Test\Utility;

class Mock
{
	private $databaseFactory;

	public function databaseFactory()
	{
		if (is_null($this->databaseFactory)) {
			$this->databaseFactory = new Mock\Factory();
		}
		return $this->databaseFactory;
	}

	public function databaseWrapper()
	{
		return new Mock\DatabaseWrapper($this->connection(), $this->queryBuilderFactory());
	}

	public function connection()
	{
		return new Mock\Connection();
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

	public function queryBuilderFactory()
	{
		return new Mock\QueryBuilderFactory($this->connection());
	}

	public function databaseQuery()
	{
		return new Mock\Query();
	}

	public function databaseValue()
	{
		return new Mock\Value();
	}
}
