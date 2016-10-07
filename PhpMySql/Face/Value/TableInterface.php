<?php
namespace PhpMySql\Face\Value;

use PhpMySql\Face\Value\Table\DataInterface;
use PhpMySql\Face\Value\Table\FieldInterface;
use PhpMySql\Face\ValueInterface;

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
