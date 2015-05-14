<?php
namespace PHPMySql\QueryBuilder\Query;

use PHPMySql\QueryBuilder\Abstractory\MySqlQuery;
use PHPMySql\QueryBuilder\Value\Table;

class Delete extends MySqlQuery
{
	protected $table;
	protected $constraint;

	public function __toString()
	{
		$str = sprintf("DELETE FROM %s", (string)$this->table);
		if (!empty($this->constraint)) {
			$str .= sprintf("\nWHERE %s", (string)$this->constraint);
		}
		return $str;
	}

	/**
	 * @param Table $table
	 * @return Delete $this
	 */
	public function from(Table $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param Constraint $constraint
	 * @return Delete $this
	 */
	public function where(Constraint $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}
}