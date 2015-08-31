<?php

namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\Value\ValueListInterface;
use SlothMySql\Face\ValueInterface;

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