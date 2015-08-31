<?php
namespace SlothMySql\Face\Query;

use SlothMySql\Face\QueryInterface;
use SlothMySql\Face\Value\TableInterface;

interface JoinInterface extends QueryInterface
{
	const TYPE_INNER = 'INNER';
	const TYPE_OUTER = 'OUTER';
	const TYPE_LEFT = 'LEFT';
	const TYPE_RIGHT = 'RIGHT';

	/**
	 * @param $type
	 * @return JoinInterface $this
	 * @throws \Exception
	 */
	public function setType($type);

	/**
	 * @return string
	 */
	public function getType();

	/**
	 * @param TableInterface $table
	 * @return JoinInterface $this
	 */
	public function table(TableInterface $table);

	/**
	 * @param string $alias
	 * @return JoinInterface $this
	 */
	public function withAlias($alias);

	/**
	 * @param ConstraintInterface $constraint
	 * @return JoinInterface $this
	 */
	public function on(ConstraintInterface $constraint);
}