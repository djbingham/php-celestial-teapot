<?php

namespace PHPMySql\Factory\MySqli\QueryBuilder;

use PHPMySql\Factory\SubFactory;
use PHPMySql\Factory\MySqli\QueryBuilder;
use PHPMySql\QueryBuilder\MySql\Query;

class Query extends SubFactory
{
	public function select()
	{
		$query = new Query\Select();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function insert()
	{
		$query = new Query\Insert();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function replace()
	{
		$query = new Query\Insert();
		$query->setDatabaseWrapper($this->database->wrapper())
			->replaceRows();
		return $query;
	}

	public function update()
	{
		$query = new Query\Update();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function delete()
	{
		$query = new Query\Delete();
		$query->setDatabaseWrapper($this->database->wrapper());
		return $query;
	}

	public function join()
	{
		return new QueryBuilder\Join();
	}

	public function constraint()
	{
		return new Query\Constraint();
	}
}
