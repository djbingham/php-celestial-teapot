<?php
namespace PHPMySql\Factory\MySqli;

use PHPMySql\Factory\SubFactory;

class QueryBuilder extends SubFactory
{
	public function value()
	{
		$valueFactory = $this->getCache('valueFactory');
		if (is_null($valueFactory)) {
			$valueFactory = new QueryBuilder\Value($this->database);
			$this->setCache('valueFactory', $valueFactory);
		}
		return $valueFactory;
	}

	public function query()
	{
		$queryFactory = $this->getCache('queryFactory');
		if (is_null($queryFactory)) {
			$queryFactory = new QueryBuilder\Query($this->database);
			$this->setCache('queryFactory', $queryFactory);
		}
		return $queryFactory;
	}

	public function join()
	{
		$joinFactory = $this->getCache('joinFactory');
		if (is_null($joinFactory)) {
			$joinFactory = new QueryBuilder\Join($this->database);
			$this->setCache('joinFactory', $joinFactory);
		}
		return $joinFactory;
	}
}
