<?php
namespace PHPMySql\Test\QueryBuilder\MySql\Value;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use PHPMySql\QueryBuilder\MySql\Value\Number;
use PHPMySql\Test\Abstractory\UnitTest;

class NumberTest extends UnitTest
{
	/**
	 * @var Number
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Number();
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
