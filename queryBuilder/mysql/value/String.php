<?php
namespace PHPMySql\QueryBuilder\MySql\Value;

use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue;

class String extends MySqlValue
{
	protected $value;

	public function __toString()
	{
		return sprintf('"%s"', $this->escapeString($this->value));
	}

	public function setValue($string)
	{
		$this->value = (string)$string;
	}
}