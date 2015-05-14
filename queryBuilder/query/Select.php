<?php
namespace PHPMySql\QueryBuilder\Query;

use PHPMySql\QueryBuilder\Abstractory\MySqlQuery;
use PHPMySql\QueryBuilder\Abstractory\MySqlValue;
use PHPMySql\QueryBuilder\Value\Table;

class Select extends MySqlQuery
{
	protected $fields = array();
	protected $tables = array();
	protected $joins = array();
	/**
	 * @var Constraint
	 */
	protected $constraint;
	protected $orders = array();
	protected $groups = array();

	public function __toString()
	{
		$queryString = sprintf("SELECT %s", implode(',', $this->fields));
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

	/**
	 * @param MySqlValue $field
	 * @return Select $this
	 */
	public function field(MySqlValue $field)
	{
		$this->fields[] = $field;
		return $this;
	}

	/**
	 * @param array $fields
	 * @return Select $this
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
	 * @param Table $table
	 * @return Select $this
	 */
	public function from(Table $table)
	{
		$this->tables[] = $table;
		return $this;
	}

	/**
	 * @param array $tables
	 * @return Select $this
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
	 * @param Join $join
	 * @return Select $this
	 */
	public function join(Join $join)
	{
		$this->joins[] = $join;
		return $this;
	}

	/**
	 * @param array $joins
	 * @return Select $this
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
	 * @param Constraint $constraint
	 * @return Select $this
	 */
	public function where(Constraint $constraint)
	{
		if ($this->constraint instanceof Constraint) {
			$this->constraint->andWhere($constraint);
		}
		else {
			$this->constraint = $constraint;
		}
		return $this;
	}

	/**
	 * @param Constraint $constraint
	 * @return Select $this
	 * @throws \Exception
	 */
	public function andWhere(Constraint $constraint) {
		if ($this->constraint instanceof Constraint) {
			$this->constraint->andWhere($constraint);
		}
		else {
			throw new \Exception('Cannot call andWhere with no previous constraint set');
		}
		return $this;
	}

	/**
	 * @param Constraint $constraint
	 * @return Select $this
	 * @throws \Exception
	 */
	public function orWhere(Constraint $constraint)
	{
		if ($this->constraint instanceof Constraint) {
			$this->constraint->orWhere($constraint);
		}
		else {
			throw new \Exception('Cannot call orWhere with no previous constraint set');
		}
		return $this;
	}

	/**
	 * @param Constraint $constraint
	 * @return Select $this
	 */
	public function setConstraint(Constraint $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}

	/**
	 * @return Constraint
	 */
	public function getConstraint()
	{
		return $this->constraint;
	}

	/**
	 * @param MySqlValue $clause
	 * @param bool $prioritise
	 * @return Select $this
	 * @throws \Exception
	 */
	public function orderBy(MySqlValue $clause, $prioritise = FALSE)
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
	 * @param MySqlValue $clause
	 * @param bool $prioritise
	 * @return Select $this
	 * @throws \Exception
	 */
	public function groupBy(MySqlValue $clause, $prioritise = FALSE)
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
