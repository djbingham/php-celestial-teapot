<?php
namespace PHPMySql\Test\Mock;

use PHPMySql\Abstractory;

class DatabaseQuery extends Abstractory\Query
{
	public function __toString()
	{
		return 'Sample Query';
	}
}
