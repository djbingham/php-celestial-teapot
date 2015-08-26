<?php
namespace SlothMySql\Abstractory\Query;

use SlothMySql\Abstractory\AQuery;
use SlothMySql\Abstractory\Value\ATable;

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