<?php
namespace PHPMySql\Test\Utility\Mock;

use PHPMySql\Abstractory;

class Value extends Abstractory\Value
{
    public function __toString()
	{
		return '"Sample Value"';
	}
}
