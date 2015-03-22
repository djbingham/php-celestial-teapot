<?php

namespace PHPMySql\Factory\MySqli\QueryBuilder;

use PHPMySql\QueryBuilder\MySql\Query;

class Join
{
	public function inner()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_INNER);
	}

	public function outer()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_OUTER);
	}

	public function left()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_LEFT);
	}

	public function right()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_RIGHT);
	}
}
