<?php

namespace PHPMySql\QueryBuilder\MySql\Factory;

use PHPMySql\Abstractory\Factory;

class Query extends Factory
{
	public function select()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Select();
		$query->setConnection($this->connection);
		return $query;
	}

	public function insert()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Insert();
		$query->setConnection($this->connection);
		return $query;
	}

	public function replace()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Insert();
		$query->setConnection($this->connection)
			->replaceRows();
		return $query;
	}

	public function update()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Update();
		$query->setConnection($this->connection);
		return $query;
	}

	public function delete()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Delete();
		$query->setConnection($this->connection);
		return $query;
	}

	public function join()
	{
		return new \PHPMySql\QueryBuilder\MySql\Factory\Join($this->connection);
	}

	public function constraint()
	{
		return new \PHPMySql\QueryBuilder\MySql\Query\Constraint();
	}
}
