<?php

namespace SlothMySql\Test\Utility;

class MockBuilder extends \PHPUnit_Framework_TestCase
{
	public function databaseWrapper()
	{
		return $this->getMockBuilder('SlothMySql\DatabaseWrapper')
			->disableOriginalConstructor()
			->getMock();
	}

    public function connection()
	{
		return $this->getMockBuilder('SlothMySql\Face\ConnectionInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryConstraint()
	{
		return $this->getMockBuilder('SlothMySql\Face\Query\ConstraintInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryJoin()
	{
		return $this->getMockBuilder('SlothMySql\Face\Query\JoinInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryValue($type = null)
	{
		$class = sprintf('SlothMySql\Face\ValueInterface');
		if (!is_null($type)) {
			$class = sprintf('SlothMySql\QueryBuilder\Value\%s', $type);
		}
		return $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlValueFactory()
	{
		return $this->getMockBuilder('SlothMySql\Face\ValueFactoryInterface')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryBuilderFactory()
	{
		return $this->getMockBuilder('SlothMySql\Face\QueryBuilderFactoryInterface')
			->disableOriginalConstructor()
			->getMock();
	}
}
