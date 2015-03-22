<?php
namespace PHPMySql\QueryBuilder\MySql\Factory;

use PHPMySql\DatabaseWrapper;
use Database\QueryBuilder\MySql;

class Query
{
	/**
	 * @var DatabaseWrapper
	 */
	protected $databaseWrapper;

	/**
	 * @param DatabaseWrapper $databaseWrapper
	 * @return Query $this
	 */
	public function setDatabaseWrapper(DatabaseWrapper $databaseWrapper)
	{
		$this->databaseWrapper = $databaseWrapper;
		return $this;
	}

	/**
	 * @return DatabaseWrapper
	 */
	public function getDatabaseWrapper()
	{
		return $this->databaseWrapper;
	}

	public function hasDatabaseWrapper()
	{
		return $this->databaseWrapper instanceof DatabaseWrapper;
	}

	/**
	 * @return MySql\Query\Select
	 */
	public function select()
	{
		return new MySql\Query\Select();
	}

	/**
	 * @return MySql\Query\Insert
	 */
	public function insert()
	{
		return new MySql\Query\Insert();
	}

	/**
	 * @return MySql\Query\Update
	 */
	public function update()
	{
		return new MySql\Query\Update();
	}

	/**
	 * @return MySql\Query\Delete
	 */
	public function delete()
	{
		return new MySql\Query\Delete();
	}

	/**
	 * @return MySql\Query\Join
	 */
	public function join()
	{
		return new MySql\Query\Join();
	}

	/**
	 * @return MySql\Query\Constraint
	 */
	public function constraint()
	{
		return new MySql\Query\Constraint();
	}
}
