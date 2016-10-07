<?php

namespace PhpMySql\QueryBuilder\Value;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\ValueInterface;

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