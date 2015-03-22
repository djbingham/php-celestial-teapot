<?php

namespace PHPMySql\QueryBuilder\MySql\Value;

use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue;

class Number extends MySqlValue
{
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