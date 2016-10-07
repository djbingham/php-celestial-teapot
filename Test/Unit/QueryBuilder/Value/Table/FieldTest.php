<?php
namespace Test\QueryBuilder\Value\Table;

use PhpMySql\QueryBuilder\Value\Table\Field;
use Test\Abstractory\UnitTest;

class FieldTest extends UnitTest
{
	/**
	 * @var Field
	 */
	protected $object;

	public function setup()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->returnArgument(0));
		$this->object = new Field($connection);
	}

	public function testWithTableAndField()
	{
		$this->assertEquals($this->object, $this->object->setTable($this->mockTable('testTable')));
		$this->assertEquals($this->object, $this->object->setFieldName('testField'));
		$this->assertEquals('`testTable`.`testField`', (string)$this->object);
	}

	public function testWithFieldOnly()
	{
		$this->assertEquals($this->object, $this->object->setFieldName('testField'));
		$this->assertEquals('`testField`', (string)$this->object);
	}

	public function testAliasIsNotInsertedIntoDefaultString()
	{
		$this->assertEquals($this->object, $this->object->setTable($this->mockTable('testTable')));
		$this->assertEquals($this->object, $this->object->setFieldName('testField'));
		$this->assertEquals($this->object, $this->object->setAlias('testAlias'));
		$this->assertEquals('`testTable`.`testField`', (string)$this->object);
	}

	public function testGetAlias()
	{
		$this->assertEquals($this->object, $this->object->setAlias('testAlias'));
		$this->assertEquals('testAlias', $this->object->getAlias());
	}

	private function mockTable($tableName)
	{
		$table = $this->mockBuilder()->queryValue('table');
		$table->expects($this->once())
			->method('getAlias')
			->will($this->returnValue(sprintf('%s', $tableName)));
		return $table;
	}
}
