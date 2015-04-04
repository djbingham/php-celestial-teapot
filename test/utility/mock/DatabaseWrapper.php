<?php
namespace PHPMySql\Test\Utility\Mock;

use PHPMySql;

class DatabaseWrapper extends PHPMySql\DatabaseWrapper
{
    public function escapeString($string)
	{
		return $string;
	}
}
