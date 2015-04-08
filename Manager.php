<?php
namespace PHPMySql;

class Manager
{
	/**
	 * @var Connection\Manager
	 */
	private $connectionManager;

	/**
	 * @var QueryBuilder\Manager
	 */
	private $queryBuilderManager;

//	/**
//	 * @var array
//	 */
//	private $databaseWrappers = array();

	/**
	 * @var array
	 */
	private $connections = array();

	/**
	 * @var array
	 */
	private $queryBuilders = array();

	public function __construct(Connection\Manager $connectionManager, QueryBuilder\Manager $queryBuilderManager)
	{
		$this->connectionManager = $connectionManager;
		$this->queryBuilderManager = $queryBuilderManager;
	}

//	public function set($name, array $parameters)
//	{
//		$connection = $this->connectionManager->get($parameters['connection']);
//		$queryBuilder = $this->queryBuilderManager->get($parameters['queryBuilder']);
//		$this->databaseWrappers[$name] = new DatabaseWrapper($connection, $queryBuilder);
//		return $this;
//	}
//
//	public function get($name)
//	{
//		return $this->databaseWrappers[$name];
//	}

	public function setConnection($name, Abstractory\IConnection $connection)
	{
		$this->connections[$name] = $connection;
		return $this;
	}

	public function getConnection($name)
	{
		return $this->connections[$name];
	}

	public function setQueryBuilder($name, Abstractory\IQueryBuilderFactory $queryBuilder)
	{
		$this->queryBuilders[$name] = $queryBuilder;
		return $this;
	}

	public function getQueryBuilder($name)
	{
		return $this->queryBuilders[$name];
	}
}
