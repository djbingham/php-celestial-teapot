<?php
namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;

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
			$field = new Table\Field($this->getConnection());
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
			$this->data = new Table\Data($this->getConnection());
			$nullValue = new Constant($this->getConnection());
			$nullValue->setValue('NULL');
			$this->data->setNullValue($nullValue);
		}
		return $this->data;
	}
}
