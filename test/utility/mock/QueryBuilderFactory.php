<?php
namespace PHPMySql\Test\Utility\Mock;

use PHPMySql\Abstractory\IQueryBuilderFactory;

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
