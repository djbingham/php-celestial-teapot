<?php
namespace PHPMySql\Abstractory\Query;

use PHPMySql\Abstractory\AQuery;
use PHPMySql\Abstractory\AValue;
use PHPMySql\Abstractory\Value\ATable;

abstract class ASelect extends AQuery
{
	/**
	 * @param AValue $field
	 * @return $this
	 */
	abstract public function field(AValue $field);

	/**
	 * @param array $fields
	 * @return $this
	 */
	abstract public function setFields(array $fields);

	/**
	 * @return array
	 */
	abstract public function getFields();

	/**
	 * @param ATable $table
	 * @return $this
	 */
	abstract public function from(ATable $table);

	/**
	 * @param array $tables
	 * @return $this
	 */
	abstract public function setTables(array $tables);

	/**
	 * @return array
	 */
	abstract public function getTables();

	/**
	 * @param AJoin $join
	 * @return $this
	 */
	abstract public function join(AJoin $join);

	/**
	 * @param array $joins
	 * @return $this
	 */
	abstract public function setJoins(array $joins);

	/**
	 * @return array
	 */
	abstract public function getJoins();

	/**
	 * @param AConstraint $constraint
	 * @return $this
	 */
	abstract public function where(AConstraint $constraint);

	/**
	 * @param AConstraint $constraint
	 * @return $this
	 * @throws \Exception
	 */
	abstract public function andWhere(AConstraint $constraint);

	/**
	 * @param AConstraint $constraint
	 * @return $this
	 * @throws \Exception
	 */
	abstract public function orWhere(AConstraint $constraint);

	/**
	 * @param AConstraint $constraint
	 * @return $this
	 */
	abstract public function setConstraint(AConstraint $constraint);

	/**
	 * @return AConstraint
	 */
	abstract public function getConstraint();

	/**
	 * @param AValue $clause
	 * @param bool $prioritise
	 * @return $this
	 * @throws \Exception
	 */
	abstract public function orderBy(AValue $clause, $prioritise = FALSE);

	/**
	 * @param array $orders
	 * @return $this
	 */
	abstract public function setOrders(array $orders);

	/**
	 * @return array
	 */
	abstract public function getOrders();

	/**
	 * @param AValue $clause
	 * @param bool $prioritise
	 * @return $this
	 * @throws \Exception
	 */
	abstract public function groupBy(AValue $clause, $prioritise = FALSE);

	/**
	 * @param array $groups
	 * @return $this
	 */
	abstract public function setGroups(array $groups);

	/**
	 * @return array
	 */
	abstract public function getGroups();
}
