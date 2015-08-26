<?php
namespace SlothMySql\QueryBuilder;

use SlothMySql\Abstractory\AQuery;
use SlothMySql\Abstractory\IQueryBuilderFactory;
use SlothMySql\Abstractory\AFactory;

class Wrapper extends AFactory implements IQueryBuilderFactory
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
