<?php
namespace Test\QueryBuilder\Value;

use PhpMySql\QueryBuilder\Value\Constant;
use Test\Abstractory\UnitTest;

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

	public function testSetValueToNull()
	{
		$this->object->setValue('NULL');
		$this->assertEquals('NULL', (string)$this->object);
	}

	public function testSetValueToTrue()
	{
		$this->object->setValue('TRUE');
		$this->assertEquals('TRUE', (string)$this->object);
	}

	public function testSetValueToFalse()
	{
		$this->object->setValue('FALSE');
		$this->assertEquals('FALSE', (string)$this->object);
	}

	public function testSetValueToCurrentTimestamp()
	{
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
