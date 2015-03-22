<?php

namespace PHPMySql\Abstractory;

use PHPMySql\DatabaseWrapper;

abstract class QueryBuilder
{
	/**
	 * @var DatabaseWrapper
	 */
	protected $databaseWrapper;

	/**
	 * @param DatabaseWrapper $wrapper
	 * @return $this
	 */
	public function setDatabaseWrapper(DatabaseWrapper $wrapper)
	{
		$this->databaseWrapper = $wrapper;
		return $this;
	}

	/**
	 * @return DatabaseWrapper
	 */
	public function getDatabaseWrapper()
	{
		return $this->databaseWrapper;
	}

	/**
	 * @return bool
	 */
	public function hasDatabaseWrapper()
	{
		return $this->databaseWrapper instanceof DatabaseWrapper;
	}

	/**
	 * @return Query
	 */
	abstract public function query();

	/**
	 * @return Value
	 */
	abstract public function value();
}