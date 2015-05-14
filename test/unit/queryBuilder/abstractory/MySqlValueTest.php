<?php
namespace PHPMySql\Test\QueryBuilder;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;

class MySqlValueTest extends UnitTest
{
	public function testEscapeString()
	{
		$testString = 'String to escape';
		$escapedString = 'Escaped string';
		$wrapper = $this->mockBuilder()->connection();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($testString)
			->will($this->returnValue($escapedString));

		$object = $this->mock()->databaseValue($wrapper);
		$output = $object->escapeString($testString);
		$this->assertEquals($escapedString, $output);
	}
}
