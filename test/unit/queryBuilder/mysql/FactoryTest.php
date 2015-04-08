<?php

namespace PHPMySql\Test\Factory\MySqli;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;
use PHPMySql\QueryBuilder\MySql\Wrapper as QueryBuilder;

class QueryBuilderTest extends UnitTest
{
	/**
	 * @var QueryBuilder
	 */
    protected $object;

	public function setUp()
	{
		$connection = $this->mockBuilder()->connection();
		$this->object = new QueryBuilder($connection);
	}

	public function testQuery()
	{
		$output = $this->object->query();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Factory\Query', $output);
	}

	public function testValue()
	{
		$output = $this->object->value();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Factory\Value', $output);
	}
}
