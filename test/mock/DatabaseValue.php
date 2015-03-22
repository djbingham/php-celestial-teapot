<?php
namespace PHPMySql\Test\Mock;

use PHPMySql\Abstractory;

class DatabaseValue extends Abstractory\Value
{
    public function __toString()
	{
		return '"Sample Value"';
	}
}
