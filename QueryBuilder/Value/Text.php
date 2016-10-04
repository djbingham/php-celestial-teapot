<?php
namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\ValueInterface;

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