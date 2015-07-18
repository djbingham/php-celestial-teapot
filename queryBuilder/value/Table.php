<?php
namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;

class Table extends MySqlValue
{
	protected $tableName;
	protected $alias;
	protected $fields = array();
	protected $data;

	public function __toString()
	{
		$table = sprintf('`%s`', $this->escapeString($this->tableName));
		if (isset($this->alias) && $this->alias !== null) {
			$table .= sprintf(' AS `%s`', $this->escapeString($this->alias));
		}
		return $table;
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

	/**
	 * @return string
	 */
	public function getTableName()
	{
		return $this->tableName;
	}

	/**
	 * @param string $alias
	 * @return $this
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAlias()
	{
		if ($this->alias !== null) {
			$alias = $this->alias;
		} else {
			$alias = $this->tableName;
		}
		return $alias;
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
