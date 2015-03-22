<?php
namespace PHPMySql\Test\Unit\Database\Abstractory;

require_once dirname(__DIR__) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
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
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$setterOutput = $this->object->setDatabaseWrapper($wrapper);
		$this->assertEquals($this->object, $setterOutput);
		$getterOutput = $this->object->getDatabaseWrapper($wrapper);
		$this->assertEquals($wrapper, $getterOutput);
		$this->assertTrue($this->object->hasDatabaseWrapper());
	}

	public function testEscapeString()
	{
		$testString = 'Test string to be escaped';
		$escapedString = 'Escaped string';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($testString)
			->will($this->returnValue($escapedString));
		$this->object->setDatabaseWrapper($wrapper);

		$output = $this->object->escapeString($testString);
		$this->assertEquals($escapedString, $output);
	}
}
