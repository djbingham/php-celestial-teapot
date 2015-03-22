<?php
namespace PHPMySql\Factory;

class MySqli extends SubFactory
{
	public function connection()
	{
		$connection = $this->getCache('connection');
		if (is_null($connection)) {
			$connection = new MySqli\Connection($this->database);
			$this->setCache('connection', $connection);

		}
		return $connection;
	}

	/**
	 * @return MySqli\QueryBuilder
	 */
	public function query()
	{
		$queryBuilder = $this->getCache('queryBuilder');
		if (is_null($queryBuilder)) {
			$queryBuilder = new MySqli\QueryBuilder($this->database);
			$this->setCache('queryBuilder', $queryBuilder);

		}
		return $queryBuilder;
	}
}
