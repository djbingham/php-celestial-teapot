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

	/**
	 * @var array
	 */
	private $databaseWrappers = array();

	public function __construct(Connection\Manager $connectionManager, QueryBuilder\Manager $queryBuilderManager)
	{
		$this->connectionManager = $connectionManager;
		$this->queryBuilderManager = $queryBuilderManager;
	}

	public function set($name, array $parameters)
	{
		$connection = $this->connectionManager->get($parameters['connection']);
		$queryBuilder = $this->queryBuilderManager->get($parameters['queryBuilder']);
		$this->databaseWrappers[$name] = new DatabaseWrapper($connection, $queryBuilder);
		return $this;
	}

	public function get($name)
	{
		return $this->databaseWrappers[$name];
	}
}
