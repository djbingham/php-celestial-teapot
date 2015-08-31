<?php
namespace SlothMySql\Face\Value;

use SlothMySql\Face\ValueInterface;

interface ValueListInterface extends ValueInterface
{
	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	function appendValue(ValueInterface $value);

	/**
	 * @param array $values
	 * @return $this
	 */
	function setValues(array $values);
}
