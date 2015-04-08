<?php
namespace PHPMySql\Test\Utility\Mock;

use PHPMySql\Abstractory;

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
