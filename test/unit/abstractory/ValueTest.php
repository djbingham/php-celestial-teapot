<?php
namespace PHPMySql\Test\Unit\Database\Abstractory;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;
use PHPMySql\Abstractory\Value;

class ValueTest extends UnitTest
{
	/**
	 * @var Value
	 */
	protected $object;

	public function setUp()
	{
		$this->object = $this->mock()->databaseValue();
	}

	public function testSetGetAndHasDatabaseWrapper()
	{
		$connection = $this->mockBuilder()->connection();
		$setterOutput = $this->object->setConnection($connection);
		$this->assertEquals($this->object, $setterOutput);
		$getterOutput = $this->object->getConnection($connection);
		$this->assertEquals($connection, $getterOutput);
		$this->assertTrue($this->object->hasConnection());
	}

	public function testEscapeString()
	{
		$testString = 'Test string to be escaped';
		$escapedString = 'Escaped string';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->once())
			->method('escapeString')
			->with($testString)
			->will($this->returnValue($escapedString));
		$this->object->setConnection($connection);

		$output = $this->object->escapeString($testString);
		$this->assertEquals($escapedString, $output);
	}
}
