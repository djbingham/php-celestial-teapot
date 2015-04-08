<?php
namespace PHPMySql\Test\QueryBuilder\MySql;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;

class MySqlQueryTest extends UnitTest
{
	public function testEscapeString()
	{
		$testString = 'String to escape';
		$escapedString = 'Escaped string';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->once())
			->method('escapeString')
			->with($testString)
			->will($this->returnValue($escapedString));
		$object = $this->mock()->databaseQuery($connection);
		$output = $object->escapeString($testString);
		$this->assertEquals($escapedString, $output);
	}
}
