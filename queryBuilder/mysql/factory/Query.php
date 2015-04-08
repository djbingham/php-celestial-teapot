<?php

namespace PHPMySql\QueryBuilder\MySql\Factory;

use PHPMySql\Abstractory\AFactory;
use PHPMySql\Abstractory\IQueryFactory;
use PHPMySql\QueryBuilder\MySql;

class Query extends AFactory implements IQueryFactory
{
	public function select()
	{
		$query = new MySql\Query\Select($this->connection);
		return $query;
	}

	public function insert()
	{
		$query = new MySql\Query\Insert($this->connection);
		return $query;
	}

	public function replace()
	{
		$query = new MySql\Query\Insert($this->connection);
		$query->setConnection($this->connection)
			->replaceRows();
		return $query;
	}

	public function update()
	{
		$query = new MySql\Query\Update($this->connection);
		return $query;
	}

	public function delete()
	{
		$query = new MySql\Query\Delete($this->connection);
		return $query;
	}

	public function join()
	{
		return new MySql\Factory\Join($this->connection);
	}

	public function constraint()
	{
		return new MySql\Query\Constraint($this->connection);
	}
}
