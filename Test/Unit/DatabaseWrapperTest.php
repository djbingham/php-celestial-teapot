<?php

namespace Test\Unit\Database;

use PhpMySql\Face\ConnectionInterface;
use PhpMySql\Face\QueryBuilderFactoryInterface;
use PhpMySql\DatabaseWrapper;
use PhpMySql\Face\QueryFactoryInterface;
use PhpMySql\Face\ValueFactoryInterface;
use Test\Abstractory\UnitTest;

class DatabaseWrapperTest extends UnitTest
{
	/**
	 * @var ConnectionInterface
	 */
	private $connection;

	/**
	 * @var QueryBuilderFactoryInterface
	 */
	private $queryBuilderFactory;

	/**
	 * @var QueryFactoryInterface
	 */
	private $queryBuilder;

	/**
	 * @var ValueFactoryInterface
	 */
	private $valueBuilder;

	/**
	 * @var DatabaseWrapper
	 */
	private $object;

	public function setUp()
	{
		$this->connection = $this->mockBuilder()->connection();
		$this->queryBuilderFactory = $this->mockBuilder()->mySqlQueryBuilderFactory();
		$this->queryBuilder = $this->mockBuilder()->mySqlQueryFactory();
		$this->valueBuilder = $this->mockBuilder()->mySqlValueFactory();
		$this->object = new DatabaseWrapper($this->connection, $this->queryBuilderFactory);
	}

	public function testQueryReturnsQueryBuilder()
	{
		$this->queryBuilderFactory->expects($this->once())
			->method('query')
			->will($this->returnValue($this->queryBuilder));
		$result = $this->object->query();
		$this->assertSame($this->queryBuilder, $result);
	}

	public function testValueReturnsValueBuilder()
	{
		$this->queryBuilderFactory->expects($this->once())
			->method('value')
			->will($this->returnValue($this->valueBuilder));
		$result = $this->object->value();
		$this->assertSame($this->valueBuilder, $result);
	}

	public function testExecuteSendsQueryToConnection()
	{
		$this->connection->expects($this->once())
			->method('executeQuery');
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();


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
