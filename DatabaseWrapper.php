<?php

namespace PHPMySql;

class DatabaseWrapper
{
	/**
	 * @var Abstractory\IConnection
	 */
	protected $connection;

	/**
	 * @var Abstractory\IQueryBuilderFactory
	 */
	protected $queryBuilderFactory;

	public function __construct(Abstractory\IConnection $connection, Abstractory\IQueryBuilderFactory $queryBuilderFactory)
	{
		$this->connection = $connection;
		$this->queryBuilderFactory = $queryBuilderFactory;
	}

	/**
	 * @return Abstractory\IQueryFactory
	 */
	public function query()
	{
		return $this->queryBuilderFactory->query();
	}

	/**
	 * @return Abstractory\IValueFactory
	 */
	public function value()
	{
		return $this->queryBuilderFactory->value();
	}

	/**
	 * @param Abstractory\AQuery $query
	 * @return DatabaseWrapper $this
	 * @throws \Exception If database reports error running query
	 */
	public function execute(Abstractory\AQuery $query)
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
