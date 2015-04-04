<?php
namespace PHPMySql\Test\QueryBuilder\MySql;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;
use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlQuery;

class MySqlQueryTest extends UnitTest
{
	/**
	 * @var MySqlQuery
	 */
	protected $object;

	public function setup()
	{
		$this->object = $this->mock()->databaseQuery();
	}

	public function testSetGetAndHasDatabaseWrapper()
	{
		$wrapper = $this->mockBuilder()->connection();
		$setterOutput = $this->object->setConnection($wrapper);
		$this->assertEquals($this->object, $setterOutput);
		$getterOutput = $this->object->getConnection($wrapper);
		$this->assertEquals($wrapper, $getterOutput);
		$this->assertTrue($this->object->hasConnection());
	}

	public function testEscapeString()
	{
		$testString = 'String to escape';
		$escapedString = 'Escaped string';
		$wrapper = $this->mockBuilder()->connection();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($testString)
			->will($this->returnValue($escapedString));
		$this->object->setConnection($wrapper);
		$output = $this->object->escapeString($testString);
		$this->assertEquals($escapedString, $output);
	}
}
