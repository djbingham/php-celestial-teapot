<?php
namespace SlothMySql\Abstractory\Value\Table;

use SlothMySql\Abstractory\TQueryElement;
use SlothMySql\Abstractory\AValue;

abstract class AData
{
	use TQueryElement;

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function setNullValue(AValue $value);

	/**
	 * @return $this
	 */
	abstract public function getNullValue();

	/**
	 * @param null $index
	 * @return $this
	 */
	abstract public function beginRow($index = null);

	/**
	 * @return $this
	 */
	abstract public function getCurrentRowIndex();

	/**
	 * @param AField $field
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function set(AField $field, AValue $value);

	/**
	 * @return $this
	 */
	abstract public function getCurrentRow();

	/**
	 * @return $this
	 */
	abstract public function endRow();

	/**
	 * @return $this
	 */
	abstract public function getFields();

	/**
	 * @return $this
	 */
	abstract public function getRows();
}
