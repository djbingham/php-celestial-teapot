<?php
namespace PHPMySql\QueryBuilder;

use PHPMySql\Abstractory\IQueryBuilderFactory;

class Manager
{
	private $queryBuilders = array();

	public function set($name, IQueryBuilderFactory $queryBuilder)
	{
		$this->queryBuilders[$name] = $queryBuilder;
		return $this;
	}

	public function get($name)
	{
		if (!array_key_exists($name, $this->queryBuilders)) {
			throw new \Exception(sprintf('No query builder found with name: %s', $name));
		}
		return $this->queryBuilders[$name];
	}
}
