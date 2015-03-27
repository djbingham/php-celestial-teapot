<?php

namespace PHPMySql\Test\Factory;

require_once dirname(__DIR__) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
use PHPMySql\Factory\MySqli as MySqliFactory;

class MySqliTest extends UnitTest
{
	/**
	 * @var MySqliFactory
	 */
	protected $object;

	public function setUp()
	{
		$databaseFactory = $this->mockBuilder()->factory();
		$this->object = new MySqliFactory($databaseFactory);
	}

	public function testConnectionReturnsConnectionFactory()
	{
		$output = $this->object->connection();
		$this->assertInstanceOf('PHPMySql\Factory\MySqli\Connection', $output);
	}

	public function testQueryReturnsQueryBuilderFactory()
	{
		$output = $this->object->query();
		$this->assertInstanceOf('PHPMySql\Factory\MySqli\QueryBuilder', $output);
	}
}
