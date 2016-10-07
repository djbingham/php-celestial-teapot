<?php
namespace PhpMySql\Face\Value;

use PhpMySql\Face\ValueInterface;

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
