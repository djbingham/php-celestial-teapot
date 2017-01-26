<?php
namespace Test\QueryBuilder\Value;

use PhpMySql\Face\ConnectionInterface;
use PhpMySql\QueryBuilder\Value\SqlFunction;
use Test\Abstractory\UnitTest;

class SqlFunctionTest extends UnitTest
{
	/**
	 * @var SqlFunction
	 */
	protected $object;

	/**
	 * @var ConnectionInterface
	 */
	protected $connection;

	public function setup()
	{
		$this->connection = $this->mockBuilder()->connection();
		$this->object = new SqlFunction($this->connection);
	}

	public function testSetFunctionFailsIfFunctionNameIsNotString()
	{
		$this->setExpectedException('\Exception', 'Invalid type specified for name of SQL function. Must be a string.');
		$this->object->setFunction(12);
	}

	public function testSetFunctionFailsIfFunctionNameIsNotRecognised()
	{
		$this->setExpectedException(
			'\Exception',
			sprintf('Invalid name specified for SQL function. Must be one of: AVG, COUNT, MAX, MIN, SUM.')
		);
		$this->object->setFunction('INVALID');
	}

	public function testSetFunctionReturnsFluentInterface()
	{
		$response = $this->object->setFunction('SUM');
		$this->assertSame($this->object, $response);
	}

	public function testSetParamsFailsIfParamsContainsString()
	{
		$params = array('Not a MySqlValue');
		$this->setExpectedException('\Exception');
		$this->object->setParams($params);
	}

	public function testSetParamsFailsIfParamsContainsNumber()
	{
		$params = array(1);
		$this->setExpectedException('\Exception');
		$this->object->setParams($params);
	}

	public function testSetParamsFailsIfParamsContainsArray()
	{
		$params = array(array());
		$this->setExpectedException('\Exception');
		$this->object->setParams($params);
	}

	public function testSetParamsFailsIfParamsContainsNonMySqlValueObject()
	{
		$params = array($this);
		$this->setExpectedException('\Exception');
		$this->object->setParams($params);
	}

	public function testSetParamsReturnsFluentInterface()
	{
		$response = $this->object->setParams([]);
		$this->assertSame($this->object, $response);
	}

	public function testToStringReturnsSqlForFunctionCallWithSingleParameter()
	{
		$parameter = $this->mockBuilder()->queryValue();

		$parameter->expects($this->once())
			->method('__toString')
			->willReturn('"argument"');

		$this->object
			->setFunction('MAX')
			->setParams([$parameter]);

		$this->assertEquals('MAX("argument")', (string)$this->object);
	}

	public function testToStringReturnsSqlForFunctionCallWithSeveralParameters()
	{
		$params = [
			$this->mockBuilder()->queryValue(),
			$this->mockBuilder()->queryValue(),
			$this->mockBuilder()->queryValue()
		];

		foreach ($params as $index => $param) {
			$param->expects($this->once())
				->method('__toString')
				->willReturn((string)($index + 1));
		}

		$this->object
			->setFunction('MAX')
			->setParams($params);

		$this->assertEquals('MAX(1,2,3)', (string)$this->object);
	}
}
