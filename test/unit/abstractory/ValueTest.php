<?php
namespace SlothMySql\Test\Unit\Database\Abstractory;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use SlothMySql\Test\Abstractory\UnitTest;

class ValueTest extends UnitTest
{
	public function testEscapeString()
	{
		$testString = 'Test string to be escaped';
		$escapedString = 'Escaped string';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->once())
			->method('escapeString')
			->with($testString)
			->will($this->returnValue($escapedString));

		$object = $this->mock()->databaseValue($connection);
		$output = $object->escapeString($testString);
		$this->assertEquals($escapedString, $output);
	}
}
