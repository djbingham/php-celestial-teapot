<?php
namespace PHPMySql\QueryBuilder\MySql\Query;

use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlQuery;
use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue;
use PHPMySql\QueryBuilder\MySql\Value\Table\Data;
use PHPMySql\QueryBuilder\MySql\Value\Table\Field;
use PHPMySql\QueryBuilder\MySql\Value\Table;

class Update extends MySqlQuery
{
	protected $table;
	protected $fields = array();
	protected $values = array();
	protected $constraint;

	public function __toString()
	{
		return sprintf("UPDATE %s\nSET %s\nWHERE %s", $this->table, $this->dataString(), $this->constraint);
	}

	protected function dataString()
	{
		$assignmentStrings = array();
		foreach ($this->fields as $i => $field) {
			$assignmentStrings[] = sprintf('%s = %s', (string)$field, (string)$this->values[$i]);
		}
		return implode(",\n\t", $assignmentStrings);
	}

	/**
	 * @param Table $table
	 * @return Update $this
	 */
	public function table(Table $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param Field $field
	 * @param MySqlValue $value
	 * @return Update $this
	 */
	public function set(Field $field, MySqlValue $value)
	{
		$fieldIndex = $this->getFieldIndex($field);
		$this->fields[$fieldIndex] = $field;
		$this->values[$fieldIndex] = $value;
		return $this;
	}

	protected function getFieldIndex(Field $testField)
	{
		foreach ($this->fields as $i => $field) {
			if ((string)$field == (string)$testField) {
				return $i;
			}
		}
		return count($this->fields);
	}

	/**
	 * @return array
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @return array
	 */
	public function getValues()
	{
		return $this->values;
	}

	/**
	 * @param Data $tableData
	 * @return Update $this
	 * @throws \Exception
	 */
	public function data(Data $tableData)
	{
		$fields = $tableData->getFields();
		$rows = $tableData->getRows();
		$i = 0;
		foreach ($rows[0] as $value) {
			$this->set($fields[$i], $value);
			$i++;
		}
		return $this;
	}

	/**
	 * @param Constraint $constraint
	 * @return Update $this
	 */
	public function where(Constraint $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}
}
