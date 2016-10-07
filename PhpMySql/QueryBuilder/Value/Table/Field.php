<?php
namespace PhpMySql\QueryBuilder\Value\Table;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\Value\Table\FieldInterface;
use PhpMySql\Face\Value\TableInterface;
use PhpMySql\QueryBuilder\Value;

class Field implements FieldInterface
{
	use QueryElementTrait;

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
	 * @param TableInterface $table
	 * @return Field $this
	 */
	public function setTable(TableInterface $table)
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