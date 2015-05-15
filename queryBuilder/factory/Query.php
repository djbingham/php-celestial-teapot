<?php

namespace SlothMySql\QueryBuilder\Factory;

use SlothMySql\Abstractory\AFactory;
use SlothMySql\Abstractory\IQueryFactory;
use SlothMySql\QueryBuilder;

class Query extends AFactory implements IQueryFactory
{
	public function select()
	{
		$query = new QueryBuilder\Query\Select($this->connection);
		return $query;
	}

	public function insert()
	{
		$query = new QueryBuilder\Query\Insert($this->connection);
		return $query;
	}

	public function replace()
	{
		$query = new QueryBuilder\Query\Insert($this->connection);
		$query->setConnection($this->connection)
			->replaceRows();
		return $query;
	}

	public function update()
	{
		$query = new QueryBuilder\Query\Update($this->connection);
		return $query;
	}

	public function delete()
	{
		$query = new QueryBuilder\Query\Delete($this->connection);
		return $query;
	}

	public function join()
	{
		return new QueryBuilder\Factory\Join($this->connection);
	}

	public function constraint()
	{
		return new QueryBuilder\Query\Constraint($this->connection);
	}
}
