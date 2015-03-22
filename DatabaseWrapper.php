<?php

namespace PHPMySql;

class DatabaseWrapper
{
	/**
	 * @var Factory
	 */
	protected $factory;

	/**
	 * @var Factory\MySqli\Connection
	 */
	protected $connector;
	/**
	 * @var Abstractory\ConnectionWrapper
	 */
	protected $connection;
	/**
	 * @var Factory\MySqli\QueryBuilder
	 */
	protected $queryBuilder;

	public function __construct(Factory $factory)
	{
		$this->factory = $factory;
	}

	public function connector()
	{
		if (!isset($this->connector)) {
			$this->connector = new Factory\MySqli\Connection($this->factory);
		}
		return $this->connector;
	}

	/**
	 * @return Abstractory\ConnectionWrapper
	 */
	public function connection()
	{
		return $this->connection;
	}

	/**
	 * @return Factory\MySqli\QueryBuilder
	 */
	public function queryBuilder()
	{
		if (!isset($this->queryBuilder)) {
			$this->queryBuilder = new Factory\MySqli\QueryBuilder($this->factory);
		}
		return $this->queryBuilder;
	}

	/**
	 * @param Abstractory\ConnectionWrapper $connectionWrapper
	 * @return DatabaseWrapper $this
	 */
	public function connect(Abstractory\ConnectionWrapper $connectionWrapper)
	{
		$this->connection = $connectionWrapper;
		$this->connection()->connect();
		return $this;
	}

	/**
	 * @param Abstractory\Query $query
	 * @return DatabaseWrapper $this
	 * @throws \Exception If database reports error running query
	 */
	public function query(Abstractory\Query $query)
	{
		$this->connection()->query($query);
		if ($this->connection()->hasError()) {
			throw new \Exception(sprintf('Database query caused error: %s', $this->connection()->getError()));
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->connection()->getData();
	}

	/**
	 * @return int
	 */
	public function getAffectedRowsCount()
	{
		return $this->connection()->getAffectedRowsCount();
	}

	/**
	 * @return int
	 */
	public function getInsertId()
	{
		return $this->connection()->getInsertId();
	}

	/**
	 * @return bool
	 */
	public function hasError()
	{
		return $this->connection()->hasError();
	}

	/**
	 * @return null|string
	 */
	public function getError()
	{
		return $this->connection()->getError();
	}

	/**
	 * @return array
	 */
	public function queryLog()
	{
		return $this->connection()->getQueryLog();
	}

	/**
	 * @return DatabaseWrapper $this
	 */
	public function begin()
	{
		$this->connection()->begin();
		return $this;
	}

	/**
	 * @return DatabaseWrapper $this
	 */
	public function commit()
	{
		$this->connection()->commit();
		return $this;
	}

	/**
	 * @return DatabaseWrapper $this
	 */
	public function rollback()
	{
		$this->connection()->rollback();
		return $this;
	}

	/**
	 * @param string $string String to escape
	 * @return string The escaped string
	 */
	public function escapeString($string)
	{
		return $this->connection()->escapeString($string);
	}
}
