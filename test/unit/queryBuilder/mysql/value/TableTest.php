<?php
namespace PHPMySql\Test\QueryBuilder\MySql\Value;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use PHPMySql\QueryBuilder\MySql\Value\Table;
use PHPMySql\Test\Abstractory\UnitTest;

class TableTest extends UnitTest
{
    /**
     * @var Table
     */
	protected $object;

	public function setup()
	{
		$this->object = new Table();
	}

    public function testSetAndGetTableName()
	{
		$name = 'T1';
		$setterOutput = $this->object->setTableName($name);
		$this->assertEquals($this->object, $setterOutput);
		$getterOutput = $this->object->getTableName();
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
		$this->object->setConnection($connection);
		$this->object->setTableName($tableName);
		// Create two fields
		$field0 = $this->object->field($fieldNames[0]);
		$field1 = $this->object->field($fieldNames[1]);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $field0);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $field1);
		// Fetch each field by name and check that the same instances are returned
		$fetchedField0 = $this->object->field($fieldNames[0]);
		$fetchedField1 = $this->object->field($fieldNames[1]);
		$this->assertEquals('`'.$tableName.'`.`'.$fieldNames[0].'`', (string) $fetchedField0);
		$this->assertEquals('`'.$tableName.'`.`'.$fieldNames[1].'`', (string) $fetchedField1);
	}

	protected function mockValueFactory()
	{
		$valueFactory = $this->mockBuilder()->mySqlValueFactory();
		$valueFactory->expects($this->once())
			->method('sqlConstant')
			->with('NULL')
			->will($this->returnValue($this->mockBuilder()->queryValue()));
		return $valueFactory;
	}

	public function testData()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->once())
			->method('value')
			->will($this->returnValue($this->mockValueFactory()));
		$this->object->setConnection($connection);
		// Create a data instance
		$output1 = $this->object->data();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Data', $output1);
		// Fetch the data instance and verify that it is the same
		$output2 = $this->object->data();
		$this->assertEquals($output1, $output2);
	}
}
