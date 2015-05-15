<?php
namespace SlothMySql\Test\Utility\Mock;

use SlothMySql\Abstractory;

class Value extends Abstractory\AValue
{
    public function __toString()
	{
		return '"Sample Value"';
	}

	public function escapeString($string)
	{
		return parent::escapeString($string);
	}
}
