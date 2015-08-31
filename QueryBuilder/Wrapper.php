<?php
namespace SlothMySql\QueryBuilder;

use SlothMySql\Face\QueryInterface;
use SlothMySql\Face\QueryBuilderFactoryInterface;
use SlothMySql\Abstractory\AFactory;

class Wrapper extends AFactory implements QueryBuilderFactoryInterface
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
