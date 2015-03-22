<?php
namespace PHPMySql\QueryBuilder\MySql\Value;

use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue;

class Table extends MySqlValue
{
	protected $tableName;
	protected $fields = array();
	protected $data;

	public function __toString()
	{
		return sprintf('`%s`', $this->escapeString($this->tableName));
	}

	/**
	 * @param string $tableName
	 * @return Table $this
	 */
	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
		return $this;
	}

	public function getTableName()
	{
		return $this->tableName;
	}

	/**
	 * Obtain a MySql\_Value\Table\Field instance for a field of this table
	 * @param string $fieldName
	 * @return Table\Field
	 */
	public function field($fieldName)
	{
		if (!array_key_exists($fieldName, $this->fields)) {
			$field = new Table\Field();
			$field->setDatabaseWrapper($this->getDatabaseWrapper());
			$field->setTable($this);
			$field->setFieldName($fieldName);
			$this->fields[$fieldName] = $field;
		}
		return $this->fields[$fieldName];
	}

	/**
	 * @return Table\Data
	 */
	public function data()
	{
		if (!$this->data instanceof Table\Data) {
			$this->data = new Table\Data();
			$this->data->setNullValue($this->getDatabaseWrapper()->queryBuilder()->value()->sqlConstant('NULL'));
		}
		return $this->data;
	}
}
