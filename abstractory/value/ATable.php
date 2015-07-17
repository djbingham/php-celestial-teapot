<?php
namespace SlothMySql\Abstractory\Value;

use SlothMySql\Abstractory\AValue;
use SlothMySql\Abstractory\Value\Table\AData;
use SlothMySql\Abstractory\Value\Table\AField;

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
	 * @param string $alias
	 * @return $this
	 */
	abstract public function withAlias($alias);

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
