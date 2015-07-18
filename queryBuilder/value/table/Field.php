<?php
namespace SlothMySql\QueryBuilder\Value\Table;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;
use SlothMySql\QueryBuilder\Value;

class Field extends MySqlValue
{
	protected $table;
	protected $fieldName;
	protected $alias;

	public function __toString()
	{
		$field = '';
		if ($this->table instanceof Value\Table) {
			$field .= sprintf('`%s`.', $this->escapeString($this->table->getAlias()));
		}
		$field .= '`'.$this->escapeString($this->fieldName).'`';
		if ($this->alias) {
			$field .= sprintf(' AS `%s`', $this->alias);
		}
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
	 * @param string $fieldName
	 * @return Field $this
	 */
	public function setFieldName($fieldName)
	{
		$this->fieldName = $fieldName;
		return $this;
	}

	/**
	 * @param string $alias
	 * @return Field $this
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;
		return $this;
	}
}