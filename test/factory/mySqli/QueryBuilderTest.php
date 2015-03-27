<?php

namespace PHPMySql\Test\Factory\MySqli;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
use PHPMySql\Factory\MySqli\QueryBuilder as QueryBuilderFactory;

class QueryBuilderTest extends UnitTest
{
	/**
	 * @var QueryBuilderFactory
	 */
    protected $object;

	public function setUp()
	{
		$databaseFactory = $this->mockBuilder()->factory();
		$this->object = new QueryBuilderFactory($databaseFactory);
	}

	public function testQuery()
	{
		$output = $this->object->query();
		$this->assertInstanceOf('PHPMySql\Factory\MySqli\QueryBuilder\Query', $output);
	}

	public function testValue()
	{
		$output = $this->object->value();
		$this->assertInstanceOf('PHPMySql\Factory\MySqli\QueryBuilder\Value', $output);
	}

	public function testJoin()
	{
		$output = $this->object->join();
		$this->assertInstanceOf('PHPMySql\Factory\MySqli\QueryBuilder\Join', $output);
	}
}
