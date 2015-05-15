<?php
namespace SlothMySql\Test\QueryBuilder;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\Test\Abstractory\UnitTest;

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
