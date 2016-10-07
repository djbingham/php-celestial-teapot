<?php

namespace Test\Unit\Database\QueryBuilder\MySql\Factory;

use Test\Abstractory\UnitTest;
use PhpMySql\QueryBuilder\Factory\Query as QueryFactory;

class QueryTest extends UnitTest
{
	/**
	 * @var QueryFactory
	 */
	protected $object;

	public function setUp()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('wrapper')
			->will($this->returnValue($this->mockBuilder()->databaseWrapper()));
		$this->object = new QueryFactory($connection);
	}

	public function testSelect()
	{
		$output = $this->object->select();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Select', $output);
	}

	public function testInsert()
	{
		$output = $this->object->insert();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Insert', $output);
		$this->assertFalse($output->isReplaceQuery());
	}

	public function testReplace()
	{
		$output = $this->object->replace();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Insert', $output);
		$this->assertTrue($output->isReplaceQuery());
	}

	public function testUpdate()
	{
		$output = $this->object->update();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Update', $output);
	}

	public function testDelete()
	{
		$output = $this->object->delete();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Delete', $output);
	}

	public function testJoinReturnsJoinFactory()
	{
		$output = $this->object->join();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Factory\Join', $output);
	}

	public function testConstraint()
	{
		$output = $this->object->constraint();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Constraint', $output);
	}
}
