<?php
namespace PHPMySql\Test\Mock;

use PHPMySql\Abstractory;

class DatabaseQueryBuilder extends Abstractory\QueryBuilder
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
