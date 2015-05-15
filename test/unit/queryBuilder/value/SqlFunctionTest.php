<?php
namespace SlothMySql\Test\QueryBuilder\Value;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\QueryBuilder\Value\SqlFunction;
use SlothMySql\Test\Abstractory\UnitTest;

class SqlFunctionTest extends UnitTest
{
	/**
	 * @var SqlFunction
	 */
	protected $object;

	public function setup()
	{
		$this->object = new SqlFunction($this->mockBuilder()->connection());
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
}
