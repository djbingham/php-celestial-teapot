<?php
namespace PHPMySql\Test\Unit\Database\Abstractory;

require_once dirname(__DIR__) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
use PHPMySql\Abstractory\QueryBuilder;

class QueryBuilderTest extends UnitTest
{
	/**
	 * @var QueryBuilder
	 */
	protected $object;

	public function setUp()
	{
		$this->object = $this->mock()->databaseQueryBuilder();
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
}
