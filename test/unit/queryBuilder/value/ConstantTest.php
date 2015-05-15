<?php
namespace SlothMySql\Test\QueryBuilder\Value;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\QueryBuilder\Value\Constant;
use SlothMySql\Test\Abstractory\UnitTest;

class ConstantTest extends UnitTest
{
	/**
	 * @var Constant
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Constant($this->mockBuilder()->connection());
	}

	public function testSetValue()
	{
		$this->object->setValue('NULL');
		$this->assertEquals('NULL', (string)$this->object);
		$this->object->setValue('CURRENT_TIMESTAMP');
		$this->assertEquals('CURRENT_TIMESTAMP', (string)$this->object);
	}

	public function testSetValueFailsIfValueIsInvalidString()
	{
		$value = 'Not a constant';
		$this->setExpectedException('\Exception');
		$this->object->setValue($value);
	}

	public function testSetValueFailsIfValueIsNumber()
	{
		$value = 1;
		$this->setExpectedException('\Exception');
		$this->object->setValue($value);
	}

	public function testSetValueFailsIfValueIsArray()
	{
		$value = array();
		$this->setExpectedException('\Exception');
		$this->object->setValue($value);
	}

	public function testSetValueFailsIfValueIsObject()
	{
		$value = $this;
		$this->setExpectedException('\Exception');
		$this->object->setValue($value);
	}
}
