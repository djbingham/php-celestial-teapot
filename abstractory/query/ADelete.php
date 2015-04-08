<?php
namespace PHPMySql\Abstractory\Query;

use PHPMySql\Abstractory\AQuery;
use PHPMySql\Abstractory\Value\ATable;

abstract class ADelete extends AQuery
{
	/**
	 * @param ATable $table
	 * @return $this
	 */
	abstract public function from(ATable $table);

	/**
	 * @param AConstraint $constraint
	 * @return $this
	 */
	abstract public function where(AConstraint $constraint);
}