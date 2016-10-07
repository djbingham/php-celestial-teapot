<?php

namespace Test\QueryBuilder;

use PhpMySql\Face\ConnectionInterface;
use Test\Abstractory\UnitTest;
use PhpMySql\QueryBuilder\Wrapper;

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

	public function testQueryReturnsQueryFactory()
	{
		$output = $this->object->query();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Factory\Query', $output);
	}

	public function testQueryFactoryIsCached()
	{
		$firstFactory = $this->object->query();
		$secondFactory = $this->object->query();
		$this->assertSame($firstFactory, $secondFactory);
	}

	public function testValueReturnsValueFactory()
	{
		$output = $this->object->value();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Factory\Value', $output);
	}

	public function testValueFactoryIsCached()
	{
		$firstFactory = $this->object->value();
		$secondFactory = $this->object->value();
		$this->assertSame($firstFactory, $secondFactory);
	}
}
