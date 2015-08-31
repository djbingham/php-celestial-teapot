<?php

namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\ValueInterface;

class Number implements ValueInterface
{
	use QueryElementTrait;

	protected $value;

	public function __toString()
	{
		return sprintf('%s', $this->escapeString($this->value));
	}

	/**
	 * @param $number
	 * @throws \Exception
	 */
	public function setValue($number)
	{
		if (!is_numeric($number)) {
			throw new \Exception('Invalid (non-numeric) value');
		}
		$this->value = $number;
	}
}