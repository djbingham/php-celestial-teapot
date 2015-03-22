<?php

namespace PHPMySql\Test;

class MockBuilder extends \PHPUnit_Framework_TestCase
{
	public function databaseWrapper()
	{
		return $this->getMockBuilder('PHPMySql\DatabaseWrapper')
			->disableOriginalConstructor()
			->getMock();
	}

    public function connectionWrapper()
	{
		return $this->getMockBuilder('PHPMySql\Abstractory\ConnectionWrapper')
			->disableOriginalConstructor()
			->getMock();
	}

	public function connectionOptions()
	{
		return $this->getMockBuilder('PHPMySql\Connector\ConnectionOptions')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQuery($type)
	{
		return $this->getMockBuilder(sprintf('PHPMySql\QueryBuilder\MySql\Query\%s', $type))
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryConstraint()
	{
		return $this->getMockBuilder('PHPMySql\QueryBuilder\MySql\Query\Constraint')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryJoin()
	{
		return $this->getMockBuilder('PHPMySql\QueryBuilder\MySql\Query\Join')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryValue($type = null)
	{
		$class = sprintf('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue');
		if (!is_null($type)) {
			$class = sprintf('PHPMySql\QueryBuilder\MySql\Value\%s', $type);
		}
		return $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqliFactory()
	{
		return $this->getMockBuilder('PHPMySql\Factory\MySqli')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlValueFactory()
	{
		return $this->getMockBuilder('PHPMySql\Factory\MySqli\QueryBuilder\Value')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryBuilderFactory()
	{
		return $this->getMockBuilder('PHPMySql\Factory\MySqli\QueryBuilder')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryFactory()
	{
		return $this->getMockBuilder('PHPMySql\Factory\MySqli\QueryBuilder\Query')
			->disableOriginalConstructor()
			->getMock();
	}
}
