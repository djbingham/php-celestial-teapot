<?php
namespace PHPMySql\QueryBuilder\MySql\Factory;

use PHPMySql\QueryBuilder\MySql\Query;

class Join
{
	/**
	 * @return Query\Join
	 */
	public function inner()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_INNER);
	}

	/**
	 * @return Query\Join
	 */
	public function outer()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_OUTER);
	}

	/**
	 * @return Query\Join
	 */
	public function left()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_LEFT);
	}

	/**
	 * @return Query\Join
	 */
	public function right()
	{
		$join = new Query\Join;
		return $join->setType(Query\Join::TYPE_RIGHT);
	}
}
