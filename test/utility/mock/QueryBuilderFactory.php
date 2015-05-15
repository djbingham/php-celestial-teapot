<?php
namespace SlothMySql\Test\Utility\Mock;

use SlothMySql\Abstractory\IQueryBuilderFactory;

class QueryBuilderFactory implements IQueryBuilderFactory
{
	public function query()
	{
		return new DatabaseQuery();
	}

	public function value()
	{
		return new DatabaseValue();
	}
}
