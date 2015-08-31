<?php

namespace SlothMySql;

class DatabaseWrapper
{
	/**
	 * @var Face\ConnectionInterface
	 */
	protected $connection;

	/**
	 * @var Face\QueryBuilderFactoryInterface
	 */
	protected $queryBuilderFactory;

	public function __construct(Face\ConnectionInterface $connection, Face\QueryBuilderFactoryInterface $queryBuilderFactory)
	{
		$this->connection = $connection;
		$this->queryBuilderFactory = $queryBuilderFactory;
	}

	/**
	 * @return Face\QueryFactoryInterface
	 */
	public function query()
	{
		return $this->queryBuilderFactory->query();
	}

	/**
	 * @return Face\ValueFactoryInterface
	 */
	public function value()
	{
		return $this->queryBuilderFactory->value();
	}

	/**
	 * @param Face\QueryInterface $query
	 * @return DatabaseWrapper $this
	 * @throws \Exception If database reports error running query
	 */
	public function execute(Face\QueryInterface $query)
	{
		$this->connection->executeQuery($query);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->connection->getLastResultData();
	}

	/**
	 * @return int
	 */
	public function getAffectedRowsCount()
	{
		return $this->connection->countAffectedRows();
	}

	/**
	 * @return int
	 */
	public function getInsertId()
	{
		return $this->connection->getLastInsertId();
	}

	/**
	 * @return null|string
	 */
	public function getLastError()
	{
		return $this->connection->getLastError();
	}

	/**
	 * @return array
	 */
	public function queryLog()
	{
		return $this->connection->getQueryLog();
	}

	/**
	 * @return DatabaseWrapper $this
	 */
	public function begin()
	{
		$this->connection->begin();
		return $this;
	}

	/**
	 * @return DatabaseWrapper $this
	 */
	public function commit()
	{
		$this->connection->commit();
		return $this;
	}

	/**
	 * @return DatabaseWrapper $this
	 */
	public function rollback()
	{
		$this->connection->rollback();
		return $this;
	}

	/**
	 * @param string $string String to escape
	 * @return string The escaped string
	 */
	public function escapeString($string)
	{
		return $this->connection->escapeString($string);
	}
}
