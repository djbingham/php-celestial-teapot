<?php
namespace PhpMySql\QueryBuilder\Value;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\ValueInterface;

class Text implements ValueInterface
{
	use QueryElementTrait;

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