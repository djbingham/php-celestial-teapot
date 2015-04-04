<?php

namespace PHPMySql\Abstractory;

abstract class Query
{
	/**
	 * @var IConnection
	 */
	protected $connection;

	abstract public function __toString();

	/**
	 * @param IConnection $connection
	 * @return $this
	 */
	public function setConnection(IConnection $connection)
	{
		$this->connection = $connection;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasConnection()
	{
		return $this->connection instanceof IConnection;
	}

	/**
	 * @return IConnection
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * @param $string
	 * @return string
	 */
	public function escapeString($string)
	{
		return $this->getConnection()->escapeString($string);
	}
}
