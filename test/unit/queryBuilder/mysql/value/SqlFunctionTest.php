<?php
namespace PHPMySql\Test\QueryBuilder\MySql\Value;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use PHPMySql\QueryBuilder\MySql\Value\SqlFunction;
use PHPMySql\Test\Abstractory\UnitTest;

class SqlFunctionTest extends UnitTest
{
	/**
	 * @var SqlFunction
	 */
	protected $object;

	public function setup()
	{
		$this->object = new SqlFunction();
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
