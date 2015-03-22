<?php
namespace PHPMySql\Test\Mock;

use PHPMySql;

class DatabaseWrapper extends PHPMySql\DatabaseWrapper
{
    public function escapeString($string)
	{
		return $string;
	}
}
