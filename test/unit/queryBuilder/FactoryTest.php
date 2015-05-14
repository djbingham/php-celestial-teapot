<?php

namespace PHPMySql\Test\QueryBuilder;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;
use PHPMySql\QueryBuilder\Wrapper as QueryBuilder;

class FactoryTest extends UnitTest
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
		$this->assertInstanceOf('PHPMySql\QueryBuilder\Factory\Query', $output);
	}

	public function testValue()
	{
		$output = $this->object->value();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\Factory\Value', $output);
	}
}
