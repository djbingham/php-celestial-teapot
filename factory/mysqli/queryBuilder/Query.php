<?php

namespace PHPMySql\Factory\MySqli\QueryBuilder;

use PHPMySql\Factory\SubFactory;
use PHPMySql\Factory\MySqli\QueryBuilder;

class Query extends SubFactory
{
	public function select()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Select();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function insert()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Insert();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function replace()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Insert();
		$query->setDatabaseWrapper($this->database->wrapper())
			->replaceRows();
		return $query;
	}

	public function update()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Update();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function delete()
	{
		$query = new \PHPMySql\QueryBuilder\MySql\Query\Delete();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function join()
	{
		return new QueryBuilder\Join();
	}

	public function constraint()
	{
		return new \PHPMySql\QueryBuilder\MySql\Query\Constraint();
	}
}
