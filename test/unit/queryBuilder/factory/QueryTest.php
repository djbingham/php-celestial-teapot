<?php

namespace SlothMySql\Test\Unit\Database\QueryBuilder\MySql\Factory;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\Test\Abstractory\UnitTest;
use SlothMySql\QueryBuilder\Factory\Query as QueryFactory;

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
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Query\Select', $output);
	}

	public function testInsert()
	{
		$output = $this->object->insert();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Query\Insert', $output);
		$this->assertFalse($output->isReplaceQuery());
	}

	public function testReplace()
	{
		$output = $this->object->replace();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Query\Insert', $output);
		$this->assertTrue($output->isReplaceQuery());
	}

	public function testUpdate()
	{
		$output = $this->object->update();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Query\Update', $output);
	}

	public function testDelete()
	{
		$output = $this->object->delete();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Query\Delete', $output);
	}

	public function testJoinReturnsJoinFactory()
	{
		$output = $this->object->join();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Factory\Join', $output);
	}

	public function testConstraint()
	{
		$output = $this->object->constraint();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Query\Constraint', $output);
	}
}
