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
		$fieldString = '';
		if ($this->table instanceof Value\Table) {
			$fieldString .= sprintf('`%s`.', $this->escapeString($this->table->getAlias()));
		}
		$fieldString .= sprintf('`%s`', $this->escapeString($this->fieldName));
		return $fieldString;
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

	/**
	 * @return string
	 */
	public function getAlias()
	{
		return $this->alias;
	}
}