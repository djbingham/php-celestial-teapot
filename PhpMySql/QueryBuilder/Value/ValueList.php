<?php

namespace PhpMySql\QueryBuilder\Value;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\Value\ValueListInterface;
use PhpMySql\Face\ValueInterface;

class ValueList implements ValueListInterface
{
	use QueryElementTrait;

	protected $values;

	public function __toString()
	{
		return sprintf('(%s)', implode(',', $this->values));
	}

	/**
	 * @param array $values
	 * @return ValueList $this
	 */
	public function setValues(array $values)
	{
		foreach ($values as $value) {
			$this->appendValue($value);
		}
		return $this;
	}

	/**
	 * @param ValueInterface $value
	 * @return ValueList $this
	 */
	public function appendValue(ValueInterface $value)
	{
		$this->values[] = $value;
		return $this;
	}
}