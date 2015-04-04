<?php
namespace PHPMySql\QueryBuilder\MySql;

use PHPMySql\Abstractory\IQueryBuilderFactory;
use PHPMySql\Abstractory\Factory as AbstractFactory;

class Factory extends AbstractFactory implements IQueryBuilderFactory
{
	public function value()
	{
		$valueFactory = $this->getCache('valueFactory');
		if (is_null($valueFactory)) {
			$valueFactory = new Factory\Value($this->connection);
			$this->setCache('valueFactory', $valueFactory);
		}
		return $valueFactory;
	}

	public function query()
	{
		$queryFactory = $this->getCache('queryFactory');
		if (is_null($queryFactory)) {
			$queryFactory = new Factory\Query($this->connection);
			$this->setCache('queryFactory', $queryFactory);
		}
		return $queryFactory;
	}
}
