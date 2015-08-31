<?php
namespace SlothMySql\Face\Query;

use SlothMySql\Face\QueryInterface;
use SlothMySql\Face\ValueInterface;
use SlothMySql\Face\Value\TableInterface;

interface SelectInterface extends QueryInterface
{
	/**
	 * @param ValueInterface $field
	 * @return $this
	 */
	public function field(ValueInterface $field);

	/**
	 * @param array $fields
	 * @return $this
	 */
	public function setFields(array $fields);

	/**
	 * @return array
	 */
	public function getFields();

	/**
	 * @param TableInterface $table
	 * @return $this
	 */
	public function from(TableInterface $table);

	/**
	 * @param array $tables
	 * @return $this
	 */
	public function setTables(array $tables);

	/**
	 * @return array
	 */
	public function getTables();

	/**
	 * @param JoinInterface $join
	 * @return $this
	 */
	public function join(JoinInterface $join);

	/**
	 * @param array $joins
	 * @return $this
	 */
	public function setJoins(array $joins);

	/**
	 * @return array
	 */
	public function getJoins();

	/**
	 * @param ConstraintInterface $constraint
	 * @return $this
	 */
	public function where(ConstraintInterface $constraint);

	/**
	 * @param ConstraintInterface $constraint
	 * @return $this
	 * @throws \Exception
	 */
	public function andWhere(ConstraintInterface $constraint);

	/**
	 * @param ConstraintInterface $constraint
	 * @return $this
	 * @throws \Exception
	 */
	public function orWhere(ConstraintInterface $constraint);

	/**
	 * @param ConstraintInterface $constraint
	 * @return $this
	 */
	public function setConstraint(ConstraintInterface $constraint);

	/**
	 * @return ConstraintInterface
	 */
	public function getConstraint();

	/**
	 * @param ValueInterface $clause
	 * @param bool $prioritise
	 * @return $this
	 * @throws \Exception
	 */
	public function orderBy(ValueInterface $clause, $prioritise = FALSE);

	/**
	 * @param array $orders
	 * @return $this
	 */
	public function setOrders(array $orders);

	/**
	 * @return array
	 */
	public function getOrders();

	/**
	 * @param ValueInterface $clause
	 * @param bool $prioritise
	 * @return $this
	 * @throws \Exception
	 */
	public function groupBy(ValueInterface $clause, $prioritise = FALSE);

	/**
	 * @param array $groups
	 * @return $this
	 */
	public function setGroups(array $groups);

	/**
	 * @return array
	 */
	public function getGroups();
}
