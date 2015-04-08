<?php
namespace PHPMySql\Abstractory\Value;

use PHPMySql\Abstractory\AValue;
use PHPMySql\Abstractory\Value\Table\AData;
use PHPMySql\Abstractory\Value\Table\AField;

abstract class ATable extends AValue
{
	/**
	 * @param string $tableName
	 * @return $this
	 */
	abstract public function setTableName($tableName);

	/**
	 * @return string
	 */
	abstract public function getTableName();

	/**
	 * @param string $fieldName
	 * @return AField
	 */
	abstract public function field($fieldName);

	/**
	 * @return AData
	 */
	abstract public function data();
}
