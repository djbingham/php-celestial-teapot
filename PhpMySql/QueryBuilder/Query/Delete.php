<?php
namespace PhpMySql\QueryBuilder\Query;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\Query\ConstraintInterface;
use PhpMySql\Face\Query\DeleteInterface;
use PhpMySql\Face\Value\TableInterface;

class Delete implements DeleteInterface
{
	use QueryElementTrait;

	/**
	 * @var TableInterface
	 */
	protected $table;

	/**
	 * @var ConstraintInterface
	 */
	protected $constraint;

	public function __toString()
	{
		$str = "DELETE FROM {$this->table}";
		if (!empty($this->constraint)) {
			$str .= sprintf("\nWHERE %s", (string)$this->constraint);
		}
		return $str;
	}

	/**
	 * @param TableInterface $table
	 * @return Delete $this
	 */
	public function from(TableInterface $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return Delete $this
	 */
	public function where(ConstraintInterface $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}
}