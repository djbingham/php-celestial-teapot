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
		return $this->getMockBuilder('SlothMySql\Abstractory\IConnection')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryConstraint()
	{
		return $this->getMockBuilder('SlothMySql\Abstractory\Query\AConstraint')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryJoin()
	{
		return $this->getMockBuilder('SlothMySql\Abstractory\Query\AJoin')
			->disableOriginalConstructor()
			->getMock();
	}

	public function queryValue($type = null)
	{
		$class = sprintf('SlothMySql\Abstractory\AValue');
		if (!is_null($type)) {
			$class = sprintf('SlothMySql\QueryBuilder\Value\%s', $type);
		}
		return $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlValueFactory()
	{
		return $this->getMockBuilder('SlothMySql\Abstractory\IValueFactory')
			->disableOriginalConstructor()
			->getMock();
	}

	public function mySqlQueryBuilderFactory()
	{
		return $this->getMockBuilder('SlothMySql\Abstractory\IQueryBuilderFactory')
			->disableOriginalConstructor()
			->getMock();
	}
}
