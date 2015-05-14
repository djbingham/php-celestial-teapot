<?php
namespace PHPMySql\Test\QueryBuilder\Value;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use PHPMySql\QueryBuilder\Value\Table;
use PHPMySql\Test\Abstractory\UnitTest;

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

	public function testField()
	{
		$tableName = 'T1';
		$fieldNames = array('F1', 'F2');
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($tableName, $fieldNames[0], $tableName, $fieldNames[1]));

		$object = new Table($connection);
		$object->setTableName($tableName);
		// Create two fields
		$field0 = $object->field($fieldNames[0]);
		$field1 = $object->field($fieldNames[1]);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\Value\Table\Field', $field0);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\Value\Table\Field', $field1);
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
		$this->assertInstanceOf('PHPMySql\QueryBuilder\Value\Table\Data', $output1);
		// Fetch the data instance and verify that it is the same
		$output2 = $object->data();
		$this->assertEquals($output1, $output2);
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
