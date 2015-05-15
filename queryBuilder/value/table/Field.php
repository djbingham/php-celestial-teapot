<?php
namespace SlothMySql\QueryBuilder\Value\Table;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;
use SlothMySql\QueryBuilder\Value;

class Field extends MySqlValue
{
	protected $table;
	protected $fieldName;

	public function __toString()
	{
		$field = '';
		if ($this->table instanceof Value\Table) {
			$field .= (string)$this->table . '.';
		}
		$field .= '`'.$this->escapeString($this->fieldName).'`';
		return $field;
	}

	/**
	 * @param Value\Table $table
	 * @return Field $this
	 */
	public function setTable(Value\Table $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param $fieldName
	 * @return Field $this
	 */
	public function setFieldName($fieldName)
	{
		$this->fieldName = $fieldName;
		return $this;
	}
}