<?php
namespace SlothMySql\Test\QueryBuilder\Value;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\QueryBuilder\Value\Table;
use SlothMySql\Test\Abstractory\UnitTest;

class TableTest extends UnitTest
{
    public function testSetAndGetTableName()
	{
		$name = 'T1';
		$object = new Table($this->mockBuilder()->connection());

		$setterOutput = $object->setTableName($name);
		$this->assertEquals($object, $setterOutput);

		$getterOutput = $object->getTableName();
		$this->assertEquals($name, $getterOutput);
	}

	public function testSetAndGetAlias()
	{
		$alias = 'T1';
		$object = new Table($this->mockBuilder()->connection());

		$setterOutput = $object->setAlias($alias);
		$this->assertEquals($object, $setterOutput);

		$getterOutput = $object->getAlias();
		$this->assertEquals($alias, $getterOutput);
	}

	public function testGetAliasFallsBackToTableName()
	{
		$name = 'T1';
		$object = new Table($this->mockBuilder()->connection());

		$setterOutput = $object->setTableName($name);
		$this->assertEquals($object, $setterOutput);

		$getterOutput = $object->getAlias();
		$this->assertEquals($name, $getterOutput);
	}

	public function testField()
	{
		$tableName = 'T1';
		$fieldNames = array('F1', 'F2');
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->exactly(4))
			->method('escapeString')
			->will($this->returnValueMap(array(
				array($tableName, $tableName),
				array($fieldNames[0], $fieldNames[0]),
				array($fieldNames[1], $fieldNames[1])
			)));

		$object = new Table($connection);
		$object->setTableName($tableName);
		// Create two fields
		$field0 = $object->field($fieldNames[0]);
		$field1 = $object->field($fieldNames[1]);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $field0);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $field1);
		// Fetch each field by name and check that the same instances are returned
		$fetchedField0 = $object->field($fieldNames[0]);
		$fetchedField1 = $object->field($fieldNames[1]);
		$this->assertEquals('`'.$tableName.'`.`'.$fieldNames[0].'`', (string) $fetchedField0);
		$this->assertEquals('`'.$tableName.'`.`'.$fieldNames[1].'`', (string) $fetchedField1);
	}

	public function testData()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->once())
			->method('value')
			->will($this->returnValue($this->mockValueFactory()));

		$object = new Table($this->mockBuilder()->connection());

		// Create a data instance
		$output1 = $object->data();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Data', $output1);
		// Fetch the data instance and verify that it is the same
		$output2 = $object->data();
		$this->assertEquals($output1, $output2);
	}

	public function testToStringWithoutAlias()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->once())
			->method('escapeString')
			->with('TableName')
			->will($this->returnValue('TableName'));

		$object = new Table($connection);
		$object->setTableName('TableName');

		$this->assertEquals('`TableName`', (string)$object);
	}

	public function testToStringWithAlias()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->exactly(2))
			->method('escapeString')
			->will($this->returnValueMap(array(
				array('TableName', 'TableName'),
				array('TableAlias', 'TableAlias')
			)));

		$object = new Table($connection);
		$object->setTableName('TableName')
			->setAlias('TableAlias');

		$this->assertEquals('`TableName` AS `TableAlias`', (string)$object);
	}

	private function mockValueFactory()
	{
		$valueFactory = $this->mockBuilder()->mySqlValueFactory();
		$valueFactory->expects($this->once())
			->method('sqlConstant')
			->with('NULL')
			->will($this->returnValue($this->mockBuilder()->queryValue()));
		return $valueFactory;
	}
}
