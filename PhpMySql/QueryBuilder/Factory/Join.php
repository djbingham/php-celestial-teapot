<?php

namespace PhpMySql\QueryBuilder\Factory;

use PhpMySql\Abstractory\AFactory;
use PhpMySql\Face\JoinFactoryInterface;

class Join extends AFactory implements JoinFactoryInterface
{
	public function inner()
	{
		$join = new \PhpMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\PhpMySql\QueryBuilder\Query\Join::TYPE_INNER);
	}

	public function outer()
	{
		$join = new \PhpMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\PhpMySql\QueryBuilder\Query\Join::TYPE_OUTER);
	}

	public function left()
	{
		$join = new \PhpMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\PhpMySql\QueryBuilder\Query\Join::TYPE_LEFT);
	}

	public function right()
	{
		$join = new \PhpMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\PhpMySql\QueryBuilder\Query\Join::TYPE_RIGHT);
	}
}
