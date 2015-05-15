<?php

namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;

class ValueList extends MySqlValue
{
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
	 * @param MySqlValue $value
	 * @return ValueList $this
	 */
	public function appendValue(MySqlValue $value)
	{
		$this->values[] = $value;
		return $this;
	}
}