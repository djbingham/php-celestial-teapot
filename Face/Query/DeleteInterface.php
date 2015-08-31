<?php
namespace SlothMySql\Face\Query;

use SlothMySql\Face\QueryInterface;
use SlothMySql\Face\Value\TableInterface;

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