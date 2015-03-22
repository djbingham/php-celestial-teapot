<?php

namespace PHPMySql\QueryBuilder;

use PHPMySql\Abstractory;
use Database\QueryBuilder\MySql\Factory\Query;
use Database\QueryBuilder\MySql\Factory\Value;

class MySql extends Abstractory\QueryBuilder
{
	/**
	 * @var Abstractory\ConnectionWrapper
	 */
	protected $connection;

	/**
	 * @param Abstractory\ConnectionWrapper $connection
	 * @return MySql $this
	 */
	public function setConnection(Abstractory\ConnectionWrapper $connection)
	{
		$this->connection = $connection;
		return $this;
	}

	/**
	 * @return Abstractory\ConnectionWrapper
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * @return Query
	 * @throws \Exception
	 */
	public function query()
	{
		if (!$this->hasDatabaseWrapper()) {
			throw new \Exception('No database wrapper set. Cannot build query.');
		}
		$query = new Query();
		$query->setDatabaseWrapper($this->databaseWrapper);
		return $query;
	}

	/**
	 * @return Value
	 * @throws \Exception
	 */
	public function value()
	{
		if (!$this->hasDatabaseWrapper()) {
			throw new \Exception('No database wrapper set. Cannot build value.');
		}
		$value = new Value();
		$value->setDatabaseWrapper($this->databaseWrapper);
		return $value;
	}
}