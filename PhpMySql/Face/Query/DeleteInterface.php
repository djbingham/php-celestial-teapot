<?php
namespace PhpMySql\Face\Query;

use PhpMySql\Face\QueryInterface;
use PhpMySql\Face\Value\TableInterface;

interface DeleteInterface extends QueryInterface
{
	/**
	 * @param TableInterface $table
	 * @return $this
	 */
	public function from(TableInterface $table);

	/**
	 * @param ConstraintInterface $constraint
	 * @return $this
	 */
	public function where(ConstraintInterface $constraint);
}