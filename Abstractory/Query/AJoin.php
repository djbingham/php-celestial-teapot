<?php
namespace SlothMySql\Abstractory\Query;

use SlothMySql\Abstractory\AQuery;
use SlothMySql\Abstractory\Value\ATable;

abstract class AJoin extends AQuery
{
	const TYPE_INNER = 'INNER';
	const TYPE_OUTER = 'OUTER';
	const TYPE_LEFT = 'LEFT';
	const TYPE_RIGHT = 'RIGHT';

	/**
	 * @param $type
	 * @return AJoin $this
	 * @throws \Exception
	 */
	abstract public function setType($type);

	/**
	 * @return string
	 */
	abstract public function getType();

	/**
	 * @param ATable $table
	 * @return AJoin $this
	 */
	abstract public function table(ATable $table);

	/**
	 * @param string $alias
	 * @return AJoin $this
	 */
	abstract public function withAlias($alias);

	/**
	 * @param AConstraint $constraint
	 * @return AJoin $this
	 */
	abstract public function on(AConstraint $constraint);
}