<?php

namespace PHPMySql\Test\Unit\Database;

require_once dirname(__DIR__) . '/bootstrap.php';

use PHPMySql\Abstractory\IConnection;
use PHPMySql\Abstractory\IQueryBuilderFactory;
use PHPMySql\DatabaseWrapper;
use PHPMySql\Test\Abstractory\UnitTest;

class DatabaseWrapperTest extends UnitTest
{
	/**
	 * @var IConnection
	 */
	private $connection;

	/**
	 * @var IQueryBuilderFactory
	 */
	private $queryBuilder;

	/**
	 * @var DatabaseWrapper
	 */
	private $object;

	public function setUp()
	{
		$this->connection = $this->mockBuilder()->connection();
		$this->queryBuilder = $this->mockBuilder()->mySqlQueryBuilderFactory();
		$this->object = new DatabaseWrapper($this->connection, $this->queryBuilder);
	}

	public function testQueryReturnsQueryBuilder()
	{
		$this->queryBuilder->expects($this->once())
			->method('query')
			->will($this->returnValue($this->queryBuilder));
		$result = $this->object->query();
		$this->assertSame($this->queryBuilder, $result);
	}

	public function testExecuteSendsQueryToConnection()
	{
		$this->connection->expects($this->once())
			->method('executeQuery');
		$query = $this->getMockBuilder('PHPMySql\Abstractory\AQuery')->disableOriginalConstructor()->getMock();


		$output = $this->object->execute($query);
		$this->assertEquals($this->object, $output);
	}

	public function testBegin()
	{
		$output = $this->object->begin();
		$this->assertEquals($this->object, $output);
	}

	public function testCommit()
	{
		$output = $this->object->commit();
		$this->assertEquals($this->object, $output);
	}

	public function testRollback()
	{
		$output = $this->object->rollback();
		$this->assertEquals($this->object, $output);
	}

	public function testGetData()
	{
		$data = array('some' => 'data');
		$this->connection->expects($this->once())
			->method('getLastResultData')
			->will($this->returnValue($data));
		$this->assertEquals($data, $this->object->getData());
	}

	public function testEscapeString()
	{
		$string = 'Test string to be escaped';
		$escapedString = 'Test escaped string';
		$this->connection->expects($this->once())
			->method('escapeString')
			->with($string)
			->will($this->returnValue($escapedString));

		$output = $this->object->escapeString($string);
		$this->assertEquals($escapedString, $output);
	}
}
