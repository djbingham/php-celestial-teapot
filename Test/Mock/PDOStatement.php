<?php
namespace SlothMySql\Test\Mock;

class PDOStatement extends \PDOStatement
{
	public function __construct()
	{
		// Parent class cannot be unserialized, so PHPUnit's disableOriginalConstructor doesn't work.
		// Therefore, we mock this child class instead, with the constructor empty to "disable" it.
	}
}
