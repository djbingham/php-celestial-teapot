<?php

namespace PHPMySql\Abstractory;

use PHPMySql\DatabaseWrapper;

abstract class Value
{
	/**
	 * @var DatabaseWrapper
	 */
	protected $databaseWrapper;

	abstract public function __toString();

	/**
	 * @param DatabaseWrapper $databaseWrapper
	 * @return Value $this
	 */
	public function setDatabaseWrapper(DatabaseWrapper $databaseWrapper)
	{
		$this->databaseWrapper = $databaseWrapper;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasDatabaseWrapper()
	{
		return $this->databaseWrapper instanceof DatabaseWrapper;
	}

	/**
	 * @return DatabaseWrapper
	 */
	public function getDatabaseWrapper()
	{
		return $this->databaseWrapper;
	}

	/**
	 * @param $string
	 * @return string
	 */
	public function escapeString($string)
	{
		return $this->getDatabaseWrapper()->escapeString($string);
	}
}