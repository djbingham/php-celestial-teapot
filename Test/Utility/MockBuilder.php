<?php

namespace Test\Utility;

class MockBuilder extends \PHPUnit_Framework_TestCase
{
	public function databaseWrapper()
	{
		return $this->getMockBuilder('PhpMySql\DatabaseWrapper')
			->disableOriginalConstructor()
			->getMock();
	}

    public function connection()
	{
		return $this->getMockBuilder('PhpMySql\Face\ConnectionInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryConstraint()
	{
		return $this->getMockBuilder('PhpMySql\Face\Query\ConstraintInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryJoin()
	{
		return $this->getMockBuilder('PhpMySql\Face\Query\JoinInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryValue($type = null)
	{
		$class = sprintf('PhpMySql\Face\ValueInterface');
		if (!is_null($type)) {
			$class = sprintf('PhpMySql\QueryBuilder\Value\%s', $type);
		}
		return $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryFactory()
	{
		return $this->getMockBuilder('PhpMySql\Face\QueryFactoryInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlValueFactory()
	{
		return $this->getMockBuilder('PhpMySql\Face\ValueFactoryInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryBuilderFactory()
	{
		return $this->getMockBuilder('PhpMySql\Face\QueryBuilderFactoryInterface')
			->disableOriginalConstructor()
			->getMock();
	}
}
