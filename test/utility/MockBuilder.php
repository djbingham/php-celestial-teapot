<?php

namespace PHPMySql\Test\Utility;

class MockBuilder extends \PHPUnit_Framework_TestCase
{
	public function databaseWrapper()
	{
		return $this->getMockBuilder('PHPMySql\DatabaseWrapper')
			->disableOriginalConstructor()
			->getMock();
	}

    public function connection()
	{
		return $this->getMockBuilder('PHPMySql\Abstractory\IConnection')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryConstraint()
	{
		return $this->getMockBuilder('PHPMySql\Abstractory\Query\AConstraint')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryJoin()
	{
		return $this->getMockBuilder('PHPMySql\Abstractory\Query\AJoin')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryValue($type = null)
	{
		$class = sprintf('PHPMySql\Abstractory\AValue');
		if (!is_null($type)) {
			$class = sprintf('PHPMySql\QueryBuilder\Value\%s', $type);
		}
		return $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlValueFactory()
	{
		return $this->getMockBuilder('PHPMySql\Abstractory\IValueFactory')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryBuilderFactory()
	{
		return $this->getMockBuilder('PHPMySql\Abstractory\IQueryBuilderFactory')
			->disableOriginalConstructor()
			->getMock();
	}
}
