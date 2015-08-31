<?php
namespace SlothMySql\QueryBuilder\Query;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\Query\ConstraintInterface;
use SlothMySql\Face\Query\UpdateInterface;
use SlothMySql\Face\Value\Table\DataInterface;
use SlothMySql\Face\Value\Table\FieldInterface;
use SlothMySql\Face\Value\TableInterface;
use SlothMySql\Face\ValueInterface;
use SlothMySql\QueryBuilder\Value\Table;

class Update implements UpdateInterface
{
	use QueryElementTrait;

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
	 * @param TableInterface $table
	 * @return Update $this
	 */
	public function table(TableInterface $table)
	{
		$this->table = $table;
		return $this;
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

	protected function getFieldIndex(FieldInterface $testField)
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
	 * @param ConstraintInterface $constraint
	 * @return Update $this
	 */
	public function where(ConstraintInterface $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}
}
