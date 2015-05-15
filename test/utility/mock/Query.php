<?php
namespace SlothMySql\Test\Utility\Mock;

use SlothMySql\Abstractory;

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
