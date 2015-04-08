<?php
namespace PHPMySql\Test\Utility\Mock;

use PHPMySql\Abstractory;

class Query extends Abstractory\AQuery
{
	public function __toString()
	{
		return 'Sample Query';
	}

	public function escapeString($string)
	{
		return parent::escapeString($string);
	}
}
