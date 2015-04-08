<?php

namespace PHPMySql\QueryBuilder\MySql\Factory;

use PHPMySql\Abstractory\AFactory;
use PHPMySql\Abstractory\IJoinFactory;

class Join extends AFactory implements IJoinFactory
{
	public function inner()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join($this->connection);
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_INNER);
	}

	public function outer()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join($this->connection);
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_OUTER);
	}

	public function left()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join($this->connection);
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_LEFT);
	}

	public function right()
	{
		$join = new \PHPMySql\QueryBuilder\MySql\Query\Join($this->connection);
		return $join->setType(\PHPMySql\QueryBuilder\MySql\Query\Join::TYPE_RIGHT);
	}
}
