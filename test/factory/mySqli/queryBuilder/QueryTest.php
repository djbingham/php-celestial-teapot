<?php

namespace PHPMySql\Test\Unit\Database\QueryBuilder\MySql\Factory;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
use PHPMySql\Factory\MySqli\QueryBuilder\Query as QueryFactory;

class QueryTest extends UnitTest
{
	/**
	 * @var QueryFactory
	 */
	protected $object;

	public function setUp()
	{
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->any())
			->method('wrapper')
			->will($this->returnValue($this->mockBuilder()->databaseWrapper()));
		$this->object = new QueryFactory($databaseFactory);
	}

	public function testSelect()
	{
		$output = $this->object->select();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Select', $output);
	}

	public function testInsert()
	{
		$output = $this->object->insert();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Insert', $output);
	}

	public function testUpdate()
	{
		$output = $this->object->update();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Update', $output);
	}

	public function testDelete()
	{
		$output = $this->object->delete();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Delete', $output);
	}

	public function testJoinReturnsJoinFactory()
	{
		$output = $this->object->join();
		$this->assertInstanceOf('PHPMySql\Factory\MySqli\QueryBuilder\Join', $output);
	}

	public function testConstraint()
	{
		$output = $this->object->constraint();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Constraint', $output);
	}
}
