<?php
namespace SlothMySql\Face\Value;

use SlothMySql\Face\Value\Table\DataInterface;
use SlothMySql\Face\Value\Table\FieldInterface;
use SlothMySql\Face\ValueInterface;

interface TableInterface extends ValueInterface
{
	/**
	 * @param string $tableName
	 * @return $this
	 */
	public function setTableName($tableName);

	/**
	 * @return string
	 */
	public function getTableName();

	/**
	 * @param string $alias
	 * @return $this
	 */
	public function setAlias($alias);

	/**
	 * @param string $fieldName
	 * @return FieldInterface
	 */
	public function field($fieldName);

	/**
	 * @return DataInterface
	 */
	public function data();
}
