<?php
namespace PhpMySql\QueryBuilder\Query;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\Query\ConstraintInterface;
use PhpMySql\Face\Query\UpdateInterface;
use PhpMySql\Face\Value\Table\DataInterface;
use PhpMySql\Face\Value\Table\FieldInterface;
use PhpMySql\Face\Value\TableInterface;
use PhpMySql\Face\ValueInterface;
use PhpMySql\QueryBuilder\Value\Table;

class Update implements UpdateInterface
{
	use QueryElementTrait;

	/**
	 * @var TableInterface
	 */
	protected $table;

	/**
	 * @var array
	 */
	protected $fields = array();

	/**
	 * @var array
	 */
	protected $values = array();

	/**
	 * @var ConstraintInterface
	 */
	protected $constraint;

	public function __toString()
	{
		return sprintf("UPDATE %s\nSET %s\nWHERE %s", $this->table, $this->buildDataString(), $this->constraint);
	}

	/**
	 * @param TableInterface $table
	 * @return Update $this
	 */
	public function table(TableInterface $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @return TableInterface
	 */
	public function getTable()
	{
		return $this->table;
	}

	/**
	 * @param FieldInterface $field
	 * @param ValueInterface $value
	 * @return Update $this
	 */
	public function set(FieldInterface $field, ValueInterface $value)
	{
		$fieldIndex = $this->getFieldIndex($field);
		$this->fields[$fieldIndex] = $field;
		$this->values[$fieldIndex] = $value;
		return $this;
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
	 * @param DataInterface $tableData
	 * @return UpdateInterface $this
	 * @throws \Exception
	 */
	public function data(DataInterface $tableData)
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
	 * @return DataInterface
	 */
	public function getData()
	{
		$fields = $this->getFields();
		$values = $this->getValues();
		$data = new Table\Data();
		$data->beginRow();
		foreach ($values as $index => $value) {
		    $data->set($fields[$index], $value);
		}
		$data->endRow();
		return $data;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return Update $this
	 */
	public function where(ConstraintInterface $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}

	protected function buildDataString()
	{
		$assignmentStrings = array();
		foreach ($this->fields as $i => $field) {
			$assignmentStrings[] = sprintf('%s = %s', (string)$field, (string)$this->values[$i]);
		}
		return implode(",\n\t", $assignmentStrings);
	}

	protected function getFieldIndex(FieldInterface $testField)
	{
		foreach ($this->fields as $i => $field) {
			if ((string)$field == (string)$testField) {
				return $i;
			}
		}
		return count($this->fields);
	}
}
