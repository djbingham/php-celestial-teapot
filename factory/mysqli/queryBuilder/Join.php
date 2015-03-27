<?php

namespace PHPMySql\Factory\MySqli\QueryBuilder;

class Join
{
	public function inner()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join;
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_INNER);
	}

	public function outer()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join;
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_OUTER);
	}

	public function left()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join;
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_LEFT);
	}

	public function right()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join;
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_RIGHT);
	}
}
