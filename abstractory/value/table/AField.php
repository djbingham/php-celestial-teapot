<?php
namespace PHPMySql\Abstractory\Value\Table;

use PHPMySql\Abstractory\AValue;
use PHPMySql\Abstractory\Value\ATable;

abstract class AField extends AValue
{
	/**
	 * @param ATable $table
	 * @return $this
	 */
	abstract public function setTable(ATable $table);

	/**
	 * @param $fieldName
	 * @return $this
	 */
	abstract public function setFieldName($fieldName);
}