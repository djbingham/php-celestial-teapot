<?php
namespace PhpMySql\QueryBuilder\Query;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\Query\ConstraintInterface;
use PhpMySql\Face\Query\JoinInterface;
use PhpMySql\Face\Query\SelectInterface;
use PhpMySql\Face\Value\Table\FieldInterface;
use PhpMySql\Face\Value\TableInterface;
use PhpMySql\Face\ValueInterface;
use PhpMySql\QueryBuilder\Value\Table;

class Select implements SelectInterface
{
	use QueryElementTrait;

	protected $fields = array();
	protected $tables = array();
	protected $joins = array();
	/**
	 * @var ConstraintInterface
	 */
	protected $constraint;
	protected $orders = array();
	protected $groups = array();

	public function __toString()
	{
		$queryString = sprintf("SELECT %s", implode(',', $this->getFieldStrings()));
		if (!empty($this->tables)) {
			$queryString .= sprintf("\nFROM %s", implode(',', $this->tables));
		}
		if (!empty($this->joins)) {
			$queryString .= sprintf("\n%s", implode("\n", $this->joins));
		}
		if (!empty($this->constraint)) {
			$queryString .= sprintf("\nWHERE %s", (string)$this->constraint);
		}
		if (!empty($this->orders)) {
			$queryString .= sprintf("\nORDER BY %s", implode(', ', $this->orders));
		}
		if (!empty($this->groups)) {
			$queryString .= sprintf("\nGROUP BY %s", implode(', ', $this->groups));
		}
		return $queryString;
	}

	private function getFieldStrings()
	{
		$fieldStrings = array();
		foreach ($this->fields as $field) {
			$fieldStrings[] = $this->getFieldStringWithAlias($field);
		}
		return $fieldStrings;
	}

	private function getFieldStringWithAlias(FieldInterface $field)
	{
		$fieldString = (string)$field;
		$fieldAlias = $field->getAlias();
		if (!empty($fieldAlias)) {
			$fieldString .= sprintf(' AS `%s`', $fieldAlias);
		}
		return $fieldString;
	}

	/**
	 * @param ValueInterface $field
	 * @return Select $this
	 */
	public function field(ValueInterface $field)
	{
		$this->fields[] = $field;
		return $this;
	}

	/**
	 * @param array $fields
	 * @return SelectInterface $this
	 */
	public function setFields(array $fields)
	{
		$this->fields = array();
		foreach ($fields as $field) {
			$this->field($field);
		}
		return $this;
	}

	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param TableInterface $table
	 * @return Select $this
	 */
	public function from(TableInterface $table)
	{
		$this->tables[] = $table;
		return $this;
	}

	/**
	 * @param array $tables
	 * @return SelectInterface $this
	 */
	public function setTables(array $tables)
	{
		$this->tables = array();
		foreach ($tables as $table) {
			$this->from($table);
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getTables()
	{
		return $this->tables;
	}

	/**
	 * @param JoinInterface $join
	 * @return SelectInterface $this
	 */
	public function join(JoinInterface $join)
	{
		$this->joins[] = $join;
		return $this;
	}

	/**
	 * @param array $joins
	 * @return SelectInterface $this
	 */
	public function setJoins(array $joins)
	{
		$this->joins = array();
		foreach ($joins as $join) {
			$this->join($join);
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getJoins()
	{
		return $this->joins;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return SelectInterface $this
	 */
	public function where(ConstraintInterface $constraint)
	{
		if ($this->constraint instanceof ConstraintInterface) {
			$this->constraint->andWhere($constraint);
		}
		else {
			$this->constraint = $constraint;
		}
		return $this;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return SelectInterface $this
	 * @throws \Exception
	 */
	public function andWhere(ConstraintInterface $constraint) {
		if ($this->constraint instanceof ConstraintInterface) {
			$this->constraint->andWhere($constraint);
		}
		else {
			throw new \Exception('Cannot call andWhere with no previous constraint set');
		}
		return $this;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return SelectInterface $this
	 * @throws \Exception
	 */
	public function orWhere(ConstraintInterface $constraint)
	{
		if ($this->constraint instanceof ConstraintInterface) {
			$this->constraint->orWhere($constraint);
		}
		else {
			throw new \Exception('Cannot call orWhere with no previous constraint set');
		}
		return $this;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return SelectInterface $this
	 */
	public function setConstraint(ConstraintInterface $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}

	/**
	 * @return ConstraintInterface
	 */
	public function getConstraint()
	{
		return $this->constraint;
	}

	/**
	 * @param ValueInterface $clause
	 * @param bool $prioritise
	 * @return SelectInterface $this
	 * @throws \Exception
	 */
	public function orderBy(ValueInterface $clause, $prioritise = FALSE)
	{
		if ($prioritise) {
			array_unshift($this->orders, $clause);
		}
		else {
			$this->orders[] = $clause;
		}
		return $this;
	}

	/**
	 * @param array $orders
	 * @return $this
	 */
	public function setOrders(array $orders)
	{
		$this->orders = array();
		foreach ($orders as $order) {
			$this->orderBy($order);
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getOrders()
	{
		return $this->orders;
	}

	/**
	 * @param ValueInterface $clause
	 * @param bool $prioritise
	 * @return Select $this
	 * @throws \Exception
	 */
	public function groupBy(ValueInterface $clause, $prioritise = FALSE)
	{
		if ($prioritise) {
			array_unshift($this->groups, $clause);
		}
		else {
			$this->groups[] = $clause;
		}
		return $this;
	}

	/**
	 * @param array $groups
	 * @return $this
	 */
	public function setGroups(array $groups)
	{
		$this->groups = array();
		foreach ($groups as $group) {
			$this->groupBy($group);
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getGroups()
	{
		return $this->groups;
	}
}
