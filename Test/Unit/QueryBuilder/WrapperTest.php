<?php

namespace SlothMySql\Test\QueryBuilder;

use SlothMySql\Face\ConnectionInterface;
use SlothMySql\Test\Abstractory\UnitTest;
use SlothMySql\QueryBuilder\Wrapper;

class WrapperTest extends UnitTest
{
	/**
	 * @var Wrapper
	 */
    protected $object;

	/**
	 * @var ConnectionInterface
	 */
	protected $connection;

	public function setUp()
	{
		$this->connection = $this->mockBuilder()->connection();
		$this->object = new Wrapper($this->connection);
	}

	public function testQuery()
	{
		$output = $this->object->query();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Factory\Query', $output);
	}

	public function testValue()
	{
		$output = $this->object->value();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Factory\Value', $output);
	}
}
