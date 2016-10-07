<?php
namespace Test\QueryBuilder\Value;

use PhpMySql\QueryBuilder\Value\Number;
use Test\Abstractory\UnitTest;

class NumberTest extends UnitTest
{
	/**
	 * @var Number
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Number($this->mockBuilder()->connection());
	}

	public function testSetValueFailsIfValueIsString()
	{
		$value = 'Not a number';
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
