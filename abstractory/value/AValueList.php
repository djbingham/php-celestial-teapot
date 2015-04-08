<?php
namespace PHPMySql\Abstractory\Value;

use PHPMySql\Abstractory\AValue;

abstract class AValueList extends AValue
{
	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function appendValue(AValue $value);

	/**
	 * @param array $values
	 * @return $this
	 */
	abstract public function setValues(array $values);
}
