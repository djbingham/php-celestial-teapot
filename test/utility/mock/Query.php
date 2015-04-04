<?php
namespace PHPMySql\Test\Utility\Mock;

use PHPMySql\Abstractory;

class Query extends Abstractory\Query
{
	public function __toString()
	{
		return 'Sample Query';
	}
}
